<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TeamAssignmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Team Assignments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="team-assignment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Team Assignment', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            [
                'attribute'=>'team_id',
                'label'=>'Team',
                'format'=>'text', // Возможные варианты: raw, html
                'content'=>function($data){
                    return $data->getTeamName();
                },
                'filter' => \common\models\tables\Team::getAvailableTeams()
            ],
            [
                'attribute'=>'user_id',
                'label'=>'User',
                'format'=>'text', // Возможные варианты: raw, html
                'content'=>function($data){
                    return $data->getUserName();
                },
                'filter' => \common\models\tables\User::getUsers()
            ],
            'isSupervisor',
            'isUser',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
