<?php

namespace app\modules\DatabaseSyncModule\models;

use Yii;
use yii\base\Model;
use yii\db\Connection;
use yii\db\Exception;
use app\modules\DatabaseSyncModule\Logger;

class DatabaseSyncService extends Model
{
    public function __construct(private readonly DatabaseSyncConfig $config)
    {
        parent::__construct();
    }

    /**
     * Запускает процесс синхронизации.
     *
     * @return bool Возвращает true, если синхронизация прошла успешно.
     */
    public function sync(): bool
    {
        $config = $this->config;
        $transaction = $config->targetDb->beginTransaction();

        try {
            Logger::echoLog("Синхронизация началась...\n");

            $sourceDbName = self::getDbName($config->sourceDb);
            $targetDbName = self::getDbName($config->targetDb);

            $tables = $config->sourceDb->createCommand("SHOW FULL TABLES WHERE TABLE_TYPE LIKE 'BASE TABLE';")->queryAll();

            // Выключение проверки внешних ключей
            $this->disableForeignKeyChecks($config->targetDb);

            $this->syncTablesStructure($tables, $sourceDbName);

            // Перенос хранимых процедур и триггеров
            if (!$config->noProcedures) {
                $this->syncStoredProcedures($config->sourceDb, $config->targetDb, $sourceDbName, $targetDbName);
            }
            if (!$config->noTriggers) {
                $this->syncTriggers($config->sourceDb, $config->targetDb, $sourceDbName, $targetDbName);
            }

            // Перенос представлений и событий
            if (!$config->noViews) {
                $this->syncViews($config->sourceDb, $config->targetDb, $sourceDbName);
            }
            if (!$config->noEvents) {
                $this->syncEvents($config->sourceDb, $config->targetDb);
            }

            // Перенос данных
            if (!$config->noData) {
                $this->syncTablesData($tables, $config->sourceDb, $config->targetDb, $sourceDbName);
            }

            $this->enableForeignKeyChecks($config->targetDb);
            $transaction->commit();

            Logger::echoLog("Синхронизация успешно завершена.");

            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();

            Logger::echoError("Ошибка синхронизации: " . $e->getMessage());

            return false;
        }
    }

    /**
     * Синхронизация структуры всех таблиц
     *
     * @param array $tables
     * @param string $sourceDbName
     * @return void
     * @throws Exception
     */
    private function syncTablesStructure(array $tables, string $sourceDbName): void
    {
        $isNotEmpty = boolval(count($tables));

        if ($isNotEmpty) {
            Logger::echoLog("Перенос структуры таблиц начался...");
        }

        // Перенос структуры таблиц
        foreach ($tables as $table) {
            $this->syncTableStructure($this->config->sourceDb, $this->config->targetDb, $table['Tables_in_' . $sourceDbName]);
        }

        if ($isNotEmpty) {
            Logger::echoLog("Перенос структуры таблиц завершен.\n");
        } else {
            Logger::echoLog("Нет таблиц для переноса структуры.\n");
        }
    }

    /**
     * Синхронизирует структуру таблицы.
     *
     * @param Connection $sourceDb Исходная база данных.
     * @param Connection $targetDb Целевая база данных.
     * @param string $tableName Имя таблицы.
     * @throws Exception
     */
    private function syncTableStructure(Connection $sourceDb, Connection $targetDb, string $tableName): void
    {
        // Проверка на существование таблицы в целевой БД
        if ($targetDb->schema->getTableSchema($tableName, true) !== null) {
            $targetDb->createCommand("DROP TABLE IF EXISTS `{$tableName}`;")->execute();
            Yii::info("Дублирующаяся таблица удалена $tableName.");
        }

        $createTableSql = $sourceDb->createCommand("SHOW CREATE TABLE `{$tableName}`")->queryOne();
        $targetDb->createCommand($createTableSql['Create Table'])->execute();

        Logger::echoLog("Синхронизация структуры таблицы $tableName - успешно.");
    }

