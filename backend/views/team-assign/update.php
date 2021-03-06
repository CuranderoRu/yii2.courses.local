<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\tables\TeamAssignment */

$this->title = 'Update Team Assignment: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Team Assignments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="team-assignment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'users' => $users,
        'teams' => $teams,
    ]) ?>

</div>
