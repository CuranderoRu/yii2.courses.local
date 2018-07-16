<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 12.07.2018
 * Time: 22:18
 */

namespace console\controllers;


use console\models\Chat;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use yii\console\Controller;

class WsserverController extends Controller
{
    public function actionRun()
    {
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new Chat()
                )
            ),
            8081
        );
        echo 'WS server started';
        $server->run();

    }
}