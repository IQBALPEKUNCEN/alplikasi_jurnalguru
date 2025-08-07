<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Ruangan $model */

$this->title = 'Detail Ruangan #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Data Ruangan', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

\yii\web\YiiAsset::register($this);

// Tambahkan CSS khusus
$this->registerCss(<<<CSS
.ruangan-view {
    background-color: #ffffff;
    border-radius: 15px;
    padding: 30px;
    max-width: 700px;
    margin: auto;
    box-shadow: 0 10px 20px rgba(0,0,0,0.08);
    animation: fadeIn 0.4s ease-in-out;
}

.ruangan-view h1 {
    text-align: center;
    font-weight: bold;
    color: #34495e;
    margin-bottom: 30px;
}

.ruangan-view .btn {
    margin-right: 10px;
}

.ruangan-view .table {
    font-size: 16px;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
CSS);
?>

<div class="ruangan-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="text-center mb-4">
        <?= Html::a('✏️ Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('🗑️ Hapus', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Apakah Anda yakin ingin menghapus data ini?',
                'method' => 'post',
            ],
        ]) ?>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'options' => ['class' => 'table table-striped table-bordered detail-view'],
        'attributes' => [
            'id',
            'nama',
        ],
    ]) ?>

</div>`