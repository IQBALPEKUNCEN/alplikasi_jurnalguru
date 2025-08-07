<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use app\modules\UserManagement\components\GhostHtml;

/* @var $this yii\web\View */
/* @var $model app\models\base\Jurusan */
/* @var $providerKelas yii\data\ActiveDataProvider */

$this->title = $model->kode_jurusan;
$this->params['breadcrumbs'][] = ['label' => 'Jurusan', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCss(<<<CSS
    .jurusan-view {
        background-color: #f4faff;
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 12px 25px rgba(0,0,0,0.06);
        font-family: 'Segoe UI', sans-serif;
        margin-top: 20px;
    }

    .jurusan-view h2 {
        color: #0d47a1;
        font-weight: bold;
        margin-bottom: 30px;
        font-size: 28px;
    }

    .jurusan-view .btn {
        border-radius: 25px;
        padding: 8px 20px;
        font-weight: 600;
        margin-left: 5px;
        font-size: 14px;
    }

    .jurusan-view .btn-success {
        background: linear-gradient(135deg, #00c853, #2e7d32);
        color: white;
    }

    .jurusan-view .btn-info {
        background: linear-gradient(135deg, #29b6f6, #0288d1);
        color: white;
    }

    .jurusan-view .btn-primary {
        background: linear-gradient(135deg, #1e88e5, #1565c0);
        color: white;
    }

    .jurusan-view .btn-danger {
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

<div class="jurusan-view">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="glyphicon glyphicon-education"></i> <?= Html::encode("Detail Jurusan: $model->kode_jurusan") ?></h2>
        <div>
            <?= GhostHtml::a('<i class="glyphicon glyphicon-plus-sign"></i> Baru', ['/jurusan/create'], ['class' => 'btn btn-success']) ?>
            <?= GhostHtml::a('<i class="glyphicon glyphicon-list"></i> Daftar', ['/jurusan/index'], ['class' => 'btn btn-info']) ?>
            <?= GhostHtml::a('<i class="glyphicon glyphicon-edit"></i> Ubah', ['/jurusan/update', 'id' => $model->kode_jurusan], ['class' => 'btn btn-primary']) ?>
            <?= GhostHtml::a('<i class="glyphicon glyphicon-trash"></i> Hapus', ['/jurusan/delete', 'id' => $model->kode_jurusan], [
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
            'kode_jurusan',
            'nama',
        ],
    ]) ?>

    <hr>

    <?php if ($providerKelas->totalCount): ?>
        <?= GridView::widget([
            'dataProvider' => $providerKelas,
            'pjax' => true,
            'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-kelas']],
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<i class="glyphicon glyphicon-th-list"></i> Daftar Kelas dalam Jurusan Ini',
            ],
            'export' => false,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'kode_kelas',
                [
                    'attribute' => 'kodeJenjang.kode_jenjang',
                    'label' => 'Kode Jenjang',
                ],
                'nama',
            ],
        ]) ?>
    <?php endif; ?>

</div>