<?php

namespace app\controllers;

use Yii;
use Exception;
use app\models\Product;
use app\models\ProductSearch;

class ProductsController extends BaseController
{
    public string $modelClass = 'app\models\Product';

    /**
     * @return array
     */
    protected function verbs(): array
    {
        return [
            'index' => ['POST'],
        ];
    }

    /**
     * @throws Exception
     */
    public function actionIndex(): array
    {
        $data = Yii::$app->request->post();

        $searchModel = new ProductSearch();
        $searchModel->scenario = Product::SCENARIO_LIST;

        $products = $searchModel->prepareDataProvider($data)->getModels();

        if ($errors = $searchModel->getErrors()) {
            return $this->goErrorValidation($errors);
        }

        return ['success' => true, 'data' => $products];
    }
}