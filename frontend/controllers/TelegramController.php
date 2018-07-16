<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 13.07.2018
 * Time: 21:07
 */

namespace frontend\controllers;


use SonkoDmitry\Yii\TelegramBot\Component;
use yii\web\Controller;

class TelegramController extends Controller
{
    public function actionReceive()
    {
        /** @var Component $bot */
        $bot = \Yii::$app->bot;
        $bot->setCurlOption(CURLOPT_TIMEOUT, 20);
        $bot->setCurlOption(CURLOPT_CONNECTTIMEOUT, 10);
        $bot->setCurlOption(CURLOPT_HTTPHEADER, ['Expect:']);


        $updates = $bot->getUpdates();
        var_dump($updates);
    }

}