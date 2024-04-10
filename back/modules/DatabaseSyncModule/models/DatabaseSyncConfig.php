<?php

namespace app\modules\DatabaseSyncModule\models;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\Model;

class DatabaseSyncConfig extends Model
{
    const SCENARIO_SYNC = 'scenario-sync';
    const SCENARIO_CRON = 'scenario-cron';

    const MIN_BATCH_SIZE = 25;
    const MAX_BATCH_SIZE = 10000;

    // типы не указаны, дабы валидация работала в полной мере
    public $sourceDb = 'db_prod';
    public $targetDb = 'db';
    public $batchSize = 1000;

    public $noData = false;
    public $noProcedures = false;
    public $noTriggers = false;
    public $noViews = false;
    public $noEvents = false;

    public $hours = 0;
    public $minutes = 0;
    public $daysInterval = 1;

    /**
     * @return bool
     */
    public function beforeValidate(): bool
    {
        $this->noData = $this->noData !== false;
        $this->noProcedures = $this->noProcedures !== false;
        $this->noTriggers = $this->noTriggers !== false;
        $this->noViews = $this->noViews !== false;
        $this->noEvents = $this->noEvents !== false;

        return parent::beforeValidate();
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['sourceDb', 'targetDb'], 'required', 'on' => [self::SCENARIO_SYNC, self::SCENARIO_CRON]],
            [['sourceDb', 'targetDb'], 'string', 'on' => [self::SCENARIO_SYNC, self::SCENARIO_CRON]],
            [['sourceDb', 'targetDb'], 'validateDbComponent', 'on' => [self::SCENARIO_SYNC, self::SCENARIO_CRON]],
            [['batchSize'], 'integer', 'min' => self::MIN_BATCH_SIZE, 'max' => self::MAX_BATCH_SIZE, 'on' => [self::SCENARIO_SYNC, self::SCENARIO_CRON]],
            [['noData', 'noProcedures', 'noTriggers', 'noViews', 'noEvents'], 'boolean', 'on' => [self::SCENARIO_SYNC, self::SCENARIO_CRON]],

            [['hours'], 'integer', 'min' => 0, 'max' => 23, 'on' => self::SCENARIO_CRON],
            [['minutes'], 'integer', 'min' => 0, 'max' => 59, 'on' => self::SCENARIO_CRON],
            [['daysInterval'], 'integer', 'min' => 1, 'max' => 30, 'on' => self::SCENARIO_CRON],
        ];
    }

    /**
     * Валидатор для проверки существования компонента базы данных.
     * @param string $attribute Имя атрибута, значение которого валидируется.
     * @param array|null $params Дополнительные параметры.
     * @throws InvalidConfigException
     */
    public function validateDbComponent(string $attribute, array|null $params): void
    {
        if (!Yii::$app->has($this->$attribute)) {
            $this->addError($attribute, "Компонент '{$this->$attribute}' не существует.");
        } else {
            $dbComponent = Yii::$app->get($this->$attribute);
            if (!($dbComponent instanceof \yii\db\Connection)) {
                // Дополнительная проверка, что компонент является экземпляром класса Connection.
                $this->addError($attribute, "Компонент '{$this->$attribute}' не является подключением к базе данных.");
            } else {
                // Пытаемся установить соединение с базой данных.
                try {
                    $dbComponent->open();
                    if (!$dbComponent->isActive) {
                        // Если соединение не активно после попытки открыть его.
                        $this->addError($attribute, "Не удалось установить соединение с базой данных через компонент '{$this->$attribute}'.");
                    }
                } catch (\yii\db\Exception $e) {
                    // Ловим исключение, если не удалось установить соединение.
                    $this->addError($attribute, "Ошибка соединения с базой данных через компонент '{$this->$attribute}': " . $e->getMessage());
                }
            }
        }
    }

    /**
     * @return void
     * @throws InvalidConfigException
     */
    public function afterValidate(): void
    {
        if ($this->scenario === self::SCENARIO_SYNC) {
            if (!$this->getErrors()) {
                $this->sourceDb = Yii::$app->get($this->sourceDb);
                $this->targetDb = Yii::$app->get($this->targetDb);
            }
        }

        parent::afterValidate();
    }
}