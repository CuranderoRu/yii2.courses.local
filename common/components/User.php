<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 02.07.2018
 * Time: 20:34
 */

namespace common\components;


class User extends \yii\web\User
{
    public function getUsername()
    {
        return \Yii::$app->user->identity->username;
    }
    public function getFull_name()
    {
        return \Yii::$app->user->identity->full_name;
    }

}