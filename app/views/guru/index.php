<?php

/* @var $this yii\web\View */
/* @var $searchModel app\models\GuruSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use kartik\export\ExportMenu;
use app\modules\UserManagement\components\GhostHtml;
use kartik\grid\GridView;
use yii\grid\ActionColumn;

$this->title = 'Guru';
$this->params['breadcrumbs'][] = $this->title;
$search = "$('.search-button').click(function(){
	$('.search-form').toggle(1000);
	return false;
});";
$this->registerJs($search);
?>
<div class="guru-index panel panel-default">
    <div class="panel-body">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <div class="search-form" style="display:none">
        <?=  $this->render('_search', ['model' => $searchModel]); ?>
    </div>
    
        <?php 
    $gridColumn = [
        ['class' => 'yii\grid\SerialColumn'],
            'guru_id',
            'nama',
            [
                'attribute' => 'kode_jk',
                'label' => 'Kode Jk',
                'value' => function($model){
                    if ($model->kodeJk)
                    {return $model->kodeJk->nama;}
                    else
                    {return NULL;}
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\app\models\base\Jeniskelamin::find()->asArray()->all(), 'kode_jk', 'nama'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Jeniskelamin', 'id' => 'grid-guru-search-kode_jk']
            ],
            'nip',
            'nik',
            'tempat_lahir',
            // [
            //     'attribute' => 'tanggal_lahir',
            //     'value' => function($model){
            //         return Yii::$app->formatter->asDate($model->tanggal_lahir);
            //     },
            //     'filterType' => GridView::FILTER_DATE,
            //     'filterWidgetOptions' => [
            //         'pluginOptions' => [
            //             'autoclose' => true,
            //             'format' => 'yyyy-mm-dd',
            //         ],
            //     ],
            //     'filterInputOptions' => ['placeholder' => 'Pilih Tanggal'],
            // ],
            [
                'attribute' => 'tanggal_lahir',
                'value' => function($model){
                    return Yii::$app->formatter->asDate($model->tanggal_lahir);
                },
                'filterType' => GridView::FILTER_DATE,
                'filterWidgetOptions' => [
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                    ],
                ],
                'filterInputOptions' => ['placeholder' => 'Pilih Tanggal'],
            ],
            'alamat',
            [
            'class' => 'yii\grid\ActionColumn',
            'icons' => [
                'eye-open' => "<span class='glyphicon glyphicon-search flip-icon'></span>"
            ],
            'contentOptions' => ['class' => 'nowrap text-center'],
                ],
                // [
                //     'class' => ActionColumn::className(),
                //     'buttons' => [
                //         'view' => function ($url,$model) {
                //             return Html:: a('View',['view','id' => $model ['guru_id'] ],['class' => 'btn btn-primary btn-sm']);
                //         },
    
                //         'update' => function ($url,$model) {
                //             return Html:: a('Update',['update','id' => $model ['guru_id'] ], ['class' => 'btn btn-warning btn-sm']); 
                //         },
    
                //         'delete' => function ($url,$model) {
                //             return Html::a('Delete', ['delete', 'id' => $model->guru_id], [
                //                 'class' => 'btn btn-danger btn-sm',
                //                 'data' => [
                //                     'confirm' => 'apakah anad yakin ingin menghapus ini?',
                //                     'method' => 'post',
                //                 ],
                //             ]);
                //         },    
                //     ],
                // ],
        ]; 
    
    ?>

    <div class="d-flex justify-content-between mb-4">
        <div>
            <?= GhostHtml::a('<span class=\'glyphicon glyphicon-plus-sign\'></span> Tambah', ['/guru/create'], ['class' => 'btn btn-success']) ?>
            <!-- <?= Html::a('Advance Search', '#', ['class' => 'btn btn-info search-button']) ?> -->
            </div>
            <?= ExportMenu::widget([
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
                    ExportMenu::FORMAT_PDF => false,
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

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumn,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-guru']],
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
    
    </div>
</div>
