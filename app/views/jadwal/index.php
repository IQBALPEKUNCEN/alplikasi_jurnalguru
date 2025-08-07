<?php

use app\models\Jadwal;
use app\models\Ruangan;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use yii\widgets\Pjax;
use app\modules\UserManagement\components\GhostHtml;

/** @var yii\web\View $this */
/** @var app\models\JadwalSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = '📅 Jadwal Pelajaran';
$this->params['breadcrumbs'][] = $this->title;

// CSS Tampilan
$this->registerCss(<<<CSS
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
body {
    font-family: 'Inter', sans-serif;
    background-color: #f3f4f6;
    padding: 40px;
}
.jadwal-index {
    background: #ffffff;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
    max-width: 1200px;
    margin: auto;
    animation: fadeInUp 0.6s ease;
}
.jadwal-index h1 {
    font-size: 26px;
    font-weight: 700;
    text-align: center;
    color: #1e3a8a;
    margin-bottom: 25px;
}
.kv-grid-table thead th {
    background-color: #1e40af;
    color: white;
    text-align: center;
}
.kv-grid-table td {
    background-color: #f9fafb;
    text-align: center;
    font-weight: 500;
}
.action-buttons .btn {
    font-size: 12px;
    margin: 2px;
    padding: 5px 10px;
    border-radius: 6px;
}
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(40px); }
    to { opacity: 1; transform: translateY(0); }
}
CSS);

// Ambil semua kelas unik
$kelasList = Jadwal::find()
    ->select('kode_kelas')
    ->distinct()
    ->orderBy('kode_kelas')
    ->asArray()
    ->all();

// Siapkan kolom
$gridColumn = [
    ['class' => 'yii\grid\SerialColumn'],
    'hari',
    'jam_mulai',
    'jam_selesai',
    [
        'attribute' => 'guru_id',
        'label' => 'Guru Pengajar',
        'value' => function ($model) {
            return $model->guru->nama ?? '(Tidak Ada)';
        },
    ],
    [
        'attribute' => 'ruangan_id',
        'label' => 'Ruangan',
        'value' => 'ruangan.nama',
        'filter' => ArrayHelper::map(Ruangan::find()->all(), 'id', 'nama'),
    ],
    'kode_mapel',
    'kode_jurusan',
    [
        'class' => 'yii\grid\ActionColumn',
        'contentOptions' => ['class' => 'action-buttons'],
        'urlCreator' => function ($action, Jadwal $model, $key, $index, $column) {
            return Url::toRoute([$action, 'id' => $model->id]);
        },
        'buttons' => [
            'view' => fn($url, $model) => Html::a('<i class="fa fa-eye"></i>', $url, [
                'class' => 'btn btn-info btn-sm',
                'title' => 'Lihat Detail',
            ]),
            'update' => fn($url, $model) => Html::a('<i class="fa fa-edit"></i>', $url, [
                'class' => 'btn btn-warning btn-sm',
                'title' => 'Edit Jadwal',
            ]),
            'delete' => fn($url, $model) => Html::a('<i class="fa fa-trash"></i>', $url, [
                'class' => 'btn btn-danger btn-sm',
                'title' => 'Hapus Jadwal',
                'data' => [
                    'confirm' => 'Yakin ingin menghapus jadwal ini?',
                    'method' => 'post',
                ],
            ]),
        ],
    ],
];
?>

<div class="jadwal-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="action-buttons d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <?= GhostHtml::a('<span class="glyphicon glyphicon-plus-sign"></span> Tambah', ['create'], ['class' => 'btn btn-success']) ?>

        <?= ExportMenu::widget([
            'dataProvider' => $dataProvider,
            'columns' => $gridColumn,
            'target' => ExportMenu::TARGET_BLANK,
            'fontAwesome' => true,
            'dropdownOptions' => [
                'label' => 'Export',
                'class' => 'btn btn-outline-secondary',
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

    <?php Pjax::begin(); ?>

    <?php foreach ($kelasList as $kelas): ?>
        <h4 class="mt-5 mb-3 text-primary">📘 Jadwal untuk Kelas: <strong><?= Html::encode($kelas['kode_kelas']) ?></strong></h4>

        <?php
        $kelasProvider = new \yii\data\ActiveDataProvider([
            'query' => Jadwal::find()->where(['kode_kelas' => $kelas['kode_kelas']])->orderBy(['hari' => SORT_ASC, 'jam_mulai' => SORT_ASC]),
            'pagination' => false,
        ]);

        echo GridView::widget([
            'dataProvider' => $kelasProvider,
            'columns' => $gridColumn,
            'responsiveWrap' => false,
            'hover' => true,
            'condensed' => true,
            'summary' => false,
            'export' => false,
        ]);
        ?>
    <?php endforeach; ?>

    <?php Pjax::end(); ?>
</div>