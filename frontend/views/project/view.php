<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\tables\Project */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'description:ntext',
            'responsible_id',
            'deadline',
            'created_at',
            'updated_at',
        ],
    ]) ?>

    <h2><?= Html::encode('Related tasks') ?></h2>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'date',
            [
                'attribute'=>'name',
                'label'=>'Name',
                'format'=>'html', // Возможные варианты: raw, html
                'value' => function($data){
                    return Html::a(
                        $data->name,
                        ['task/view', 'id' => $data->id]
                    );
                }
            ],
            'description:ntext',
            'deadline',
            'completion_date',
            [
                'attribute'=>'responsible',
                'label'=>'Person',
                'format'=>'text', // Возможные варианты: raw, html
                'value' => function($data){
                    return $data->getTaskResponsibleName();
                }
            ],

        ],
    ]); ?>


</div>
