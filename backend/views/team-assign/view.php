<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\tables\TeamAssignment */

$this->title = "Team assignment " . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Team Assignments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="team-assignment-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'team',
                'label' => 'Team',
                'value' => $team->name,
            ],

            [
                'attribute' => 'user',
                'label' => 'User',
                'value' => $user->username . ", userid - " . $user->id,
            ],
            'isSupervisor',
            'isUser',
        ],
    ]) ?>

</div>
