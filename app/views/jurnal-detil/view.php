<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use app\modules\UserManagement\components\GhostHtml;

/* @var $this yii\web\View */
/* @var $model app\models\base\JurnalDetil */

$this->title = $model->detil_id;
$this->params['breadcrumbs'][] = ['label' => 'Jurnal Detil', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jurnal-detil-view">
    <div class="d-flex justify-content-between mt-4 mb-2">
        <h2><?= 'Jurnal Detil'  . Html::encode($this->title) ?></h2>

        <div>
                                    
            <?= GhostHtml::a('Baru', ['/jurnal-detil/create'], ['class' => 'btn btn-success']) ?>
            <?= GhostHtml::a('List', ['/jurnal-detil/index'], ['class' => 'btn btn-info']) ?>
            <?= GhostHtml::a('Update', ['/jurnal-detil/update', 'id' => $model->detil_id], ['class' => 'btn btn-primary']) ?>
            <?= GhostHtml::a('Delete', ['/jurnal-detil/delete', 'id' => $model->detil_id], [
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
        //     'detil_id',
        // [
        //     'attribute' => 'jurnal.jurnal_id',
        //     'label' => 'Jurnal',
        // ],
        [
            'attribute' => 'nis0.nis',
            'label' => 'Nis',
        ],
        'nama',
        'status',
        // 'waktu_presensi',
    ];
    echo DetailView::widget([
    'model' => $model,
    'attributes' => $gridColumn
    ]);
    ?>
    <br>
                        <br>
            <h4>Jurnal<?= ' '. Html::encode($this->title) ?></h4>
            <?php 
            $gridColumnJurnal = [
                    'nama',
        'kodeta',
        'hari_id',
        'jam_ke',
        'materi',
        'kode_kelas',
        'kode_mapel',
        'jam_mulai',
        'jam_selesai',
        'status',
        // 'waktupresensi',
        // 'file_siswa',
            ];
            echo DetailView::widget([
            'model' => $model->jurnal,
            'attributes' => $gridColumnJurnal            ]);
