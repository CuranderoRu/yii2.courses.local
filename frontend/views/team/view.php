<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TeamAssignmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $team->name;
$this->params['breadcrumbs'][] = ['label' => 'Teams', 'url' => ['team/index']];
$this->params['breadcrumbs'][] = $team->name;
?>
<div class="team-assignment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
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
        ],
    ]); ?>
</div>