    /**
     * Переносит представления.
     *
     * @param Connection $sourceDb Исходная база данных.
     * @param Connection $targetDb Целевая база данных.
     * @throws Exception
     */
    private function syncViews(Connection $sourceDb, Connection $targetDb, string $sourceDbName): void
    {
        $views = $sourceDb->createCommand("SHOW FULL TABLES WHERE TABLE_TYPE LIKE 'VIEW';")->queryAll();
        $isNotEmpty = boolval(count($views));

        if ($isNotEmpty) {
            Logger::echoLog("Перенос представлений начался...");
        }

        foreach ($views as $view) {
            $viewName = $view['Tables_in_' . $sourceDbName];

            // Проверка на существование представления в целевой БД и его удаление
            if ($targetDb->schema->getTableSchema($viewName, true) !== null) {
                $targetDb->createCommand("DROP VIEW IF EXISTS `{$viewName}`;")->execute();
            }

            $createViewSql = $sourceDb->createCommand("SHOW CREATE VIEW `{$viewName}`")->queryOne();
            $targetDb->createCommand($createViewSql['Create View'])->execute();

            Logger::echoLog("Перенос представления $viewName - успешно.");
        }

        if ($isNotEmpty) {
            Logger::echoLog("Перенос представлений завершен.\n");
        } else {
            Logger::echoLog("Нет пердставлений для переноса.\n");
        }
    }

    /**
     * Переносит события.
     *
     * @param Connection $sourceDb Исходная база данных.
     * @param Connection $targetDb Целевая база данных.
     * @throws Exception
     */
    private function syncEvents(Connection $sourceDb, Connection $targetDb): void
    {
        $events = $sourceDb->createCommand("SHOW EVENTS;")->queryAll();
        $isNotEmpty = boolval(count($events));

        if ($isNotEmpty) {
            Logger::echoLog("Перенос событий начался...");
        }

        foreach ($events as $event) {
            $eventName = $event['Name'];

            // Удаление существующего события в целевой БД, если оно есть
            $existingEvents = $targetDb->createCommand("SHOW EVENTS WHERE `Name` = :name", [':name' => $eventName])->queryAll();

            if (!empty($existingEvents)) {
                $targetDb->createCommand("DROP EVENT IF EXISTS `{$eventName}`;")->execute();
            }

            $createEventSql = $sourceDb->createCommand("SHOW CREATE EVENT `{$eventName}`")->queryOne();
            $targetDb->createCommand($createEventSql['Create Event'])->execute();

            Logger::echoLog("Перенос события $eventName - успешно.");
        }

        if ($isNotEmpty) {
            Logger::echoLog("Перенос событий успешно завершен.\n");
        } else {
            Logger::echoLog("Нет событий для переноса.\n");
        }
    }

    /**
     * Переносит данные всех таблиц.
     *
     * @param array $tables
     * @param Connection $sourceDb
     * @param Connection $targetDb
     * @param string $sourceDbName
     * @return void
     * @throws Exception
     */
    private function syncTablesData(array $tables, Connection $sourceDb, Connection $targetDb, string $sourceDbName): void
    {
        $isNotEmpty = boolval(count($tables));

        if ($isNotEmpty) {
            Logger::echoLog("Перенос данных таблиц начался...");
        }

        foreach ($tables as $table) {
            $this->syncTableData($sourceDb, $targetDb, $table['Tables_in_' . $sourceDbName]);
        }

        if ($isNotEmpty) {
            Logger::echoLog("Перенос данных таблиц завершен.\n");
        } else {
            Logger::echoLog("Нет данных таблиц для переноса.\n");
        }
    }

    /**
     * Переносит данные таблицы.
     *
     * @param Connection $sourceDb Исходная база данных.
     * @param Connection $targetDb Целевая база данных.
     * @param string $tableName Имя таблицы.
     * @throws Exception
     */
    private function syncTableData(Connection $sourceDb, Connection $targetDb, string $tableName): void
    {
        Logger::echoLog("Перенос данных для таблицы $tableName...");

        $columns = $sourceDb->getTableSchema($tableName)->getColumnNames();
        $query = (new \yii\db\Query())
            ->from($tableName)
            ->select($columns);

        // Итерация по записям таблицы пакетами
        foreach ($query->batch($this->config->batchSize, $sourceDb) as $rows) {
            $targetDb->createCommand()->batchInsert($tableName, $columns, $rows)->execute();
            $count = count($rows);
            Logger::echoLog("Перенос данных для таблицы $tableName | $count элементов перенесено.");
        }

        Logger::echoLog("Перенос данных для таблицы $tableName успешно завершен.");
    }

