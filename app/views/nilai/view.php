<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Nilai $model */

$this->title = 'Detail Nilai Siswa';
$this->params['breadcrumbs'][] = ['label' => 'Data Nilai', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCss(<<<CSS
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap');

body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(to right, #74ebd5, #acb6e5);
    padding: 30px;
}

.nilai-view {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 40px;
    max-width: 800px;
    margin: auto;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    animation: fadeInUp 0.6s ease;
}

.nilai-view h1 {
    text-align: center;
    color: #2d3748;
    font-weight: 700;
    font-size: 2rem;
    margin-bottom: 30px;
}

.btn-primary, .btn-danger {
    padding: 10px 25px;
    border-radius: 10px;
    font-weight: 600;
    text-transform: uppercase;
    transition: 0.3s ease;
}

.btn-primary {
    background: linear-gradient(45deg, #00c6ff, #0072ff);
    border: none;
    color: #fff;
    margin-right: 10px;
}

.btn-primary:hover {
    background: linear-gradient(45deg, #0072ff, #00c6ff);
    transform: translateY(-2px);
}

.btn-danger {
    background: linear-gradient(45deg, #ff416c, #ff4b2b);
    border: none;
    color: #fff;
}

.btn-danger:hover {
    background: linear-gradient(45deg, #ff4b2b, #ff416c);
    transform: translateY(-2px);
}

.table {
    margin-top: 30px;
    border-radius: 12px;
    overflow: hidden;
}

.table th {
    background-color: #667eea;
    color: white;
    text-align: center;
    font-weight: 600;
}

.table td {
    background-color: #f8f9fa;
    text-align: center;
    font-weight: 500;
    color: #2d3748;
}

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}
CSS);
?>

<div class="nilai-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="text-center mb-4">
        <?= Html::a('✏️ Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('🗑️ Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Apakah Anda yakin ingin menghapus data ini?',
                'method' => 'post',
            ],
        ]) ?>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'options' => ['class' => 'table table-bordered table-hover'],
        'attributes' => [
            'id',
            [
                'attribute' => 'nis',
                'value' => $model->nis . ' - ' . ($model->siswa->nama ?? '(Nama tidak ditemukan)'),
                'label' => '👨‍🎓 Siswa',
            ],
            [
                'attribute' => 'kode_mapel',
                'label' => '📚 Kode Mapel',
            ],
            [
                'attribute' => 'nilai_angka',
                'label' => '📝 Nilai Angka',
            ],
            [
                'attribute' => 'semester',
                'label' => '📆 Semester',
            ],
            [
                'attribute' => 'tahun_ajaran',
                'label' => '📅 Tahun Ajaran',
            ],
        ],
    ]) ?>

</div>