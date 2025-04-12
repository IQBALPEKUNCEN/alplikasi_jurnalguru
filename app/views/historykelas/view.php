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
?>
<div class="historykelas-view">
    <div class="d-flex justify-content-between mt-4 mb-2">
        <h2><?= 'Historykelas'  . Html::encode($this->title) ?></h2>

        <div>
                                    
            <?= GhostHtml::a('Baru', ['/historykelas/create'], ['class' => 'btn btn-success']) ?>
            <?= GhostHtml::a('List', ['/historykelas/index'], ['class' => 'btn btn-info']) ?>
            <?= GhostHtml::a('Update', ['/historykelas/update', 'id' => $model->history_id], ['class' => 'btn btn-primary']) ?>
            <?= GhostHtml::a('Delete', ['/historykelas/delete', 'id' => $model->history_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ])
            ?>
        </div>
    </div>

    <?php 
    $gridColumn = [
            'history_id',
        [
            'attribute' => 'nis0.nis',
            'label' => 'Nis',
        ],
        [
            'attribute' => 'kodeta0.kodeta',
            'label' => 'Kodeta',
        ],
        [
            'attribute' => 'kodeKelas.kode_kelas',
            'label' => 'Kode Kelas',
        ],
    ];
    echo DetailView::widget([
    'model' => $model,
    'attributes' => $gridColumn
    ]);
    ?>
    <br>
                        <br>
            <h4>Kelas<?= ' '. Html::encode($this->title) ?></h4>
            <?php 
            $gridColumnKelas = [
                    'kode_jenjang',
        'kode_jurusan',
        'nama',
            ];
            echo DetailView::widget([
            'model' => $model->kodeKelas,
            'attributes' => $gridColumnKelas            ]);
            ?>
                                <br>
            <h4>Siswa<?= ' '. Html::encode($this->title) ?></h4>
            <?php 
            $gridColumnSiswa = [
                    'nama',
        'kode_kelas',
        'kode_jk',
        'tempat_lahir',
        'tanggal_lahir',
        'no_hp',
        'alamat',
            ];
            echo DetailView::widget([
            'model' => $model->nis0,
            'attributes' => $gridColumnSiswa            ]);
            ?>
                                <br>
            <h4>Tahunajaran<?= ' '. Html::encode($this->title) ?></h4>
            <?php 
            $gridColumnTahunajaran = [
                    'semester',
        'namata',
        'isaktif',
            ];
            echo DetailView::widget([
            'model' => $model->kodeta0,
            'attributes' => $gridColumnTahunajaran            ]);
            ?>
            </div>