    /**
     * Переносит хранимые процедуры.
     *
     * @param Connection $sourceDb Исходная база данных.
     * @param Connection $targetDb Целевая база данных.
     * @throws Exception
     */
    private function syncStoredProcedures(Connection $sourceDb, Connection $targetDb, string $sourceDbName, string $targetDbName): void
    {
        $procedures = $sourceDb->createCommand("SHOW PROCEDURE STATUS WHERE Db = :dbName", [':dbName' => $sourceDbName])->queryAll();
        $isNotEmpty = boolval(count($procedures));

        if ($isNotEmpty) {
            Logger::echoLog("Перенос хранимых процедур начался...");
        }

        foreach ($procedures as $procedure) {
            $name = $procedure['Name'];

            // Проверка и удаление существующей процедуры
            $existingProcedures = $targetDb->createCommand("SHOW PROCEDURE STATUS WHERE Db = :dbName AND Name = :name", [
                ':dbName' => $targetDbName,
                ':name' => $name
            ])->queryAll();

            if (!empty($existingProcedures)) {
                $targetDb->createCommand("DROP PROCEDURE IF EXISTS `{$name}`;")->execute();
                Logger::echoLog("Дублирующаяся процедура $name удалена.");
            }

            $createProcedureSql = $sourceDb->createCommand("SHOW CREATE PROCEDURE `{$name}`")->queryOne();
            $targetDb->createCommand($createProcedureSql['Create Procedure'])->execute();

            Logger::echoLog("Хранимая процедура $name перенесена.");
        }

        if ($isNotEmpty) {
            Logger::echoLog("Перенос хранимых процедур завершен.\n");
        } else {
            Logger::echoLog("Нет хранимых процедур для переноса.\n");
        }
    }

    /**
     * Переносит триггеры.
     *
     * @param Connection $sourceDb Исходная база данных.
     * @param Connection $targetDb Целевая база данных.
     * @throws Exception
     */
    private function syncTriggers(Connection $sourceDb, Connection $targetDb, string $sourceDbName, string $targetDbName): void
    {
        $triggers = $sourceDb->createCommand("SHOW TRIGGERS FROM `$sourceDbName`")->queryAll();
        $isNotEmpty = boolval(count($triggers));

        if ($isNotEmpty) {
            Logger::echoLog("Перенос триггеров начался...");
        }

        foreach ($triggers as $trigger) {
            $name = $trigger['Trigger'];
            // Проверка и удаление существующего триггера
            $existingTriggers = $targetDb->createCommand("SHOW TRIGGERS FROM `$targetDbName` WHERE `Trigger` = :name", [':name' => $name])->queryAll();

            if (!empty($existingTriggers)) {
                $targetDb->createCommand("DROP TRIGGER IF EXISTS `{$name}`;")->execute();
                Logger::echoLog("Дублирующийся триггер $name удален.");
            }

            $createTriggerSql = $sourceDb->createCommand("SHOW CREATE TRIGGER `{$name}`")->queryOne();
            $targetDb->createCommand($createTriggerSql['SQL Original Statement'])->execute();

            Logger::echoLog("Триггер $name перенесен.");
        }

        if ($isNotEmpty) {
            Logger::echoLog("Перенос триггеров завершен.\n");
        } else {
            Logger::echoLog("Нет триггеров для переноса.\n");
        }
    }

    /* ------------------------------------------------------ */
    /**
     * Получает имя базы данных из DSN строки подключения.
     *
     * @param Connection $db Экземпляр подключения к базе данных.
     * @return string|null Возвращает имя базы данных или null.
     */
    private static function getDbName(Connection $db): ?string
    {
        preg_match('/dbname=([^;]*)/', $db->dsn, $matches);
        return $matches[1] ?? null;
    }

    /**
     * Отключает проверку внешних ключей.
     *
     * @param Connection $db Экземпляр подключения к базе данных.
     * @throws Exception
     */
    private static function disableForeignKeyChecks(Connection $db): void
    {
        $db->createCommand("SET FOREIGN_KEY_CHECKS=0;")->execute();
    }

    /**
     * Включает проверку внешних ключей.
     *
     * @param Connection $db Экземпляр подключения к базе данных.
     * @throws Exception
     */
    private static function enableForeignKeyChecks(Connection $db): void
    {
        $db->createCommand("SET FOREIGN_KEY_CHECKS=1;")->execute();
    }
}