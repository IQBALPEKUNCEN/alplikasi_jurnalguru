<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use app\modules\UserManagement\components\GhostHtml;

/** @var yii\web\View $this */
/** @var app\models\MapelSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Data Mata Pelajaran';
$this->params['breadcrumbs'][] = $this->title;

// Toggle search
$this->registerJs("$('.search-button').click(function(){
    $('.search-form').toggle(1000);
    return false;
});");

// Modern CSS styling
$this->registerCss(<<<CSS
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');

body {
    font-family: 'Inter', sans-serif;
    background: linear-gradient(to right, #c9d6ff, #e2e2e2);
    padding: 30px;
}

.mapel-index {
    background: rgba(255, 255, 255, 0.95);
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    max-width: 1000px;
    margin: auto;
    animation: fadeInUp 0.5s ease-in-out;
}

.mapel-index h1 {
    text-align: center;
    font-weight: 700;
    margin-bottom: 30px;
    color: #34495e;
}

.btn-success {
    background: linear-gradient(45deg, #1abc9c, #16a085);
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: bold;
    color: #fff;
    transition: all 0.3s ease;
}

.btn-success:hover {
    background: linear-gradient(45deg, #16a085, #1abc9c);
    transform: scale(1.05);
}

.btn-default {
    background: #3498db;
    color: #fff;
    font-weight: bold;
    border-radius: 8px;
    padding: 10px 20px;
    border: none;
}

.kv-grid-table thead th {
    background-color: #34495e;
    color: white;
    text-align: center;
}

.kv-grid-table td {
    text-align: center;
    background-color: #fdfdfd;
    font-weight: 500;
}

.grid-action-buttons .btn {
    font-size: 12px;
    margin: 2px;
    padding: 5px 10px;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(40px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
CSS);
?>

<div class="mapel-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p class="text-center">
        <?= GhostHtml::a('+ Tambah Mapel', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <div class="action-buttons text-center mb-4">
        <?= ExportMenu::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'kode_mapel',
                'nama',
            ],
            'target' => ExportMenu::TARGET_BLANK,
            'fontAwesome' => true,
            'dropdownOptions' => [
                'label' => 'Export',
                'class' => 'btn btn-default',
                'itemsBefore' => [
                    '<li class="dropdown-header">Pilih format export</li>',
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
                    'label' => 'Excel (xlsx)',
                    'icon' => 'glyphicon glyphicon-export',
                    'iconOptions' => ['class' => 'text-success'],
                    'alertMsg' => 'File Excel akan diunduh.',
                ],
            ],
        ]) ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'kode_mapel',
            'nama',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'contentOptions' => ['class' => 'grid-action-buttons'],
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<i class="fa fa-eye"></i>', ['view', 'id' => $model->kode_mapel], [
                            'class' => 'btn btn-info btn-sm',
                            'title' => 'Lihat',
                        ]);
                    },
                    'update' => function ($url, $model) {
                        return Html::a('<i class="fa fa-edit"></i>', ['update', 'id' => $model->kode_mapel], [
                            'class' => 'btn btn-warning btn-sm',
                            'title' => 'Ubah',
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<i class="fa fa-trash"></i>', ['delete', 'id' => $model->kode_mapel], [
                            'class' => 'btn btn-danger btn-sm',
                            'title' => 'Hapus',
                            'data' => [
                                'confirm' => 'Yakin ingin menghapus mapel ini?',
                                'method' => 'post',
                            ],
                        ]);
                    },
                ],
            ],
        ],
        'pjax' => true,
        'responsiveWrap' => false,
        'hover' => true,
        'condensed' => true,
        'export' => false,
        'summary' => false,
    ]); ?>

    <?php Pjax::end(); ?>

</div>