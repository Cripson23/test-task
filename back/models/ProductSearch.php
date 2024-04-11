<?php

namespace app\models;

use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\data\Sort;
use yii\helpers\ArrayHelper;
use Exception;

class ProductSearch extends Product
{
    /**
     * Prepare data provider with pagination and sorting
     * @param array $params
     * @return ActiveDataProvider
     * @throws Exception
     */
    public function prepareDataProvider(array $params): ActiveDataProvider
    {
        $paginationParams = ArrayHelper::getValue($params, 'pagination', []);
        // Установка параметров пагинации
        $pagination = new Pagination([
            'defaultPageSize' => ArrayHelper::getValue($paginationParams, 'per-page', 20),
            'page' => ArrayHelper::getValue($paginationParams, 'page', 1) - 1,
        ]);

        // Настройка параметров сортировки
        $sortAttributes = [
            'id',
            'title',
            'sub_title',
            'price',
        ];

        $sortParams = ArrayHelper::getValue($params, 'sort', []);

        // Формируем правильную структуру для параметров сортировки
        $sortConfig = [];
        foreach ($sortParams as $attribute => $direction) {
            if (in_array($attribute, $sortAttributes)) {
                // Преобразуем строку направления в константы SORT_ASC / SORT_DESC
                $sortConfig[$attribute] = strtolower($direction) === 'asc' ? SORT_ASC : SORT_DESC;
            }
        }

        // Настройка параметров сортировки
        $sort = new Sort([
            'attributes' => $sortAttributes,
            'defaultOrder' => $sortConfig ?: ['id' => SORT_ASC],
        ]);

        $activeDataProvider = $this->search($params);
        $activeDataProvider->setPagination($pagination);
        $activeDataProvider->setSort($sort);

        return $activeDataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     * @throws Exception
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Product::find();
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        // Получаем фильтры из параметра filter
        $filters = ArrayHelper::getValue($params, 'filter', []);
        $this->load([self::formName() => $filters]);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // Применяем фильтры
        foreach ($filters as $attribute => $value) {
            // Проверяем, что атрибут существует в модели
            if ($this->hasAttribute($attribute)) {
                if (in_array($attribute, ['title', 'sub_title', 'price'])) {
                    $query->andFilterWhere(['like', $attribute, $value]);
                } else {
                    $query->andWhere([$attribute => $value]);
                }
            }
        }

        return $dataProvider;
    }
}