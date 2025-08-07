<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use app\modules\UserManagement\components\GhostHtml;

/* @var $this yii\web\View */
/* @var $model app\models\base\Jenjang */
/* @var $providerKelas yii\data\ActiveDataProvider */

$this->title = '🎓 Jenjang: ' . $model->kode_jenjang;
$this->params['breadcrumbs'][] = ['label' => 'Jenjang', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCss("
    body {
        background: linear-gradient(to right, #c9d6ff, #e2e2e2);
    }

    .jenjang-view {
        background: #ffffff;
        padding: 30px;
        border-radius: 20px;
        margin-top: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .jenjang-view h2 {
        text-align: center;
        color: #34495e;
        font-weight: bold;
        margin-bottom: 30px;
    }

    .action-buttons {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-bottom: 30px;
    }

    .action-buttons .btn {
        border-radius: 10px;
        font-weight: bold;
        padding: 10px 20px;
        font-size: 14px;
    }

    .btn-success {
        background: linear-gradient(to right, #43cea2, #185a9d);
        color: white;
    }

    .btn-info {
        background: linear-gradient(to right, #56ccf2, #2f80ed);
        color: white;
    }

    .btn-primary {
        background: linear-gradient(to right, #2980b9, #2c3e50);
        color: white;
    }

    .btn-danger {
        background: linear-gradient(to right, #e53935, #b71c1c);
        color: white;
    }

    .kv-grid-table th {
        background-color: #3498db;
        color: white;
        text-align: center;
    }

    .kv-grid-table td {
        background-color: #f9f9f9;
        text-align: center;
    }

    .detail-view th {
        width: 200px;
        background: #ecf0f1;
    }

    .detail-view td {
        background: #ffffff;
    }
");
?>

<div class="jenjang-view container">

    <h2><?= Html::encode($this->title) ?></h2>

    <div class="action-buttons">
        <?= GhostHtml::a('➕ Baru', ['create'], ['class' => 'btn btn-success']) ?>
        <?= GhostHtml::a('📋 List', ['index'], ['class' => 'btn btn-info']) ?>
        <?= GhostHtml::a('✏️ Update', ['update', 'id' => $model->kode_jenjang], ['class' => 'btn btn-primary']) ?>
        <?= GhostHtml::a('🗑️ Hapus', ['delete', 'id' => $model->kode_jenjang], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Apakah Anda yakin ingin menghapus item ini?',
                'method' => 'post',
            ],
        ]) ?>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'options' => ['class' => 'table table-striped table-bordered detail-view'],
        'attributes' => [
            [
                'attribute' => 'kode_jenjang',
                'label' => '📘 Kode Jenjang',
            ],
            [
                'attribute' => 'nama',
                'label' => '🏫 Nama Jenjang',
            ],
        ],
    ]) ?>

    <?php if ($providerKelas->totalCount): ?>
        <hr>
        <?= GridView::widget([
            'dataProvider' => $providerKelas,
            'pjax' => true,
            'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-kelas']],
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<b>📚 Kelas dalam Jenjang Ini</b>',
            ],
            'export' => false,
            'responsiveWrap' => false,
            'hover' => true,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'kode_kelas',
                [
                    'attribute' => 'kodeJurusan.kode_jurusan',
                    'label' => '🧑‍🏫 Kode Jurusan',
                ],
                [
                    'attribute' => 'nama',
                    'label' => '🏫 Nama Kelas',
                ],
            ],
        ]) ?>
    <?php endif; ?>

</div>