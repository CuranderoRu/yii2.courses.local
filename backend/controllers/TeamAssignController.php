<?php

namespace backend\controllers;

use common\models\tables\AuthAssignment;
use common\models\tables\Team;
use common\models\tables\User;
use Yii;
use common\models\tables\TeamAssignment;
use common\models\TeamAssignmentSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TeamAssignController implements the CRUD actions for TeamAssignment model.
 */
class TeamAssignController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'delete', 'view'],
                        'allow' => true,
                        'roles' => ['admin', 'supervisor']
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all TeamAssignment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TeamAssignmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TeamAssignment model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
            'team' => Team::findOne($model->team_id),
            'user' => User::findOne($model->user_id),
        ]);
    }

    /**
     * Creates a new TeamAssignment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TeamAssignment();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $role_name = 'guest';
            if ($model->isUser){
                $role_name = 'user';
            }
            if ($model->isSupervisor){
                $role_name = 'supervisor';
            }
            AuthAssignment::escalateRole($model->user_id, $role_name);

            return $this->redirect(['view', 'id' => $model->id]);
        }

        $teams = Team::getAvailableTeams();
        $users = User::getUsers();

        return $this->render('create', [
            'model' => $model,
            'teams' => $teams,
            'users' => $users,
        ]);
    }

    /**
     * Updates an existing TeamAssignment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $role_name = 'guest';
            if ($model->isUser){
                $role_name = 'user';
            }
            if ($model->isSupervisor){
                $role_name = 'supervisor';
            }
            AuthAssignment::escalateRole($model->user_id, $role_name);

            return $this->redirect(['view', 'id' => $model->id]);
        }

        $teams = Team::getAvailableTeams();
        $users = User::getUsers();

        return $this->render('update', [
            'model' => $model,
            'teams' => $teams,
            'users' => $users,
        ]);
    }

    /**
     * Deletes an existing TeamAssignment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TeamAssignment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TeamAssignment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TeamAssignment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
