<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use app\modules\UserManagement\components\GhostHtml;

/* @var $this yii\web\View */
/* @var $model app\models\base\Guru */

<<<<<<< HEAD
$this->title = $model->nama;
=======
$this->title = $model->guru_id;
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
$this->params['breadcrumbs'][] = ['label' => 'Guru', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="guru-view">
    <div class="d-flex justify-content-between mt-4 mb-2">
<<<<<<< HEAD
        <h2><?= 'Guru:'  . Html::encode($this->title) ?></h2>
=======
        <h2><?= 'Guru'  . Html::encode($this->title) ?></h2>
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da

        <div>
                                    
            <?= GhostHtml::a('Baru', ['/guru/create'], ['class' => 'btn btn-success']) ?>
            <?= GhostHtml::a('List', ['/guru/index'], ['class' => 'btn btn-info']) ?>
            <?= GhostHtml::a('Update', ['/guru/update', 'id' => $model->guru_id], ['class' => 'btn btn-primary']) ?>
            <?= GhostHtml::a('Delete', ['/guru/delete', 'id' => $model->guru_id], [
                'class' => 'btn btn-danger',
                'data' => [
<<<<<<< HEAD
                    'confirm' => 'apakah anda ingin menghapus ini?',
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
            'guru_id',
        'nama',
        [
<<<<<<< HEAD
            'attribute' => 'kode_jk',
            'label' => 'Kode Jk',
            'value' => function($model){
                if ($model->kodeJk)
                {return $model->kodeJk->nama;}
                else
                {return NULL;}
            },
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => \yii\helpers\ArrayHelper::map(\app\models\base\Jeniskelamin::find()->asArray()->all(), 'kode_jk', 'kode_jk'),
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions' => ['placeholder' => 'Jeniskelamin', 'id' => 'grid-guru-search-kode_jk']
=======
            'attribute' => 'kodeJk.kode_jk',
            'label' => 'Kode Jk',
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
        ],
        'nip',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
    ];
    echo DetailView::widget([
    'model' => $model,
    'attributes' => $gridColumn
    ]);
    ?>
    <br>
                        <br>
            <h4>Jeniskelamin<?= ' '. Html::encode($this->title) ?></h4>
            <?php 
            $gridColumnJeniskelamin = [
                    'nama',
            ];
            echo DetailView::widget([
<<<<<<< HEAD
            'model' => $model->nama,
=======
            'model' => $model->kodeJk,
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
            'attributes' => $gridColumnJeniskelamin            ]);
            ?>
                                    <?php
                if($providerJurnal->totalCount){
                $gridColumnJurnal = [
                ['class' => 'yii\grid\SerialColumn'],
                            'jurnal_id',
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
            [
                'attribute' => 'kodeMapel.kode_mapel',
                'label' => 'Kode Mapel'
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