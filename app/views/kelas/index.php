<?php

/* @var $this yii\web\View */
/* @var $searchModel app\models\KelasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use kartik\export\ExportMenu;
use app\modules\UserManagement\components\GhostHtml;
use kartik\grid\GridView;

$this->title = 'Kelas';
$this->params['breadcrumbs'][] = $this->title;
$search = "$('.search-button').click(function(){
	$('.search-form').toggle(1000);
	return false;
});";
$this->registerJs($search);
?>
<div class="kelas-index panel panel-default">
    <div class="panel-body">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <div class="search-form" style="display:none">
        <?=  $this->render('_search', ['model' => $searchModel]); ?>
    </div>
    
        <?php 
    $gridColumn = [
        ['class' => 'yii\grid\SerialColumn'],
                'kode_kelas',
            [
                'attribute' => 'kode_jenjang',
                'label' => 'Kode Jenjang',
                'value' => function($model){
                    if ($model->kodeJenjang)
                    {return $model->kodeJenjang->kode_jenjang;}
                    else
                    {return NULL;}
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\app\models\base\Jenjang::find()->asArray()->all(), 'kode_jenjang', 'kode_jenjang'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Jenjang', 'id' => 'grid-kelas-search-kode_jenjang']
            ],
<<<<<<< HEAD
            // [
            //     'attribute' => 'kode_jurusan',
            //     'label' => 'Kode Jurusan',
            //     'value' => function($model){
            //         if ($model->kodeJurusan)
            //         {return $model->kodeJurusan->kode_jurusan;}
            //         else
            //         {return NULL;}
            //     },
            //     'filterType' => GridView::FILTER_SELECT2,
            //     'filter' => \yii\helpers\ArrayHelper::map(\app\models\base\Jurusan::find()->asArray()->all(), 'kode_jurusan', 'kode_jurusan'),
            //     'filterWidgetOptions' => [
            //         'pluginOptions' => ['allowClear' => true],
            //     ],
            //     'filterInputOptions' => ['placeholder' => 'Jurusan', 'id' => 'grid-kelas-search-kode_jurusan']
            // ],
=======
            [
                'attribute' => 'kode_jurusan',
                'label' => 'Kode Jurusan',
                'value' => function($model){
                    if ($model->kodeJurusan)
                    {return $model->kodeJurusan->kode_jurusan;}
                    else
                    {return NULL;}
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\app\models\base\Jurusan::find()->asArray()->all(), 'kode_jurusan', 'kode_jurusan'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Jurusan', 'id' => 'grid-kelas-search-kode_jurusan']
            ],
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
            'nama',
            [
            'class' => 'yii\grid\ActionColumn',
            'icons' => [
                'eye-open' => "<span class='glyphicon glyphicon-search flip-icon'></span>"
            ],
            'contentOptions' => ['class' => 'nowrap text-center'],
                ],
        ]; 
    
    ?>

    <div class="d-flex justify-content-between mb-4">
        <div>
            <?= GhostHtml::a('<span class=\'glyphicon glyphicon-plus-sign\'></span> Tambah', ['/kelas/create'], ['class' => 'btn btn-success']) ?>
<<<<<<< HEAD
            <!-- <?= Html::a('Advance Search', '#', ['class' => 'btn btn-info search-button']) ?> -->
=======
            <?= Html::a('Advance Search', '#', ['class' => 'btn btn-info search-button']) ?>
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
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
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-kelas']],
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
