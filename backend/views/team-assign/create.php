<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\tables\TeamAssignment */

$this->title = 'Create Team Assignment';
$this->params['breadcrumbs'][] = ['label' => 'Team Assignments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="team-assignment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
