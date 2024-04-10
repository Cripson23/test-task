<?php

namespace app\models;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property string $title
 * @property string $sub_title
 * @property float $price
 * @property string $description
 * @property string $image_path
 */
class Product extends \yii\db\ActiveRecord
{
    const SCENARIO_LIST = 'list';

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'products';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            //[['title', 'sub_title', 'price', 'description', 'image_path'], 'required'],
            [['price'], 'number', 'on' => self::SCENARIO_LIST],
            //[['description'], 'string'],
            [['title', 'sub_title'], 'string', 'max' => 64, 'on' => self::SCENARIO_LIST],
            [['image_path'], 'string', 'max' => 128, 'on' => self::SCENARIO_LIST],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'sub_title' => 'Подзаголовок',
            'price' => 'Стоимость',
            'description' => 'Описание',
            'image_path' => 'Путь до изображения',
        ];
    }
}
