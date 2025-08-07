<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use app\modules\UserManagement\components\GhostHtml;

/* @var $this yii\web\View */
/* @var $model app\models\base\Guru */
/* @var $providerJurnal yii\data\ActiveDataProvider|null */

$this->title = $model->guru_id;
$this->params['breadcrumbs'][] = ['label' => 'Guru', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

// Custom CSS
$this->registerCss(<<<CSS
    .guru-view {
        background-color: #f4faff;
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 12px 25px rgba(0,0,0,0.06);
        font-family: 'Segoe UI', sans-serif;
        margin-top: 20px;
    }

    .guru-view h2 {
        color: #0d47a1;
        font-weight: bold;
        margin-bottom: 30px;
        font-size: 28px;
    }

    .guru-view .btn {
        border-radius: 25px;
        padding: 8px 20px;
        font-weight: 600;
        margin-left: 5px;
        font-size: 14px;
    }

    .guru-view .btn-success {
        background: linear-gradient(135deg, #00c853, #2e7d32);
        color: white;
    }

    .guru-view .btn-info {
        background: linear-gradient(135deg, #29b6f6, #0288d1);
        color: white;
    }

    .guru-view .btn-primary {
        background: linear-gradient(135deg, #1e88e5, #1565c0);
        color: white;
    }

    .guru-view .btn-danger {
        background: linear-gradient(135deg, #e53935, #b71c1c);
        color: white;
    }

    .panel-primary > .panel-heading {
        background-color: #1565c0 !important;
        color: #fff;
        font-weight: bold;
        border-radius: 8px 8px 0 0;
    }

    .kv-grid-table th {
        background-color: #e3f2fd;
        color: #0d47a1;
        text-align: center;
    }

    .kv-grid-table td {
        background-color: #ffffff;
    }

    .detail-view th {
        width: 200px;
        color: #0d47a1;
    }

    .detail-view td {
        color: #333;
    }
CSS);
?>

<div class="guru-view">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="glyphicon glyphicon-user"></i> <?= Html::encode("Detail Guru: $model->nama") ?></h2>
        <div>
            <?= GhostHtml::a('<i class="glyphicon glyphicon-plus-sign"></i> Baru', ['/guru/create'], ['class' => 'btn btn-success']) ?>
            <?= GhostHtml::a('<i class="glyphicon glyphicon-list"></i> Daftar', ['/guru/index'], ['class' => 'btn btn-info']) ?>
            <?= GhostHtml::a('<i class="glyphicon glyphicon-edit"></i> Ubah', ['/guru/update', 'id' => $model->guru_id], ['class' => 'btn btn-primary']) ?>
            <?= GhostHtml::a('<i class="glyphicon glyphicon-trash"></i> Hapus', ['/guru/delete', 'id' => $model->guru_id], [
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
            'guru_id',
            'nama',
            [
                'attribute' => 'kode_jk',
                'label' => 'Jenis Kelamin',
                'value' => function ($model) {
                    return $model->kodeJk ? $model->kodeJk->nama : 'N/A';
                },
            ],
            'nip',
            'nik',
            'tempat_lahir',
            [
                'attribute' => 'tanggal_lahir',
                'value' => Yii::$app->formatter->asDate($model->tanggal_lahir),
            ],
            'alamat',
            'jabatan',

        ],
    ]) ?>

    <hr>

    <?php if ($providerJurnal && $providerJurnal->totalCount > 0): ?>
        <?= GridView::widget([
            'dataProvider' => $providerJurnal,
            'pjax' => true,
            'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-jurnal']],
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<i class="glyphicon glyphicon-book"></i> Daftar Jurnal Mengajar',
            ],
            'export' => false,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'jurnal_id',
                [
                    'attribute' => 'kodeta0.kodeta',
                    'label' => 'Kodeta'
                ],
                [
                    'attribute' => 'hari.nama',
                    'label' => 'Hari'
                ],
                'jam_ke',
                'materi:ntext',
                [
                    'attribute' => 'kodeKelas.kode_kelas',
                    'label' => 'Kelas'
                ],
                [
                    'attribute' => 'kodeMapel.kode_mapel',
                    'label' => 'Mapel'
                ],
                'jam_mulai',
                'jam_selesai',
                'status',
                'waktupresensi',
                'file_siswa',
            ],
        ]) ?>
    <?php endif; ?>

</div>