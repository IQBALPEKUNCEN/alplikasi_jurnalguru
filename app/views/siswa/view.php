<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use app\modules\UserManagement\components\GhostHtml;

$this->title = $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Siswa', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

// Tambahkan CSS custom
$this->registerCss(<<<CSS
    .siswa-view {
        background: linear-gradient(to right, #e3f2fd, #f5faff);
        border-radius: 16px;
        padding: 30px;
        margin-top: 30px;
        box-shadow: 0 8px 16px rgba(0,0,0,0.05);
    }

    .siswa-view h2 {
        color: #1976d2;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .btn-group-siswa a {
        margin-right: 8px;
    }

    .kv-grid-table > thead > tr > th {
        background-color: #bbdefb;
        color: #0d47a1;
        text-align: center;
    }

    .kv-grid-table > tbody > tr > td {
        background-color: #e3f2fd;
    }

    .detail-view th {
        width: 180px;
        background-color: #e1f5fe;
        color: #01579b;
    }

    .detail-view td {
        background-color: #f0faff;
    }

    .section-title {
        font-size: 18px;
        font-weight: 600;
        color: #0d47a1;
        border-bottom: 2px solid #90caf9;
        padding-bottom: 5px;
        margin-top: 30px;
        margin-bottom: 15px;
    }
CSS);
?>

<div class="siswa-view">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-user-graduate"></i> <?= Html::encode($this->title) ?></h2>
        <div class="btn-group-siswa">
            <?= GhostHtml::a('<i class="fas fa-plus"></i>', ['create'], [
                'class' => 'btn btn-success',
                'title' => 'Tambah Siswa'
            ]) ?>
            <?= GhostHtml::a('<i class="fas fa-list"></i>', ['index'], [
                'class' => 'btn btn-info',
                'title' => 'Daftar Siswa'
            ]) ?>
            <?= GhostHtml::a('<i class="fas fa-edit"></i>', ['update', 'id' => $model->nis], [
                'class' => 'btn btn-primary',
                'title' => 'Edit Data'
            ]) ?>
            <?= GhostHtml::a('<i class="fas fa-trash-alt"></i>', ['delete', 'id' => $model->nis], [
                'class' => 'btn btn-danger',
                'title' => 'Hapus',
                'data' => [
                    'confirm' => 'Apakah anda yakin ingin menghapus data ini?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </div>

    <div class="section-title">Detail Siswa</div>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'nis',
            'nama',
            'kode_kelas',
            [
                'attribute' => 'kode_jk',
                'label' => 'Jenis Kelamin',
                'value' => function ($model) {
                    return $model->kode_jk === 'L' ? 'Laki-laki' : 'Perempuan';
                },
            ],
            'tempat_lahir',
            'tanggal_lahir',
            'no_hp',
            'alamat',
        ],
    ]) ?>

    <?php if ($providerHistorykelas->totalCount): ?>
        <div class="section-title">Riwayat Kelas</div>
        <?= GridView::widget([
            'dataProvider' => $providerHistorykelas,
            'pjax' => true,
            'pjaxSettings' => ['options' => ['id' => 'historykelas-grid']],
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<i class="fas fa-history"></i> History Kelas',
            ],
            'export' => false,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'history_id',
                [
                    'attribute' => 'kodeta0.kodeta',
                    'label' => 'Kode TA'
                ],
                [
                    'attribute' => 'kodeKelas.kode_kelas',
                    'label' => 'Kelas'
                ],
            ],
        ]) ?>
    <?php endif; ?>

    <!-- ?php if ($providerJurnalDetil->totalCount): ?>
        <div class="section-title">Data Presensi</div>
        <?= GridView::widget([
            'dataProvider' => $providerJurnalDetil,
            'pjax' => true,
            'pjaxSettings' => ['options' => ['id' => 'jurnal-grid']],
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<i class="fas fa-calendar-check"></i> Jurnal Kehadiran',
            ],
            'export' => false,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'detil_id',
                [
                    'attribute' => 'jurnal.jurnal_id',
                    'label' => 'ID Jurnal'
                ],
                'nama',
                'status',
                'waktu_presensi',
            ],
        ]) ?>
    ?php endif; ?> -->

</div>