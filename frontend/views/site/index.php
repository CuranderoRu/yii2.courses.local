<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = 'Task megatracker';
?>
<div class="site-index">
    <div class="jumbotron">
        <h1>Welcome to Megatracker!</h1>

        <p class="lead"><?= (Yii::$app->user->isGuest) ? 'Успешно' : ($code == 1) ? 'Please, login to start.' : 'Use Tasks menu item to view your tasks.'; ?></p>

        <?= (Yii::$app->user->isGuest) ? Html::a('Login',
            Url::to(['/site/login']),
            ['class' => 'btn btn-lg btn-success']
            ) : ''; ?>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2></h2>

                <p></p>

                <!--<p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>-->
            </div>
            <div class="col-lg-4">
                <h2></h2>

                <p></p>

            </div>
            <div class="col-lg-4">
                <h2></h2>

                <p></p>

            </div>
        </div>

    </div>
</div>
