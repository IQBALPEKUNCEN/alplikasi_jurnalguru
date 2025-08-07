<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use app\modules\UserManagement\components\GhostHtml;

/* @var $this yii\web\View */
/* @var $model app\models\base\Jurnal */
/* @var $providerJurnalDetil yii\data\ActiveDataProvider */

$this->title = 'Jurnal ID: ' . $model->jurnal_id;
$this->params['breadcrumbs'][] = ['label' => 'Jurnal', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCss(<<<CSS
.jurnal-view {
    background-color: #e3f2fd;
    padding: 20px;
    border-radius: 10px;
}

.jurnal-view h2, .jurnal-view h3, .jurnal-view h4 {
    color: #0d47a1;
    font-weight: bold;
}

.panel-primary > .panel-heading {
    background-color: #1976d2 !important;
    color: #fff;
    font-weight: bold;
}

.kv-grid-table th {
    background-color: #bbdefb;
    color: #0d47a1;
}

.kv-grid-table td {
    background-color: #f1f8ff;
}
CSS);
?>

<div class="jurnal-view">
    <div class="d-flex justify-content-between mt-4 mb-2">
        <h2><?= Html::encode($this->title) ?></h2>

        <div>
            <?= GhostHtml::a('Baru', ['/jurnal/create'], ['class' => 'btn btn-success']) ?>
            <?= GhostHtml::a('List', ['/jurnal/index'], ['class' => 'btn btn-info']) ?>
            <?= GhostHtml::a('Update', ['/jurnal/update', 'id' => $model->jurnal_id], ['class' => 'btn btn-primary']) ?>
            <?= GhostHtml::a('Delete', ['/jurnal/delete', 'id' => $model->jurnal_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Apakah Anda yakin ingin menghapus data ini?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'jurnal_id',
            [
                'attribute' => 'guru.nama',
                'label' => 'Guru',
                'value' => function ($model) {
                    return isset($model->guru) ? $model->guru->nama : 'Data tidak tersedia';
                },
            ],
            [
                'attribute' => 'kodeta0.kodeta',
                'label' => 'Tahun Ajaran',
                'value' => function ($model) {
                    return isset($model->kodeta0) ? $model->kodeta0->kodeta : 'Data tidak tersedia';
                },
            ],
            [
                'attribute' => 'hari.nama',
                'label' => 'Hari',
                'value' => function ($model) {
                    return isset($model->hari) ? $model->hari->nama : 'Data tidak tersedia';
                },
            ],
            'jam_ke',
            'materi:ntext',
            [
                'attribute' => 'kodeKelas.nama',
                'label' => 'Kelas',
                'value' => function ($model) {
                    return isset($model->kodeKelas) ? $model->kodeKelas->nama : 'Data tidak tersedia';
                },
            ],
            [
                'attribute' => 'kodeMapel.nama',
                'label' => 'Mata Pelajaran',
                'value' => function ($model) {
                    return isset($model->kodeMapel) ? $model->kodeMapel->nama : 'Data tidak tersedia';
                },
            ],
            'jam_mulai',
            'jam_selesai',
            'status',
            'waktupresensi',
        ],
    ]) ?>

    <br>
    <?php if (isset($model->guru)): ?>
        <h4>Data Guru</h4>
        <?= DetailView::widget([
            'model' => $model->guru,
            'attributes' => [
                'nama',
                'kode_jk',
                'nip',
                'nik',
                'tempat_lahir',
                'tanggal_lahir',
                'alamat',
            ],
        ]) ?>
    <?php endif; ?>

    <br>
    <?php if (isset($model->hari)): ?>
        <h4>Data Hari</h4>
        <?= DetailView::widget([
            'model' => $model->hari,
            'attributes' => [
                'nama',
            ],
        ]) ?>
    <?php endif; ?>

    <br>
    <?php if (isset($model->kodeKelas)): ?>
        <h4>Data Kelas</h4>
        <?= DetailView::widget([
            'model' => $model->kodeKelas,
            'attributes' => [
                'kode_jenjang',
                'kode_jurusan',
                'nama',
            ],
        ]) ?>
    <?php endif; ?>

    <br>
    <?php if (isset($model->kodeMapel)): ?>
        <h4>Data Mapel</h4>
        <?= DetailView::widget([
            'model' => $model->kodeMapel,
            'attributes' => [
                'nama',
            ],
        ]) ?>
    <?php endif; ?>

    <br>
    <?php if (isset($model->kodeta0)): ?>
        <h4>Data Tahun Ajaran</h4>
        <?= DetailView::widget([
            'model' => $model->kodeta0,
            'attributes' => [
                'semester',
                'namata',
                'isaktif',
            ],
        ]) ?>
    <?php endif; ?>

    <br><br>
    <h3>Detail Jurnal</h3>
    <?= GridView::widget([
        'dataProvider' => $providerJurnalDetil,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => 'Detail Presensi Siswa',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'NIS',
                'attribute' => 'nis',
                'value' => function ($model) {
                    return $model->nis ?? 'N/A';
                },
            ],
            [
                'label' => 'Nama Siswa',
                'value' => function ($model) {
                    if (isset($model->nis0) && isset($model->nis0->nama)) {
                        return $model->nis0->nama;
                    } elseif (isset($model->siswa) && isset($model->siswa->nama)) {
                        return $model->siswa->nama;
                    }
                    return 'Data tidak ditemukan';
                },
            ],
            [
                'label' => 'Status',
                'value' => function ($model) {
                    return $model->status ?? 'Tidak ada data';
                },
            ],
            [
                'label' => 'Kelas',
                'value' => function ($model) {
                    if (isset($model->nis0->kodeKelas->nama)) {
                        return $model->nis0->kodeKelas->nama;
                    } elseif (isset($model->siswa->kodeKelas->nama)) {
                        return $model->siswa->kodeKelas->nama;
                    }
                    return 'Data tidak tersedia';
                },
            ],
            [
                'label' => 'Jurusan',
                'value' => function ($model) {
                    if (isset($model->nis0->kodeKelas->kodeJurusan->nama)) {
                        return $model->nis0->kodeKelas->kodeJurusan->nama;
                    } elseif (isset($model->siswa->kodeKelas->kodeJurusan->nama)) {
                        return $model->siswa->kodeKelas->kodeJurusan->nama;
                    }
                    return 'Data tidak tersedia';
                },
            ],
        ],
    ]) ?>
</div>