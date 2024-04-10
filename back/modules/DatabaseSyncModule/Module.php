<?php

namespace app\modules\DatabaseSyncModule;

use app\modules\DatabaseSyncModule\models\DatabaseSyncConfig;
use Yii;
use app\modules\DatabaseSyncModule\models\DatabaseSyncService;
use app\modules\DatabaseSyncModule\models\DatabaseSyncCronService;

class Module extends \yii\base\Module
{
    public function init(): void
    {
        parent::init();

        // настройка контроллера по умолчанию для модуля
        $this->controllerNamespace = 'app\modules\DatabaseSyncModule\commands';

        // Настройка контейнера внедрения зависимостей
        $this->configureContainer();
    }

    /**
     * @return void
     */
    protected function configureContainer(): void
    {
        Yii::$container->set(DatabaseSyncConfig::class, function ($container, $params, $config) {
            return new DatabaseSyncConfig(...$params);
        });

        Yii::$container->set(DatabaseSyncService::class, function ($container, $params, $config) {
            return new DatabaseSyncService(...$params);
        });

        Yii::$container->set(DatabaseSyncCronService::class, function ($container, $params, $config) {
            return new DatabaseSyncCronService(...$params);
        });
    }
}