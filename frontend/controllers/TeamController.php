<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 06.08.2018
 * Time: 20:47
 */

namespace frontend\controllers;
use common\models\tables\Team;
use common\models\tables\TeamAssignment;
use common\models\TeamAssignmentSearch;
use common\models\TeamSearch;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class TeamController extends Controller
{
    public function actionIndex()
    {

        //var_dump(Team::getMyTeams()); exit;

        $searchModel = new TeamSearch();
        $dataProvider = Team::getMyTeams();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }

    public function actionView($id)
    {

        $team = Team::findOne($id);
        $searchModel = new TeamAssignmentSearch();
        $dataProvider = TeamAssignment::getTeamMembers($id);

        return $this->render('view', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'team' => $team,
        ]);

    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['viewTeams', 'createTask', 'updateTask', 'manageTasks']
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['deleteTask', 'manageTasks']
                    ],

                ],
            ],
        ];
    }

}