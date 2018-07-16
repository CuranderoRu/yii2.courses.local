<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 16.07.2018
 * Time: 20:46
 */

namespace frontend\controllers;


use common\models\tables\Comments;
use common\models\User;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;

class RestcommentController extends ActiveController
{
    public $modelClass = Comments::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authentificator'] = [
            'class' => HttpBasicAuth::class,
            'auth' => function($username, $password){
                $user = User::findByUsername($username);
                if ($user !== null && $user->validatePassword($password)){
                    return $user;
                }
                return null;
            }
        ];

        return $behaviors;
    }


    public function checkAccess($action, $model = null, $params = [])
    {
        if (!\Yii::$app->user->id){
            throw new ForbiddenHttpException();
        }
    }


    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }


    public function actionIndex()
    {

        $this->checkAccess('index', null, []);
        //http://yii2.courses.local/frontend/web/restcomment?filter[text]=Новый комментарий
        $query = Comments::find();

        if ($filter = \Yii::$app->request->get('filter')){
            $query->filterWhere([
                'body' => $filter['text']
            ]);
        }

        return new ActiveDataProvider([
                'query' => $query
            ]
        );
    }



}