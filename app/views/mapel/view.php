<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use app\modules\UserManagement\components\GhostHtml;

/* @var $this yii\web\View */
/* @var $model app\models\base\Mapel */

$this->title = $model->kode_mapel;
$this->params['breadcrumbs'][] = ['label' => 'Mapel', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mapel-view">
    <div class="d-flex justify-content-between mt-4 mb-2">
        <h2><?= 'Mapel'  . Html::encode($this->title) ?></h2>

        <div>
                                    
            <?= GhostHtml::a('Baru', ['/mapel/create'], ['class' => 'btn btn-success']) ?>
            <?= GhostHtml::a('List', ['/mapel/index'], ['class' => 'btn btn-info']) ?>
            <?= GhostHtml::a('Update', ['/mapel/update', 'id' => $model->kode_mapel], ['class' => 'btn btn-primary']) ?>
            <?= GhostHtml::a('Delete', ['/mapel/delete', 'id' => $model->kode_mapel], [
                'class' => 'btn btn-danger',
                'data' => [
<<<<<<< HEAD
                    'confirm' => 'apakah anda ingin menghapus data ini?',
=======
                    'confirm' => 'Are you sure you want to delete this item?',
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
                    'method' => 'post',
                ],
            ])
            ?>
        </div>
    </div>

    <?php 
    $gridColumn = [
            'kode_mapel',
        'nama',
    ];
    echo DetailView::widget([
    'model' => $model,
    'attributes' => $gridColumn
    ]);
    ?>
    <br>
                            <?php
                if($providerJurnal->totalCount){
                $gridColumnJurnal = [
                ['class' => 'yii\grid\SerialColumn'],
                            'jurnal_id',
            [
<<<<<<< HEAD
                'attribute' => 'guru.nama',
=======
                'attribute' => 'guru.guru_id',
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
                'label' => 'Guru'
            ],
            [
                'attribute' => 'kodeta0.kodeta',
                'label' => 'Kodeta'
            ],
            [
<<<<<<< HEAD
                'attribute' => 'hari.nama',
=======
                'attribute' => 'hari.hari_id',
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
                'label' => 'Hari'
            ],
            'jam_ke',
            'materi:ntext',
            [
                'attribute' => 'kodeKelas.kode_kelas',
                'label' => 'Kode Kelas'
            ],
                        'jam_mulai',
            'jam_selesai',
<<<<<<< HEAD
            // 'status',
            // 'waktupresensi',
            // 'file_siswa',
=======
            'status',
            'waktupresensi',
            'file_siswa',
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
                ];
                echo Gridview::widget([
                'dataProvider' => $providerJurnal,
                'pjax' => true,
                'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-jurnal']],
                'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode('Jurnal'),
                ],
                                    'export' => false,
                                'columns' => $gridColumnJurnal
                ]);
                }
                ?>
            </div>