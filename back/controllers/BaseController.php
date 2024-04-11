<?php

namespace app\controllers;

use Yii;
use yii\filters\Cors;
use yii\rest\Controller;


/**
 * Site controller
 */
class BaseController extends Controller
{
    const NAME_STATUS = [
        0 => "Unknown",
        400 => "Bad Request",
        401 => "Unauthorized",
        403 => 'Forbidden',
        404 => "Not Found",
        405 => "Method Not Allowed",
        422 => "Unprocessable Entity",
    ];

	/**
	 * @return array
	 */
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

		$behaviors['corsFilter'] = [
			'class' => \yii\filters\Cors::class,
			'cors' => [
				'Origin' => [Yii::$app->params['frontUrl']],
				'Access-Control-Request-Method' => ['*'],
				'Access-Control-Request-Headers' => ['*'],
				'Access-Control-Allow-Credentials' => true,
				'Access-Control-Max-Age' => 3600,
			],
		];

        $behaviors['contentNegotiator'] = [
            'class' => \yii\filters\ContentNegotiator::class,
            'formats' => [
                'application/json' => \yii\web\Response::FORMAT_JSON,
            ],
        ];

        return $behaviors;
    }

    /**
     * Error default action.
     * @param int $status
     * @param string $message
     * @param int $code
     * @return array
     */
    public function actionError(int $status = 0, string $message = '', int $code = 0): array
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception) {
            $status = $exception->statusCode;

            return [
                'name' => (array_key_exists($status, self::NAME_STATUS)) ? self::NAME_STATUS[$status] : self::NAME_STATUS[0],
                'error' => $exception->getMessage(),
                'status' => $status,
            ];
        }

        return [];
    }

    /**
     * @param array $errors
     * @return array
     */
    public function goErrorValidation(array $errors): array
    {
        $this->response->setStatusCode(422, 'Data Validation Failed.');

        return $errors;
    }
}