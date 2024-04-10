<?php

namespace app\modules\DatabaseSyncModule\models;

use Yii;
use yii\base\Model;
use app\modules\DatabaseSyncModule\Logger;

class DatabaseSyncCronService extends Model
{
    public function __construct(private readonly DatabaseSyncConfig $config)
    {
        parent::__construct();
    }

    /**
     * Создаёт задачу в cron по заданным параметрам
     * @return bool
     */
    public function addCronTask(): bool
    {
        $config = $this->config;
        $appPath = Yii::getAlias('@app');

        // Параметры для добавления задачи в cron
        $schedule = "{$config->minutes} {$config->hours} */{$config->daysInterval} * *";

        $params = "--sourceDb={$config->sourceDb} --targetDb={$config->targetDb} --batchSize={$config->batchSize}";
        $params = $this->addFlagsParams($params);

        $fullCommand = "{$schedule} cd {$appPath} && /usr/local/bin/php yii database-sync-module/database-sync {$params} >> /var/log/cron.log 2>&1";

        try {
            // Получение текущего списка задач cron
            exec('crontab -l', $cronJobs);
            if (in_array($fullCommand, $cronJobs)) {
                Logger::echoLog("Идентичная задача на синхронизацию баз уже добавлена в Cron.\n");
                return false;
            }

            // Добавление новой задачи
            $cronJobs = array_filter($cronJobs, 'trim');
            $cronJobs[] = $fullCommand;

            // Обновление списка задач cron
            $cronContents = implode(PHP_EOL, $cronJobs) . PHP_EOL;
            exec('echo "' . $cronContents . '" | crontab -', $output, $returnVar);

            if ($result = $returnVar === 0) {
                Logger::echoLog("Задача на синхронизацию баз успешно добавлена в Cron.\n");
            } else {
                Logger::echoError("Не удалось добавить задачу на синхронизацию баз в Cron.\n");
            }

            return $result;

        } catch (\Exception $e) {
            Logger::echoError("Ошибка добавления задачи на синхронизацию баз в Cron: " . $e->getMessage() . "\n");
            return false;
        }
    }

    /**
     * Удаляет все cron задачи, связанные с командой синхронизации баз данных.
     * @return bool
     */
    public static function removeCronTasks(): bool
    {
        try {
            // Получение текущего списка задач cron
            exec('crontab -l', $cronJobs);

            $beforeCronJobsCount = count($cronJobs);

            // Формируем паттерн для поиска задач, связанных с модулем
            $pattern = '/' . preg_quote('cd ' . Yii::getAlias('@app') . ' && /usr/local/bin/php yii database-sync-module', '/') . '/';
            // Удаление задач, соответствующих паттерну
            $cronJobs = preg_grep($pattern, $cronJobs, PREG_GREP_INVERT);

            $removedJobsCount = $beforeCronJobsCount - count($cronJobs);

            if ($removedJobsCount > 0) {
                // Обновление списка задач cron
                $cronContents = implode(PHP_EOL, $cronJobs);
                exec('echo "' . $cronContents . '" | crontab -', $output, $returnVar);

                if ($result = $returnVar === 0) {
                    Logger::echoLog("{$removedJobsCount} задач на синхронизацию баз данных успешно очищено в Cron.\n");
                } else {
                    Logger::echoError("Не удалось очистить задачи на синхронизацию баз данных в Cron.\n");
                }

                return $result;
            } else {
                Logger::echoLog("Не найдено задач на синхронизацию баз данных для очистки в Cron.\n");
                return true;
            }

        } catch (\Exception $e) {
            Logger::echoError("Ошибка очистки задач на синхронизацию баз в Cron: " . $e->getMessage() . "\n");
            return false;
        }
    }

    /**
     * Добавляет в строку параметров флаги
     * @param $params
     * @return string
     */
    private function addFlagsParams($params): string
    {
        if ($this->config->noData) {
            $params .= ' --noData';
        }

        if ($this->config->noProcedures) {
            $params .= ' --noProcedures';
        }

        if ($this->config->noTriggers) {
            $params .= ' --noTriggers';
        }

        if ($this->config->noViews) {
            $params .= ' --noViews';
        }

        if ($this->config->noEvents) {
            $params .= ' --noEvents';
        }

        return $params;
    }
}