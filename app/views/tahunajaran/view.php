<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use app\modules\UserManagement\components\GhostHtml;

/* @var $this yii\web\View */
/* @var $model app\models\base\Tahunajaran */
/* @var $providerHistorykelas yii\data\ActiveDataProvider */
/* @var $providerJurnal yii\data\ActiveDataProvider */

$this->title = $model->kodeta;
$this->params['breadcrumbs'][] = ['label' => 'Tahun Ajaran', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCss(<<<CSS
.tahunajaran-view {
    background: #ffffff;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.05);
    margin-top: 30px;
    font-family: 'Segoe UI', sans-serif;
}

.tahunajaran-view h2 {
    color: #1a237e;
    font-weight: 700;
    margin-bottom: 25px;
}

.tahunajaran-view .btn {
    font-weight: 600;
    border-radius: 10px;
    padding: 10px 18px;
    margin-left: 5px;
}

.tahunajaran-view .btn-success {
    background: linear-gradient(135deg, #00b894, #00cec9);
    border: none;
}

.tahunajaran-view .btn-info {
    background: linear-gradient(135deg, #74b9ff, #0984e3);
    border: none;
}

.tahunajaran-view .btn-primary {
    background: linear-gradient(135deg, #a29bfe, #6c5ce7);
    border: none;
}

.tahunajaran-view .btn-danger {
    background: linear-gradient(135deg, #ff7675, #d63031);
    border: none;
}

.kv-grid-table th {
    background-color: #bbdefb;
    color: #0d47a1;
    text-align: center;
}

.kv-grid-table td {
    background-color: #e3f2fd;
    text-align: center;
}
CSS);
?>

<div class="tahunajaran-view">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>📘 Tahun Ajaran: <?= Html::encode($this->title) ?></h2>
        <div>
            <?= GhostHtml::a('➕ Baru', ['create'], ['class' => 'btn btn-success']) ?>
            <?= GhostHtml::a('📋 List', ['index'], ['class' => 'btn btn-info']) ?>
            <?= GhostHtml::a('✏️ Update', ['update', 'id' => $model->kodeta], ['class' => 'btn btn-primary']) ?>
            <?= GhostHtml::a('🗑️ Hapus', ['delete', 'id' => $model->kodeta], [
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
            'kodeta',
            'semester',
            'namata',
            [
                'attribute' => 'isaktif',
                'value' => $model->isaktif ? '✅ Aktif' : '❌ Tidak Aktif',
            ],
        ],
    ]) ?>

    <br>

    <!-- <?php if ($providerHistorykelas->totalCount > 0): ?>
        <?= GridView::widget([
            'dataProvider' => $providerHistorykelas,
            'pjax' => true,
            'pjaxSettings' => ['options' => ['id' => 'pjax-historykelas']],
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<i class="glyphicon glyphicon-education"></i> History Kelas',
            ],
            'export' => false,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'history_id',
                [
                    'attribute' => 'nis0.nis',
                    'label' => 'NIS',
                ],
                [
                    'attribute' => 'kodeKelas.kode_kelas',
                    'label' => 'Kode Kelas',
                ],
            ],
        ]) ?>
    <?php endif; ?> -->

    <?php if ($providerJurnal->totalCount > 0): ?>
        <?= GridView::widget([
            'dataProvider' => $providerJurnal,
            'pjax' => true,
            'pjaxSettings' => ['options' => ['id' => 'pjax-jurnal']],
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<i class="glyphicon glyphicon-book"></i> Jurnal',
            ],
            'export' => false,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'jurnal_id',
                [
                    'attribute' => 'guru.guru_id',
                    'label' => 'Guru',
                ],
                [
                    'attribute' => 'hari.hari_id',
                    'label' => 'Hari',
                ],
                'jam_ke',
                'materi:ntext',
                [
                    'attribute' => 'kodeKelas.kode_kelas',
                    'label' => 'Kelas',
                ],
                [
                    'attribute' => 'kodeMapel.kode_mapel',
                    'label' => 'Mapel',
                ],
                'jam_mulai',
                'jam_selesai',
                'status',
                'waktupresensi',
            ],
        ]) ?>
    <?php endif; ?>
</div>