<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Projects';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute'=>'name',
                'label'=>'Name',
                'format'=>'html', // Возможные варианты: raw, html
                'value' => function($data){
                    return Html::a(
                        $data->getName(),
                        ['project/view', 'id' => $data->id]
                    );
                }
            ],
            'description:ntext',
            'responsible_id',
            'deadline',
        ],
    ]); ?>
</div>
