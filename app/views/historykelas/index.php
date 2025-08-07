<?php

/* @var $this yii\web\View */
/* @var $searchModel app\models\HistorykelasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use kartik\export\ExportMenu;
use app\modules\UserManagement\components\GhostHtml;
use kartik\grid\GridView;

$this->title = 'Historykelas';
$this->params['breadcrumbs'][] = $this->title;

// Toggle script
$search = "$('.search-button').click(function(){
    $('.search-form').toggle(1000);
    return false;
});";
$this->registerJs($search);

// Tambahan CSS modern
$this->registerCss("
    .historykelas-index {
        background-color: #fff;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        margin-top: 20px;
    }

    .historykelas-index h1 {
        font-size: 26px;
        font-weight: bold;
        color: #333;
        margin-bottom: 25px;
    }

    .historykelas-index .btn {
        border-radius: 25px;
        padding: 8px 20px;
        font-weight: 600;
    }

    .historykelas-index .btn-success {
        background: linear-gradient(135deg, #00c853, #2e7d32);
        color: white;
        border: none;
    }

    .historykelas-index .btn-warning {
        background: linear-gradient(135deg, #fbc02d, #f57f17);
        color: white;
        border: none;
    }

    .historykelas-index .btn-danger {
        background: linear-gradient(135deg, #e53935, #b71c1c);
        color: white;
        border: none;
    }

    .historykelas-index .btn-primary {
        background: linear-gradient(135deg, #2196f3, #1565c0);
        color: white;
        border: none;
    }

    .historykelas-index .btn-default {
        background: #f5f5f5;
        color: #333;
        border-radius: 25px;
    }

    .historykelas-index .select2-selection {
        border-radius: 8px !important;
        padding: 6px;
        font-size: 14px;
    }

    .historykelas-index .select2-selection__rendered {
        color: #333;
    }

    .historykelas-index .table {
        font-size: 14px;
    }

    .historykelas-index .table thead tr {
        background-color:rgb(4, 45, 85);
        color: white;
    }

    .historykelas-index .table tbody tr:hover {
        background-color: #f1f1f1;
    }

    .historykelas-index .panel-primary > .panel-heading {
        background-color: #1976d2;
        color: #fff;
        font-weight: bold;
        border-radius: 8px 8px 0 0;
    }

    .historykelas-index .panel-body {
        background-color: #fafafa;
        border-radius: 0 0 8px 8px;
    }
");
?>

<div class="historykelas-index panel panel-default">
    <div class="panel-body">

        <h1><?= Html::encode($this->title) ?></h1>

        <div class="search-form" style="display:none">
            <?= $this->render('_search', ['model' => $searchModel]); ?>
        </div>

        <?php
        $gridColumn = [
            ['class' => 'yii\grid\SerialColumn'],
            'history_id',
            [
                'attribute' => 'nis',
                'label' => 'NIS',
                'value' => function ($model) {
                    return $model->nis0 ? $model->nis0->nis : null;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\app\models\base\Siswa::find()->asArray()->all(), 'nis', 'nis'),
                'filterWidgetOptions' => ['pluginOptions' => ['allowClear' => true]],
                'filterInputOptions' => ['placeholder' => 'Siswa', 'id' => 'grid-historykelas-search-nis']
            ],
            [
                'attribute' => 'kodeta',
                'label' => 'Tahun Ajaran',
                'value' => function ($model) {
                    return $model->kodeta0 ? $model->kodeta0->kodeta : null;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\app\models\base\Tahunajaran::find()->asArray()->all(), 'kodeta', 'kodeta'),
                'filterWidgetOptions' => ['pluginOptions' => ['allowClear' => true]],
                'filterInputOptions' => ['placeholder' => 'Tahun Ajaran', 'id' => 'grid-historykelas-search-kodeta']
            ],
            [
                'attribute' => 'kode_kelas',
                'label' => 'Kelas',
                'value' => function ($model) {
                    return $model->kodeKelas ? $model->kodeKelas->kode_kelas : null;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\app\models\base\Kelas::find()->asArray()->all(), 'kode_kelas', 'kode_kelas'),
                'filterWidgetOptions' => ['pluginOptions' => ['allowClear' => true]],
                'filterInputOptions' => ['placeholder' => 'Kelas', 'id' => 'grid-historykelas-search-kode_kelas']
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['class' => 'nowrap text-center'],
            ],
        ];
        ?>

        <div class="d-flex justify-content-between mb-4">
            <div>
                <?= GhostHtml::a('<span class="glyphicon glyphicon-plus-sign"></span> Tambah', ['/historykelas/create'], ['class' => 'btn btn-success']) ?>
            </div>
            <?= ExportMenu::widget([
                'dataProvider' => $dataProvider,
                'columns' => $gridColumn,
                'target' => ExportMenu::TARGET_BLANK,
                'fontAwesome' => true,
                'dropdownOptions' => [
                    'label' => 'Export',
                    'class' => 'btn btn-default',
                    'itemsBefore' => ['<li class="dropdown-header">Pilih format di bawah</li>'],
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
                        'alertMsg' => 'File Excel 2007+ akan diunduh.',
                    ]
                ]
            ]) ?>
        </div>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => $gridColumn,
            'pjax' => true,
            'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-historykelas']],
            'layout' => '{toolbar}{items}<div class="row"><div class="col-sm-8">{pager}</div><div class="col-sm-4 text-right">{summary}</div></div>',
            'responsiveWrap' => false,
            'pager' => [
                'options' => ['class' => 'pagination pagination-sm'],
                'hideOnSinglePage' => true,
                'lastPageLabel' => 'Last',
                'firstPageLabel' => 'First',
            ],
            'export' => false,
            'toolbar' => ['{export}'],
        ]); ?>

    </div>
</div>