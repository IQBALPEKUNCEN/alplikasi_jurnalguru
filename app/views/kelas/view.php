<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use app\modules\UserManagement\components\GhostHtml;

/* @var $this yii\web\View */
/* @var $model app\models\base\Kelas */

$this->title = $model->kode_kelas;
$this->params['breadcrumbs'][] = ['label' => 'Kelas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCss(<<<CSS
    .kelas-view {
        background: linear-gradient(to top left, #e3f2fd, #ffffff);
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }

    .kelas-view h2, .kelas-view h4 {
        color: #0d47a1;
        font-weight: bold;
    }

    .kelas-view .btn {
        font-weight: bold;
        padding: 8px 18px;
        margin-left: 5px;
        border-radius: 20px;
    }

    .kelas-view .btn-success {
        background: linear-gradient(to right, #26a69a, #00796b);
        color: white;
    }

    .kelas-view .btn-info {
        background: linear-gradient(to right, #42a5f5, #1e88e5);
        color: white;
    }

    .kelas-view .btn-primary {
        background: linear-gradient(to right, #5c6bc0, #3949ab);
        color: white;
    }

    .kelas-view .btn-danger {
        background: linear-gradient(to right, #ef5350, #d32f2f);
        color: white;
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
        background-color: #e3f2fd;
    }
CSS);
?>

<div class="kelas-view">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>📘 Kelas: <?= Html::encode($this->title) ?></h2>
        <div>
            <?= GhostHtml::a('➕ Baru', ['/kelas/create'], ['class' => 'btn btn-success']) ?>
            <?= GhostHtml::a('📋 List', ['/kelas/index'], ['class' => 'btn btn-info']) ?>
            <?= GhostHtml::a('✏️ Update', ['/kelas/update', 'id' => $model->kode_kelas], ['class' => 'btn btn-primary']) ?>
            <?= GhostHtml::a('🗑️ Hapus', ['/kelas/delete', 'id' => $model->kode_kelas], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Apakah anda ingin menghapus data ini?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'kode_kelas',
            [
                'attribute' => 'kodeJenjang.kode_jenjang',
                'label' => 'Kode Jenjang',
            ],
            [
                'attribute' => 'kodeJurusan.kode_jurusan',
                'label' => 'Kode Jurusan',
            ],
            'nama',
        ]
    ]) ?>

    <br>

    <?php if (isset($providerHistorykelas) && $providerHistorykelas->totalCount): ?>
        <?= GridView::widget([
            'dataProvider' => $providerHistorykelas,
            'pjax' => true,
            'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-historykelas']],
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '📚 History Kelas',
            ],
            'export' => false,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'history_id',
                [
                    'attribute' => 'nis0.nis',
                    'label' => 'NIS'
                ],
                [
                    'attribute' => 'kodeta0.kodeta',
                    'label' => 'Kode TA'
                ],
            ]
        ]) ?>
    <?php endif; ?>

    <br>

    <?php if (isset($providerJurnal) && $providerJurnal->totalCount): ?>
        <?= GridView::widget([
            'dataProvider' => $providerJurnal,
            'pjax' => true,
            'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-jurnal']],
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '📘 Jurnal Guru',
            ],
            'export' => false,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'jurnal_id',
                [
                    'attribute' => 'guru.nama',
                    'label' => 'Guru'
                ],
                [
                    'attribute' => 'kodeta0.kodeta',
                    'label' => 'Kode TA'
                ],
                [
                    'attribute' => 'hari.nama',
                    'label' => 'Hari'
                ],
                'jam_ke',
                'materi:ntext',
                [
                    'attribute' => 'kodeMapel.kode_mapel',
                    'label' => 'Kode Mapel'
                ],
                'jam_mulai',
                'jam_selesai',
                'status',
                'waktupresensi',
                'file_siswa',
            ]
        ]) ?>
    <?php endif; ?>

    <br>

    <?php if (!empty($model->kodeJenjang)): ?>
        <h4>🎓 Jenjang</h4>
        <?= DetailView::widget([
            'model' => $model->kodeJenjang,
            'attributes' => ['nama'],
        ]) ?>
    <?php endif; ?>

    <br>

    <?php if (!empty($model->kodeJurusan)): ?>
        <h4>🏫 Jurusan</h4>
        <?= DetailView::widget([
            'model' => $model->kodeJurusan,
            'attributes' => ['nama'],
        ]) ?>
    <?php endif; ?>
</div>