<?php
/** @var array $tasks */
/** @var array $table_headers */
/** @var array $calendar */
/** @var boolean $detailed */
use yii\helpers\Html;
use yii\helpers\Url;
use \yii\widgets\Pjax;
?>

<div class="row">
    <p class="col-md-6 text-left">
        <?= Html::a('Create Task', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
</div>


<table class="table table-bordered">
    <tr>
        <td><?= $table_headers['Date']; ?></td>
        <td><?= $table_headers['Event']; ?></td>
        <td><?= $table_headers['Total']; ?></td>
    </tr>
    <?php foreach ($calendar as $day => $events): ?>
        <tr>
            <td class="td-date"><span class="label label-success"><?= $day; ?></span></td>
            <td>
                <?= (count($events) == 0) ? '<p>-</p>' : ''; ?>
                <?= '<p class="small">'; ?>
                <?php foreach ($events as &$event): ?>

                    <?= Html::a($event->name,
                        Url::to(['task/view', 'id' => $event->id]))
                    ; ?>
                    <? Pjax::begin(['enablePushState' => false]); ?>
                    <? $capture = $detailed ? '(expand)' : '(collapse)'; ?>
                    <?= Html::a($capture,['task/index', 'id' => $event->id, 'show_details' => $detailed]); ?>
                    <br>
                    <?= $description; ?>
                    <? Pjax::end(); ?>
                <?php endforeach; ?>
                <?= '</p>'; ?>
            </td>
            <td class="td-event"><?= (count($events) > 0) ? Html::a(count($events),
                    Url::to(['task/events', 'date' => $events[0]->date])) : '-'; ?></td>
        </tr>
    <?php endforeach; ?>
</table>