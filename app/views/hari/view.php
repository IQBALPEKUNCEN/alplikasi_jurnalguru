<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use app\modules\UserManagement\components\GhostHtml;

/* @var $this yii\web\View */
/* @var $model app\models\base\Hari */

<<<<<<< HEAD
$this->title = $model->nama;
=======
$this->title = $model->hari_id;
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
$this->params['breadcrumbs'][] = ['label' => 'Hari', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hari-view">
    <div class="d-flex justify-content-between mt-4 mb-2">
<<<<<<< HEAD
        <h2><?= 'Hari:'  . Html::encode($this->title) ?></h2>
=======
        <h2><?= 'Hari'  . Html::encode($this->title) ?></h2>
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da

        <div>
                                    
            <?= GhostHtml::a('Baru', ['/hari/create'], ['class' => 'btn btn-success']) ?>
            <?= GhostHtml::a('List', ['/hari/index'], ['class' => 'btn btn-info']) ?>
            <?= GhostHtml::a('Update', ['/hari/update', 'id' => $model->hari_id], ['class' => 'btn btn-primary']) ?>
            <?= GhostHtml::a('Delete', ['/hari/delete', 'id' => $model->hari_id], [
                'class' => 'btn btn-danger',
                'data' => [
<<<<<<< HEAD
                    'confirm' => 'Apakah anda ingin menghapus data ini?',
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
            'hari_id',
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
                'attribute' => 'guru.guru_id',
                'label' => 'Guru'
            ],
            [
                'attribute' => 'kodeta0.kodeta',
                'label' => 'Kodeta'
            ],
                        'jam_ke',
            'materi:ntext',
            [
                'attribute' => 'kodeKelas.kode_kelas',
                'label' => 'Kode Kelas'
            ],
            [
                'attribute' => 'kodeMapel.kode_mapel',
                'label' => 'Kode Mapel'
            ],
            'jam_mulai',
            'jam_selesai',
            'status',
            'waktupresensi',
            'file_siswa',
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