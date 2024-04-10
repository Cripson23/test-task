<?php

namespace app\modules\DatabaseSyncModule;

use Yii;
use yii\console\Controller;

class Logger extends Controller
{
    /**
     * Вывод сообщений в консоль и в лог
     *
     * @param string $message
     * @return void
     */
    public static function echoLog(string $message): void
    {
        self::echo($message);
        Yii::info("$message\n");
    }

    /**
     * Вывод ошибок в консоль и в лог
     *
     * @param array $errors
     * @return void
     */
    public static function echoValidationErrors(array $errors): void
    {
        foreach ($errors as $attribute => $messages) {
            foreach ($messages as $message) {
                self::echoError("Ошибка валидации: {$attribute} - {$message}");
            }
        }
    }

    /**
     * Вывод ошибки в консоль или в лог
     *
     * @param string $message
     * @return void
     */
    public static function echoError(string $message): void
    {
        self::echo($message);
        Yii::error("$message\n");
    }

    /**
     * @param string $message
     * @return void
     */
    private static function echo(string $message): void
    {
        echo "$message\n";
    }
}