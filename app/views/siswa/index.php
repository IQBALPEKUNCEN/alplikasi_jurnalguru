<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use yii\widgets\Pjax;
use app\modules\UserManagement\components\GhostHtml;
use app\modules\UserManagement\models\User;

/** @var yii\web\View $this */
/** @var app\models\SiswaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Data Siswa';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs("$('.search-button').click(function(){
    $('.search-form').toggle(1000);
    return false;
});");

$this->registerCss(<<<CSS
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
body {
    font-family: 'Inter', sans-serif;
    background: linear-gradient(to right, #d9afd9, #97d9e1);
    padding: 30px;
}
.siswa-index {
    background: rgba(255, 255, 255, 0.95);
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    max-width: 1200px;
    margin: auto;
    animation: fadeInUp 0.5s ease-in-out;
}
.siswa-index h1 {
    text-align: center;
    font-weight: 700;
    margin-bottom: 30px;
    color: #2c3e50;
}
.btn-success {
    background: linear-gradient(45deg, #28a745, #218838);
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: bold;
    color: #fff;
    transition: all 0.3s ease;
}
.btn-success:hover {
    background: linear-gradient(45deg, #218838, #28a745);
    transform: scale(1.05);
}
.btn-default {
    background: #5c6bc0;
    color: #fff;
    font-weight: bold;
    border-radius: 8px;
    padding: 10px 20px;
    border: none;
}
.kv-grid-table thead th {
    background-color: #2c3e50;
    color: white;
    text-align: center;
}
.kv-grid-table td {
    text-align: center;
    background-color: #f9f9f9;
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

<div class="siswa-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p class="text-center">
        <?= GhostHtml::a('+ Tambah Siswa', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <div class="action-buttons text-center mb-4">
        <?= ExportMenu::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'nis',
                'nama',
                'kode_kelas',
                [
                    'attribute' => 'kode_jk',
                    'value' => function ($model) {
                        return $model->kode_jk === 'L' ? 'Laki-laki' : 'Perempuan';
                    },
                    'label' => 'Jenis Kelamin',
                ],
                'tempat_lahir',
                'tanggal_lahir',
                'no_hp',
                'alamat',
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
        'columns' => array_merge([
            ['class' => 'yii\grid\SerialColumn'],
            'nis',
            'nama',
            [
                'attribute' => 'kode_kelas',
                'label' => 'Kelas',
                'group' => true, // Aktifkan pengelompokan
                'groupedRow' => true, // Tampilkan header baris
                'contentOptions' => ['style' => 'background-color: #e0f7fa; font-weight: bold; font-size: 16px'],
            ],
            [
                'attribute' => 'kode_jk',
                'label' => 'Jenis Kelamin',
                'value' => function ($model) {
                    return $model->kode_jk === 'L' ? 'Laki-laki' : 'Perempuan';
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ['L' => 'Laki-laki', 'P' => 'Perempuan'],
                'filterWidgetOptions' => ['pluginOptions' => ['allowClear' => true]],
                'filterInputOptions' => ['placeholder' => 'Pilih Jenis Kelamin'],
            ],
            'tempat_lahir',
            'tanggal_lahir',
            'no_hp',
            'alamat',
            'telegram_id', // ✅ tambahkan di sini juga,
        ], User::getCurrentUser()->hasRoleName('wali_kelas') ? [] : [[
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view} {update} {delete}',
            'contentOptions' => ['class' => 'grid-action-buttons'],
            'buttons' => [
                'view' => fn($url, $model) => Html::a('<i class="fa fa-eye"></i>', ['view', 'id' => $model->nis], [
                    'class' => 'btn btn-info btn-sm',
                    'title' => 'Lihat',
                ]),
                'update' => fn($url, $model) => Html::a('<i class="fa fa-edit"></i>', ['update', 'id' => $model->nis], [
                    'class' => 'btn btn-warning btn-sm',
                    'title' => 'Edit',
                ]),
                'delete' => fn($url, $model) => Html::a('<i class="fa fa-trash"></i>', ['delete', 'id' => $model->nis], [
                    'class' => 'btn btn-danger btn-sm',
                    'title' => 'Hapus',
                    'data' => ['confirm' => 'Yakin ingin menghapus data ini?', 'method' => 'post'],
                ]),
            ],
        ]]),
        'pjax' => true,
        'responsiveWrap' => false,
        'hover' => true,
        'condensed' => true,
        'export' => false,
        'summary' => false,
    ]); ?>

    <?php Pjax::end(); ?>
</div>