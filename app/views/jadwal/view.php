<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Jadwal $model */

$this->title = 'Jadwal #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => '📅 Jadwal', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

\yii\web\YiiAsset::register($this);

// CSS untuk tampilan elegan
$this->registerCss(<<<CSS
.jadwal-view {
    background: #f0f9ff;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.07);
    font-family: 'Inter', sans-serif;
    max-width: 800px;
    margin: 30px auto;
}

.jadwal-view h1 {
    font-weight: bold;
    color: #1e40af;
    text-align: center;
    margin-bottom: 25px;
}

.jadwal-view .btn {
    border-radius: 8px;
    font-weight: bold;
    padding: 8px 18px;
    margin: 5px;
    font-size: 14px;
}

.jadwal-view .btn-primary {
    background: linear-gradient(to right, #2563eb, #1e3a8a);
    border: none;
    color: white;
}

.jadwal-view .btn-danger {
    background: linear-gradient(to right, #dc2626, #991b1b);
    border: none;
    color: white;
}

.detail-view th {
    width: 200px;
    background-color: #dbeafe;
    color: #1e3a8a;
    font-weight: 600;
    text-align: left;
}

.detail-view td {
    background-color: #eff6ff;
    color: #1f2937;
}
CSS);
?>

<div class="jadwal-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p class="text-center">
        <?= Html::a('✏️ Edit', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('🗑️ Hapus', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Yakin ingin menghapus jadwal ini?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'hari',
            'jam_mulai',
            'jam_selesai',
            [
                'attribute' => 'guru_id',
                'label' => 'Guru',
                'value' => $model->guru ? $model->guru->nama : '-',
            ],
            [
                'attribute' => 'kode_kelas',
                'label' => 'Kelas',
                'value' => $model->kodeKelas ? $model->kodeKelas->nama : '-',
            ],
            [
                'attribute' => 'kode_mapel',
                'label' => 'Mata Pelajaran',
                'value' => $model->kodeMapel ? $model->kodeMapel->nama : '-',
            ],
            [
                'attribute' => 'kode_jurusan',
                'label' => 'Jurusan',
                'value' => $model->kodeJurusan ? $model->kodeJurusan->nama : '-',
            ],
        ],
    ]) ?>

</div>