<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use app\modules\UserManagement\components\GhostHtml;

/* @var $this yii\web\View */
/* @var $model app\models\base\Historykelas */

$this->title = $model->history_id;
$this->params['breadcrumbs'][] = ['label' => 'Historykelas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

// Tambahkan CSS dominasi biru
$this->registerCss(<<<CSS
    .historykelas-view {
        background-color: #e3f2fd;
        padding: 20px;
        border-radius: 10px;
    }

    .historykelas-view h2, .historykelas-view h4 {
        color: #0d47a1;
        font-weight: bold;
    }

    .historykelas-view .btn-success {
        background-color: #00796b;
        border-color: #004d40;
    }

    .historykelas-view .btn-info {
        background-color: #0288d1;
        border-color: #01579b;
    }

    .historykelas-view .btn-primary {
        background-color: #1565c0;
        border-color: #0d47a1;
    }

    .historykelas-view .btn-danger {
        background-color: #d32f2f;
        border-color: #b71c1c;
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

<div class="historykelas-view">
    <div class="d-flex justify-content-between mt-4 mb-2">
        <h2><?= 'History Kelas ID: ' . Html::encode($this->title) ?></h2>

        <div>
            <?= GhostHtml::a('Baru', ['/historykelas/create'], ['class' => 'btn btn-success']) ?>
            <?= GhostHtml::a('List', ['/historykelas/index'], ['class' => 'btn btn-info']) ?>
            <?= GhostHtml::a('Update', ['/historykelas/update', 'id' => $model->history_id], ['class' => 'btn btn-primary']) ?>
            <?= GhostHtml::a('Delete', ['/historykelas/delete', 'id' => $model->history_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Apakah anda yakin ingin menghapus item ini?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'history_id',
            [
                'attribute' => 'nis0.nis',
                'label' => 'NIS',
            ],
            [
                'attribute' => 'kodeta0.kodeta',
                'label' => 'Kode Tahun Ajaran',
            ],
            [
                'attribute' => 'kodeKelas.kode_kelas',
                'label' => 'Kode Kelas',
            ],
        ],
    ]) ?>

    <br>
    <?php if ($model->kodeKelas): ?>
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
    <?php if ($model->nis0): ?>
        <h4>Data Siswa</h4>
        <?= DetailView::widget([
            'model' => $model->nis0,
            'attributes' => [
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
    <?php endif; ?>

    <br>
    <?php if ($model->kodeta0): ?>
        <h4>Data Tahun Ajaran</h4>
        <?= DetailView::widget([
            'model' => $model->kodeta0,
            'attributes' => [
                'semester',
                'namata',
                [
                    'attribute' => 'isaktif',
                    'label' => 'Status',
                    'value' => function ($model) {
                        return $model->isaktif ? 'Aktif' : 'Tidak Aktif';
                    },
                ],
            ],
        ]) ?>
    <?php endif; ?>
</div>