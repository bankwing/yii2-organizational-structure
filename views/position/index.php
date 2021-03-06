<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use kartik\widgets\Select2;
use kartik\export\ExportMenu;

use andahrm\structure\models\PersonType;
use andahrm\structure\models\Section;
use andahrm\structure\models\PositionLine;
use andahrm\structure\models\PositionType;
use andahrm\structure\models\PositionLevel;
use andahrm\structure\models\Position;
/* @var $this yii\web\View */
/* @var $searchModel andahrm\structure\models\PositionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('andahrm/structure', 'Positions');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
$columns = [
    'id' => 'id',
    'code' => 'code',
    'code' => [
        'attribute' => 'code',
        // 'filter' => Select2::widget([
        //     'name' => 'code',
        //     'data' => Position::getList(),
        //     ]),
        'contentOptions' => ['style'=>"white-space:nowrap;"],
        'value' => 'code'
    ],
    'title' => 'title',
    'position_line_id' => [
        'attribute' => 'position_line_id',
        'filter' => PositionLine::getList(),
        'value' => 'positionLine.title'
    ],
    'position_type_id' => [
        'attribute' => 'position_type_id',
        'filter' => PositionType::getList(),
        'value' => 'positionType.title'
    ],
    'position_level_id' => [
        'attribute' => 'position_level_id',
        'filter' => PositionLevel::getList(),
        'value' => 'positionLevel.title'
    ],
    'status' => [
        'attribute' => 'status',
        'filter' => Position::getItemStatus(),
        'format' => 'html',
        'value' => 'statusLabel'
    ],
    'note' => 'note',
    'created_at' => 'created_at:datetime',
    'created_by' => [
        'attribute' => 'created_by',
        'value' => 'createdBy.fullname'
    ],
    'updated_at' => 'updated_at:datetime',
    'updated_by' => [
        'attribute' => 'updated_by',
        'value' => 'updatedBy.fullname'
    ],
];

$gridColumns = [
   ['class' => '\kartik\grid\SerialColumn'],
    $columns['code'],
    $columns['title'],
    $columns['position_line_id'],
    $columns['position_type_id'],
    $columns['position_level_id'],
    $columns['status'],
    $columns['created_at'],
    $columns['created_by'],
    ['class' => '\kartik\grid\ActionColumn',]
];

$fullExportMenu = ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $columns,
    'filename' => $this->title,
    'showConfirmAlert' => false,
    'target' => ExportMenu::TARGET_BLANK,
    'fontAwesome' => true,
    'pjaxContainerId' => 'kv-pjax-container',
    'dropdownOptions' => [
        'label' => 'Full',
        'class' => 'btn btn-default',
        'itemsBefore' => [
            '<li class="dropdown-header">Export All Data</li>',
        ],
    ],
]);
?>
<div class="person-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'id' => 'data-grid',
        'pjax'=>true,
//        'resizableColumns'=>true,
//        'resizeStorageKey'=>Yii::$app->user->id . '-' . date("m"),
//        'floatHeader'=>true,
//        'floatHeaderOptions'=>['scrollingTop'=>'50'],
        'export' => [
            'label' => Yii::t('yii', 'Page'),
            'fontAwesome' => true,
            'target' => GridView::TARGET_SELF,
            'showConfirmAlert' => false,
        ],
//         'exportConfig' => [
//             GridView::HTML=>['filename' => $exportFilename],
//             GridView::CSV=>['filename' => $exportFilename],
//             GridView::TEXT=>['filename' => $exportFilename],
//             GridView::EXCEL=>['filename' => $exportFilename],
//             GridView::PDF=>['filename' => $exportFilename],
//             GridView::JSON=>['filename' => $exportFilename],
//         ],
        'panel' => [
            //'heading'=>'<h3 class="panel-title"><i class="fa fa-th"></i> '.Html::encode($this->title).'</h3>',
//             'type'=>'primary',
            'before'=> '<div class="btn-group">'.
                Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('andahrm', 'Create'), ['create'], [
                    'class' => 'btn btn-success btn-flat',
                    'data-pjax' => 0
                ]) . ' '.
                Html::a('<i class="glyphicon glyphicon-repeat"></i> '.Yii::t('andahrm', 'Reload'), '#!', [
                    'class' => 'btn btn-info btn-flat btn-reload',
                    'title' => 'Reload',
                    'id' => 'btn-reload-grid'
                ]) . ' '.
                Html::a('<i class="glyphicon glyphicon-trash"></i> '.Yii::t('andahrm', 'Trash'), ['trash/index'], [
                    'class' => 'btn btn-warning btn-flat',
                    'data-pjax' => 0
                ]) . ' '.
                '</div>',
                'heading'=>false,
                //'footer'=>false,
        ],
        'toolbar' => [
            '{export}',
            '{toggleData}',
            $fullExportMenu,
        ],
        'columns' => $gridColumns,
    ]); ?>
</div>
<?php
$js[] = "
$(document).on('click', '#btn-reload-grid', function(e){
    e.preventDefault();
    $.pjax.reload({container: '#data-grid-pjax'});
});
";

$this->registerJs(implode("\n", $js));

