<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use app\modules\UserManagement\components\GhostHtml;

/* @var $this yii\web\View */
/* @var $model app\models\base\Guru */

$this->title = $model->guru_id;
$this->params['breadcrumbs'][] = ['label' => 'Guru', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="guru-view">
    <div class="d-flex justify-content-between mt-4 mb-2">
        <h2><?= 'Guru'  . Html::encode($this->title) ?></h2>

        <div>
                                    
            <?= GhostHtml::a('Baru', ['/guru/create'], ['class' => 'btn btn-success']) ?>
            <?= GhostHtml::a('List', ['/guru/index'], ['class' => 'btn btn-info']) ?>
            <?= GhostHtml::a('Update', ['/guru/update', 'id' => $model->guru_id], ['class' => 'btn btn-primary']) ?>
            <?= GhostHtml::a('Delete', ['/guru/delete', 'id' => $model->guru_id], [
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
            'guru_id',
        'nama',
        [
            'attribute' => 'kodeJk.kode_jk',
            'label' => 'Kode Jk',
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
            'model' => $model->kodeJk,
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