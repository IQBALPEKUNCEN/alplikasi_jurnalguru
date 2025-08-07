<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use app\modules\UserManagement\components\GhostHtml;

$this->title = $model->nama;
$this->params['breadcrumbs'][] = ['label' => '📘 Mata Pelajaran', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

// Styling modern UI
$this->registerCss(<<<CSS
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');

body {
    font-family: 'Inter', sans-serif;
    background-color: #f0f4f8;
    padding: 40px;
}

.mapel-view {
    background: #ffffff;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
    max-width: 1100px;
    margin: auto;
}

.mapel-view h2 {
    font-size: 24px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 20px;
}

.mapel-view .btn {
    border-radius: 8px;
    font-weight: 600;
    margin-left: 5px;
    padding: 8px 16px;
}

.btn-success {
    background-color: #10b981;
    color: white;
}

.btn-info {
    background-color: #3b82f6;
    color: white;
}

.btn-primary {
    background-color: #6366f1;
    color: white;
}

.btn-danger {
    background-color: #ef4444;
    color: white;
}

.kv-grid-table th {
    background-color: #1e3a8a;
    color: white;
    text-align: center;
}

.kv-grid-table td {
    background-color: #f9fafb;
    text-align: center;
    font-weight: 500;
}
CSS);
?>

<div class="mapel-view">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>📘 Mata Pelajaran: <?= Html::encode($this->title) ?></h2>
        <div>
            <?= GhostHtml::a('➕ Tambah Baru', ['create'], ['class' => 'btn btn-success']) ?>
            <?= GhostHtml::a('📋 Daftar Mapel', ['index'], ['class' => 'btn btn-info']) ?>
            <?= GhostHtml::a('✏️ Edit', ['update', 'id' => $model->kode_mapel], ['class' => 'btn btn-primary']) ?>
            <?= GhostHtml::a('🗑 Hapus', ['delete', 'id' => $model->kode_mapel], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Apakah Anda yakin ingin menghapus mata pelajaran ini?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'options' => ['class' => 'table table-borderless'],
        'attributes' => [
            [
                'label' => 'Kode Mapel',
                'value' => $model->kode_mapel,
            ],
            [
                'label' => 'Nama Mapel',
                'value' => $model->nama,
            ],
        ],
    ]) ?>

    <?php if ($providerJurnal && $providerJurnal->totalCount > 0): ?>
        <div class="mt-5">
            <?= GridView::widget([
                'dataProvider' => $providerJurnal,
                'pjax' => true,
                'pjaxSettings' => ['options' => ['id' => 'pjax-jurnal']],
                'panel' => [
                    'type' => GridView::TYPE_PRIMARY,
                    'heading' => '<i class="fa fa-book"></i> Jurnal Terkait Mata Pelajaran',
                ],
                'export' => false,
                'hover' => true,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'jurnal_id',
                    [
                        'attribute' => 'guru.nama',
                        'label' => 'Guru',
                    ],
                    [
                        'attribute' => 'kodeta0.kodeta',
                        'label' => 'Kodeta',
                    ],
                    [
                        'attribute' => 'hari.nama',
                        'label' => 'Hari',
                    ],
                    'jam_ke',
                    'materi:ntext',
                    [
                        'attribute' => 'kodeKelas.kode_kelas',
                        'label' => 'Kode Kelas',
                    ],
                    'jam_mulai',
                    'jam_selesai',
                    'status',
                    'waktupresensi',
                    'file_siswa',
                ],
            ]) ?>
        </div>
    <?php endif; ?>
</div>