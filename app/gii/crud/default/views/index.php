<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator \mootensai\enhancedgii\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();
$tableSchema = $generator->getTableSchema();
$baseModelClass = StringHelper::basename($generator->modelClass);
$fk = $generator->generateFK($tableSchema);
echo "<?php\n";
?>

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use kartik\export\ExportMenu;
use app\modules\UserManagement\components\GhostHtml;
use <?= $generator->indexWidgetType === 'grid' ? "kartik\\grid\\GridView;" : "yii\\widgets\\ListView;" ?>


$this->title = <?= ($generator->pluralize) ? $generator->generateString(Inflector::pluralize(Inflector::camel2words($baseModelClass))) : $generator->generateString(Inflector::camel2words($baseModelClass)) ?>;
$this->params['breadcrumbs'][] = $this->title;
$search = "$('.search-button').click(function(){
	$('.search-form').toggle(1000);
	return false;
});";
$this->registerJs($search);
?>
<div class="<?= Inflector::camel2id($baseModelClass) ?>-index panel panel-default">
    <div class="panel-body">

    <h1><?= "<?= " ?>Html::encode($this->title) ?></h1>
    
    <?php if (!empty($generator->searchModelClass)): ?>
<div class="search-form" style="display:none">
        <?= "<?= " ?> $this->render('_search', ['model' => $searchModel]); ?>
    </div>
    <?php endif; ?>

    <?php 
    if ($generator->indexWidgetType === 'grid'): 
    ?>
    <?= "<?php \n" ?>
    $gridColumn = [
        ['class' => 'yii\grid\SerialColumn'],
    <?php
        if ($generator->expandable && !empty($fk)):
    ?>
        [
            'class' => 'kartik\grid\ExpandRowColumn',
            'width' => '50px',
            'value' => function ($model, $key, $index, $column) {
                return GridView::ROW_COLLAPSED;
            },
            'detail' => function ($model, $key, $index, $column) {
                return Yii::$app->controller->renderPartial('_expand', ['model' => $model]);
            },
            'headerOptions' => ['class' => 'kartik-sheet-style'],
            'expandOneOnly' => true
        ],
    <?php
        endif;
    ?>
    <?php   
        if ($tableSchema === false) :
            foreach ($generator->getColumnNames() as $name) {
                if (++$count < 6) {
                    echo "            '" . $name . "',\n";
                } else {
                    echo "            // '" . $name . "',\n";
                }
            }
        else :
            foreach ($tableSchema->getColumnNames() as $attribute): 
                if (!in_array($attribute, $generator->skippedColumns)) :
    ?>
        <?= $generator->generateGridViewFieldIndex($attribute, $fk, $tableSchema)?>
    <?php
                endif;
            endforeach; ?>
        [
            'class' => 'yii\grid\ActionColumn',
            'icons' => [
                'eye-open' => "<span class='glyphicon glyphicon-search flip-icon'></span>"
            ],
            'contentOptions' => ['class' => 'nowrap text-center'],
    <?php if($generator->saveAsNew): ?>
            'template' => '{save-as-new} {view} {update} {delete}',
            'buttons' => [
                'save-as-new' => function ($url) {
                    return Html::a('<span class="glyphicon glyphicon-copy"></span>', $url, ['title' => 'Save As New']);
                },
            ],
    <?php endif; ?>
            ],
        ]; 
    <?php 
        endif; 
    ?>

    ?>

    <div class="d-flex justify-content-between mb-4">
        <div>
            <?= "<?= " ?>GhostHtml::a(<?= $generator->generateString("<span class='glyphicon glyphicon-plus-sign'></span> Tambah") ?>, ['/<?= Inflector::camel2id($baseModelClass) ?>/create'], ['class' => 'btn btn-success']) ?>
            <?php if (!empty($generator->searchModelClass)): ?>
<?= "<?= " ?>Html::a(<?= $generator->generateString('Advance Search')?>, '#', ['class' => 'btn btn-info search-button']) ?>
            <?php endif; ?>
</div>
            <?= "<?= " ?>ExportMenu::widget([
                'dataProvider' => $dataProvider,
                'columns' => $gridColumn,
                'target' => ExportMenu::TARGET_BLANK,
                'fontAwesome' => true,
                'dropdownOptions' => [
                    'label' => 'Export',
                    'class' => 'btn btn-default',
                    'itemsBefore' => [
                        '<li class="dropdown-header">Pilih format dibawah</li>',
                    ],
                ],
                'exportConfig' => [
                    ExportMenu::FORMAT_HTML => false,
                    ExportMenu::FORMAT_TEXT => false,
                    ExportMenu::FORMAT_EXCEL => false,
                    <?php if($generator->pdf):?>
ExportMenu::FORMAT_PDF => [
                        'icon' => 'glyphicon glyphicon-floppy-disk'
                    ],
                    <?php else: ?>
ExportMenu::FORMAT_PDF => false,
                    <?php endif;?>
ExportMenu::FORMAT_CSV => [
                        'icon' => 'glyphicon glyphicon-floppy-open',
                    ],
                    ExportMenu::FORMAT_EXCEL_X => [
                        'label' => 'Excel 2007+ (xlsx)',
                        'icon' =>  'glyphicon glyphicon-floppy-remove',
                        'iconOptions' => ['class' => 'text-success'],
                        'alertMsg' => 'The EXCEL 2007+ (xlsx) export file will be generated for download.',
                    ]
                ]
            ]);
        ?>
    </div>

    <?= "<?= " ?>GridView::widget([
        'dataProvider' => $dataProvider,
        <?= !empty($generator->searchModelClass) ? "'filterModel' => \$searchModel,\n        'columns' => \$gridColumn,\n" : "'columns' => \$gridColumn,\n"; ?>
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-<?= Inflector::camel2id(StringHelper::basename($generator->modelClass))?>']],
        'layout' => '{toolbar}{items}<div class="row"><div class="col-sm-8">{pager}</div><div class="col-sm-4 text-right">{summary}',
        'responsiveWrap' => false,
        'pager' => [
            'options' => ['class' => 'pagination pagination-sm'],
            'hideOnSinglePage' => true,
            'lastPageLabel' => 'Last',
            'firstPageLabel' => 'First',
        ],
        'export' => false,
        // your toolbar can include the additional full export menu
        'toolbar' => [
            '{export}',
        ],
    ]); ?>
    <?php 
    else: 
    ?>
    <?= "<?= " ?>ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return $this->render('_index',['model' => $model, 'key' => $key, 'index' => $index, 'widget' => $widget, 'view' => $this]);
        },
    ]) ?>
    <?php 
    endif; 
    ?>

    </div>
</div>
