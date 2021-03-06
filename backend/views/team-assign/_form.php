<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\tables\TeamAssignment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="team-assignment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'team_id')->dropDownList($teams) ?>

    <?= $form->field($model, 'user_id')->dropDownList($users) ?>

    <?= $form->field($model, 'isSupervisor')->checkbox() ?>

    <?= $form->field($model, 'isUser')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
