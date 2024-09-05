<?php

/* @var $this yii\web\View */
/* @var $searchModel app\models\JurnalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use kartik\export\ExportMenu;
use app\modules\UserManagement\components\GhostHtml;
use kartik\grid\GridView;

$this->title = 'Jurnal';
$this->params['breadcrumbs'][] = $this->title;
$search = "$('.search-button').click(function(){
	$('.search-form').toggle(1000);
	return false;
});";
$this->registerJs($search);
?>
<div class="jurnal-index panel panel-default">
    <div class="panel-body">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <div class="search-form" style="display:none">
        <?=  $this->render('_search', ['model' => $searchModel]); ?>
    </div>
    
        <?php 
    $gridColumn = [
        ['class' => 'yii\grid\SerialColumn'],
                'jurnal_id',
            [
                'attribute' => 'guru_id',
                'label' => 'Guru',
                'value' => function($model){
                    if ($model->guru)
                    {return $model->guru->guru_id;}
                    else
                    {return NULL;}
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\app\models\base\Guru::find()->asArray()->all(), 'guru_id', 'guru_id'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Guru', 'id' => 'grid-jurnal-search-guru_id']
            ],
            [
                'attribute' => 'kodeta',
                'label' => 'Kodeta',
                'value' => function($model){
                    if ($model->kodeta0)
                    {return $model->kodeta0->kodeta;}
                    else
                    {return NULL;}
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\app\models\base\Tahunajaran::find()->asArray()->all(), 'kodeta', 'kodeta'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Tahunajaran', 'id' => 'grid-jurnal-search-kodeta']
            ],
            [
                'attribute' => 'hari_id',
                'label' => 'Hari',
                'value' => function($model){
                    if ($model->hari)
                    {return $model->hari->hari_id;}
                    else
                    {return NULL;}
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\app\models\base\Hari::find()->asArray()->all(), 'hari_id', 'hari_id'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Hari', 'id' => 'grid-jurnal-search-hari_id']
            ],
            'jam_ke',
            'materi:ntext',
            [
                'attribute' => 'kode_kelas',
                'label' => 'Kode Kelas',
                'value' => function($model){
                    if ($model->kodeKelas)
                    {return $model->kodeKelas->kode_kelas;}
                    else
                    {return NULL;}
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\app\models\base\Kelas::find()->asArray()->all(), 'kode_kelas', 'kode_kelas'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Kelas', 'id' => 'grid-jurnal-search-kode_kelas']
            ],
            [
                'attribute' => 'kode_mapel',
                'label' => 'Kode Mapel',
                'value' => function($model){
                    if ($model->kodeMapel)
                    {return $model->kodeMapel->kode_mapel;}
                    else
                    {return NULL;}
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\app\models\base\Mapel::find()->asArray()->all(), 'kode_mapel', 'kode_mapel'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Mapel', 'id' => 'grid-jurnal-search-kode_mapel']
            ],
            'jam_mulai',
            'jam_selesai',
            'status',
            'waktupresensi',
            'file_siswa',
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
            <?= GhostHtml::a('<span class=\'glyphicon glyphicon-plus-sign\'></span> Tambah', ['/jurnal/create'], ['class' => 'btn btn-success']) ?>
            <?= Html::a('Advance Search', '#', ['class' => 'btn btn-info search-button']) ?>
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
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-jurnal']],
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
