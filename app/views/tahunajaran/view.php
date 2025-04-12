<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use app\modules\UserManagement\components\GhostHtml;

/* @var $this yii\web\View */
/* @var $model app\models\base\Tahunajaran */

$this->title = $model->kodeta;
<<<<<<< HEAD
$this->params['breadcrumbs'][] = ['label' => 'Tahun ajaran', 'url' => ['index']];
=======
$this->params['breadcrumbs'][] = ['label' => 'Tahunajaran', 'url' => ['index']];
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tahunajaran-view">
    <div class="d-flex justify-content-between mt-4 mb-2">
        <h2><?= 'Tahunajaran'  . Html::encode($this->title) ?></h2>

        <div>
                                    
            <?= GhostHtml::a('Baru', ['/tahunajaran/create'], ['class' => 'btn btn-success']) ?>
            <?= GhostHtml::a('List', ['/tahunajaran/index'], ['class' => 'btn btn-info']) ?>
            <?= GhostHtml::a('Update', ['/tahunajaran/update', 'id' => $model->kodeta], ['class' => 'btn btn-primary']) ?>
            <?= GhostHtml::a('Delete', ['/tahunajaran/delete', 'id' => $model->kodeta], [
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
            'kodeta',
        'semester',
        'namata',
        'isaktif',
    ];
    echo DetailView::widget([
    'model' => $model,
    'attributes' => $gridColumn
    ]);
    ?>
    <br>
                            <?php
                if($providerHistorykelas->totalCount){
                $gridColumnHistorykelas = [
                ['class' => 'yii\grid\SerialColumn'],
                            'history_id',
            [
                'attribute' => 'nis0.nis',
                'label' => 'Nis'
            ],
                        [
                'attribute' => 'kodeKelas.kode_kelas',
                'label' => 'Kode Kelas'
            ],
                ];
                echo Gridview::widget([
                'dataProvider' => $providerHistorykelas,
                'pjax' => true,
                'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-historykelas']],
                'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode('Historykelas'),
                ],
                                    'export' => false,
                                'columns' => $gridColumnHistorykelas
                ]);
                }
                ?>
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
                'attribute' => 'hari.hari_id',
                'label' => 'Hari'
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