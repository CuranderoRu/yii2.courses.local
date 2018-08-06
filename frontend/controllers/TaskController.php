<?php

namespace frontend\controllers;

use common\models\tables\Project;
use common\models\tables\Team;
use frontend\models\Comment;
use common\models\tables\Comments;
use common\models\tables\User;
use Yii;
use common\models\tables\Task;
use yii\behaviors\TimestampBehavior;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\Html;
use yii\web\UploadedFile;

/**
 * TaskController.php implements the CRUD actions for Task model.
 */
class TaskController extends Controller
{

    public function actionTasktable($project, $month)
    {

        $userId = \Yii::$app->user->getId();
        $calendar = array_fill_keys(range(1, date("t")), []);

        foreach (Task::getByMonth($userId, $project, $month) as $task){
            $date = \DateTime::createFromFormat("Y-m-d H:i:s", $task->date);
            $calendar[$date->format("j")][] = $task;
        }

        return $this->renderPartial('tasktable', [
            'calendar' => $calendar,
            'description' => '',
            'detailed' => false,
            'model' => new Task(),
        ]);
    }

    /**
     * Lists all Task models.
     * @param int $id
     * @return mixed
     */
    public function actionIndex($id = -1, $show_details = false)
    {

        $projects = Task::getAvailableProjects();

        $months = [];
        $months['-3'] = date("F Y", strtotime("-3 month"));
        $months['-2'] = date("F Y", strtotime("-2 month"));
        $months['-1'] = date("F Y", strtotime("-1 month"));
        $months['0'] = date("F Y");
        for ($i = 1; $i <= 12; $i++) {
            $months["+{$i}"] = date("F Y", strtotime("+{$i} month"));
        };

        $recentTasks = Task::GetAccessedTasks();

        if ($id<0){
            $description = '';

        }else{
            if (!$show_details){
                $description = '';
            }else{
                $description = $this->findModel($id)->description;
            }

        }
        $detailed = $show_details ? false : true;

        $userId = \Yii::$app->user->getId();
        $calendar = array_fill_keys(range(1, date("t")), []);

        foreach (Task::getByCurrentMonth($userId) as $task){
            $date = \DateTime::createFromFormat("Y-m-d H:i:s", $task->date);
            $calendar[$date->format("j")][] = $task;
        }

        return $this->render('index', [
            'calendar' => $calendar,
            'description' => $description,
            'detailed' => $detailed,
            'model' => new Task(),
            'projects' => $projects,
            'months' => $months,
            'recentTasks' => $recentTasks,
            'table_headers' => [
                'Date' => \Yii::t('app', 'Date'),
                'Event' => \Yii::t('app', 'Event'),
                'Total' => \Yii::t('app', 'Total count'),
            ]
        ]);

    }

    /**
     * Displays a single Task model.
     * @param mixed $date
     * @return mixed
     */
    public function actionEvents($date)
    {
        $events = Task::getByUserAndDate(\Yii::$app->user->getId(), $date);
        return $this->render('events', ['events' => $events, 'date' => $date]);
    }


    /**
     * Displays a single Task model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        $comment = new Comment();
        $comment->user_id = \Yii::$app->user->getId();
        $comment->task_id = $id;

        if (\Yii::$app->request->isPost){
            $comment->load(\Yii::$app->request->Post());
            $comment->image = UploadedFile::getInstance($comment, 'image');
            $comment->write();
            $comment->body = "";
        }

        $comments = Comments::getByTask($id);

        $model = $this->findModel($id);
        $model->StoreAccessedTask();

        return $this->render('view', [
            'model' => $model,
            'comment' => $comment,
            'comments' => $comments,
        ]);
    }

    /**
     * Creates a new Task model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new Task();

        $model->on(Task::EVENT_AFTER_INSERT, function($event){
            $user = User::findOne($event->sender->user_id);

            Yii::$app->mailer->compose()
                ->setTo($user->email)
                ->setFrom([$user->email => $user->full_name])
                ->setSubject('New task created -- ' . $event->sender->name)
                ->setTextBody(Html::a('Task link', ['view', 'id' => $event->sender->id]))
                ->send();
        });

        //$model->attachBehavior('datechange',['class' => TimestampBehavior::class, 'value' => date("Y-m-d H:i:s")]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $projects = Project::getAvailableProjects();
        $users = Team::getAvailableTeamMembers();

        return $this->render('create', [
            'model' => $model,
            'projects' => $projects,
            'users' => $users,

        ]);
    }

    /**
     * Updates an existing Task model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $model->attachBehavior('datechange',['class' => TimestampBehavior::class, 'value' => date("Y-m-d H:i:s")]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $projects = Project::getAvailableProjects();
        $users = Team::getAvailableTeamMembers();

        return $this->render('update', [
            'model' => $model,
            'projects' => $projects,
            'users' => $users,
        ]);
    }

    /**
     * Deletes an existing Task model.
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

    protected function findModel($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'events', 'create', 'update', 'view', 'tasktable'],
                        'allow' => true,
                        'roles' => ['createTask', 'updateTask', 'manageTasks']
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
