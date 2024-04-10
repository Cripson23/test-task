<?php

namespace app\modules\DatabaseSyncModule\commands;

use Yii;
use yii\base\InvalidConfigException;
use yii\console\Controller;
use yii\di\NotInstantiableException;
use app\modules\DatabaseSyncModule\Logger;
use app\modules\DatabaseSyncModule\models\DatabaseSyncConfig;
use app\modules\DatabaseSyncModule\models\DatabaseSyncService;
use app\modules\DatabaseSyncModule\models\DatabaseSyncCronService;

class DatabaseSyncController extends Controller
{
    private DatabaseSyncConfig $config;

    // типы не указаны, дабы валидация работала в полной мере
    public $sourceDb;
    public $targetDb;
    public $batchSize;

    public $noData;
    public $noProcedures;
    public $noTriggers;
    public $noViews;
    public $noEvents;

    public $hours;
    public $minutes;
    public $daysInterval;

    /**
     * @return void
     * @throws InvalidConfigException
     * @throws NotInstantiableException
     */
    public function init(): void
    {
        parent::init();
        $this->config = Yii::$container->get(DatabaseSyncConfig::class);
    }

    /**
     * Возвращает список параметров, специфичных для действия.
     *
     * @param string $actionID Идентификатор действия.
     * @return array Список параметров, доступных для действия.
     */
    public function options($actionID): array
    {
        if ($actionID == 'index') {
            /* --batchSize=1000 --targetDb=db --sourceDb=db_prod --noData --noProcedures --noTriggers */
            return [
                'sourceDb', 'targetDb', 'batchSize',
                'noData', 'noProcedures', 'noTriggers', 'noViews', 'noEvents'
            ];
        } else if ($actionID == 'add-cron-task') {
            return [
                'sourceDb', 'targetDb', 'batchSize',
                'noData', 'noProcedures', 'noTriggers', 'noViews', 'noEvents',
                'hours', 'minutes', 'daysInterval'
            ];
        }

        return [];
    }

    /**
     * Сокращения названия параметров.
     *
     * @return string[]
     */
    public function optionAliases(): array
    {
        /* -tdb=db -sdb=db_prod -bs=1000 -nd -np -nt */
        return [
            'tdb' => 'targetDb', 'sdb' => 'sourceDb', 'bs' => 'batchSize',
            'nd' => 'noData', 'np' => 'noProcedures', 'nt' => 'noTriggers', 'nv' => 'noViews', 'ne' => 'noEvents',
            'h' => 'hours', 'm' => 'minutes', 'di' => 'daysInterval'
        ];
    }

    /**
     * Инициализация параметров конфигурации
     * @param $action
     * @return bool
     */
    public function beforeAction($action): bool
    {
        if (parent::beforeAction($action)) {
            // Передаем значения параметров в конфигурационный объект
            $this->config->sourceDb = $this->sourceDb ?? $this->config->sourceDb;
            $this->config->targetDb = $this->targetDb ?? $this->config->targetDb;
            $this->config->batchSize = $this->batchSize ?? $this->config->batchSize;

            $this->config->noData = $this->noData ?? $this->config->noData;
            $this->config->noProcedures = $this->noProcedures ?? $this->config->noProcedures;
            $this->config->noTriggers = $this->noTriggers ?? $this->config->noTriggers;
            $this->config->noViews = $this->noViews ?? $this->config->noViews;
            $this->config->noEvents = $this->noEvents ?? $this->config->noEvents;

            $this->config->hours = $this->hours ?? $this->config->hours;
            $this->config->minutes = $this->minutes ?? $this->config->minutes;
            $this->config->daysInterval = $this->daysInterval ?? $this->config->daysInterval;

            return true;
        }
        return false;
    }

    /**
     * Действие /data-base-sync
     *
     * @return bool
     * @throws InvalidConfigException
     * @throws NotInstantiableException
     */
    public function actionIndex(): bool
    {
        $this->config->scenario = DatabaseSyncConfig::SCENARIO_SYNC;

        if (!$this->config->validate()) {
            $errors = $this->config->getErrors();
            Logger::echoValidationErrors($errors);
            return false;
        }

        $dataBaseSyncService = Yii::$container->get(DatabaseSyncService::class, [$this->config]);

        return $dataBaseSyncService->sync();
    }

    /**
     * Действие /add-cron-task
     *
     * @return bool
     * @throws InvalidConfigException
     * @throws NotInstantiableException
     */
    public function actionAddCronTask(): bool
    {
        $this->config->scenario = DatabaseSyncConfig::SCENARIO_CRON;

        if (!$this->config->validate()) {
            $errors = $this->config->getErrors();
            Logger::echoValidationErrors($errors);
            return false;
        }

        $dataBaseSyncCronService = Yii::$container->get(DatabaseSyncCronService::class, [$this->config]);

        return $dataBaseSyncCronService->addCronTask();
    }

    /**
     *  Действие /remove-cron-tasks
     *
     * @return bool
     */
    public function actionRemoveCronTasks(): bool
    {
        return DatabaseSyncCronService::removeCronTasks();
    }
}