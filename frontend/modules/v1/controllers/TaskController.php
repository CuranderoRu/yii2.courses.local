<?php

namespace frontend\modules\v1\controllers;

use common\models\tables\Task;
use yii\rest\ActiveController;

class TaskController extends ActiveController
{
    public $modelClass = Task::class;
}
