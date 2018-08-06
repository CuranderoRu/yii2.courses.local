<?php
/** @var array $tasks */
/** @var array $table_headers */
/** @var array $calendar */
/** @var boolean $detailed */
/** @var array $projects */
/** @var array $recentTasks */

use yii\helpers\Html;
use yii\helpers\Url;
use \yii\bootstrap\ActiveForm;
$this->registerJsFile('../js/taskmain.js',  ['position' => yii\web\View::POS_END]);

?>
<div class="col-md-12 text-right">
    <?php foreach ($recentTasks as $key => $value): ?>
        <?= Html::a($value,
            Url::to(['task/view', 'id' => $key])); ?>
        <br>
    <?php endforeach; ?>
</div>

<div class="row">
    <p class="col-md-3 text-left">
        <?= Html::a('Create Task', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
</div>

<?php
$form = ActiveForm::begin([
    'id' => 'filter-selector',
    'options' => [
        'class' => 'form-inline col-md-12',
    ],
]);
$items = [];
foreach ($projects as $key => $value) {
    $items[$value['id']] = $value['name'];
}

$params = [
    'prompt' => 'Все...',
    'onChange' => 'SelectChange.call(this)'
];
echo $form->field($model, 'project_id')->dropDownList($items, $params);
echo ' ';
echo $form->field($model, 'month')->dropDownList($months, $params);
ActiveForm::end();
?>

<table class="col-md-9 table table-bordered" id="calendar_table">
    <tr>
        <td><?= $table_headers['Date']; ?></td>
        <td><?= $table_headers['Event']; ?></td>
        <td><?= $table_headers['Total']; ?></td>
    </tr>

    <?= $this->render('tasktable', [
        'calendar' => $calendar,
        'description' => $description,
        'detailed' => $detailed,
        'model' => $model,
    ]) ?>

</table>