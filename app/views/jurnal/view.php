<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use app\modules\UserManagement\components\GhostHtml;

/* @var $this yii\web\View */
/* @var $model app\models\base\Jurnal */

$this->title = $model->jurnal_id;
$this->params['breadcrumbs'][] = ['label' => 'Jurnal', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jurnal-view">
    <div class="d-flex justify-content-between mt-4 mb-2">
        <h2><?= 'Jurnal'  . Html::encode($this->title) ?></h2>

        <div>
                                    
            <?= GhostHtml::a('Baru', ['/jurnal/create'], ['class' => 'btn btn-success']) ?>
            <?= GhostHtml::a('List', ['/jurnal/index'], ['class' => 'btn btn-info']) ?>
            <?= GhostHtml::a('Update', ['/jurnal/update', 'id' => $model->jurnal_id], ['class' => 'btn btn-primary']) ?>
            <?= GhostHtml::a('Delete', ['/jurnal/delete', 'id' => $model->jurnal_id], [
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
            'jurnal_id',
        [
            'attribute' => 'guru.guru_id',
            'label' => 'Guru',
        ],
        [
            'attribute' => 'kodeta0.kodeta',
            'label' => 'Kodeta',
        ],
        [
            'attribute' => 'hari.hari_id',
            'label' => 'Hari',
        ],
        'jam_ke',
        'materi:ntext',
        [
            'attribute' => 'kodeKelas.kode_kelas',
            'label' => 'Kode Kelas',
        ],
        [
            'attribute' => 'kodeMapel.kode_mapel',
            'label' => 'Kode Mapel',
        ],
        'jam_mulai',
        'jam_selesai',
        'status',
        'waktupresensi',
        'file_siswa',
    ];
    echo DetailView::widget([
    'model' => $model,
    'attributes' => $gridColumn
    ]);
    ?>
    <br>
                        <br>
            <h4>Guru<?= ' '. Html::encode($this->title) ?></h4>
            <?php 
            $gridColumnGuru = [
                    'nama',
        'kode_jk',
        'nip',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
            ];
            echo DetailView::widget([
            'model' => $model->guru,
            'attributes' => $gridColumnGuru            ]);
            ?>
                                <br>
            <h4>Hari<?= ' '. Html::encode($this->title) ?></h4>
            <?php 
            $gridColumnHari = [
                    'nama',
            ];
            echo DetailView::widget([
            'model' => $model->hari,
            'attributes' => $gridColumnHari            ]);
            ?>
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
            <h4>Mapel<?= ' '. Html::encode($this->title) ?></h4>
            <?php 
            $gridColumnMapel = [
                    'nama',
            ];
            echo DetailView::widget([
            'model' => $model->kodeMapel,
            'attributes' => $gridColumnMapel            ]);
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
                                    <?php
                if($providerJurnalDetil->totalCount){
                $gridColumnJurnalDetil = [
                ['class' => 'yii\grid\SerialColumn'],
                            'detil_id',
                        [
                'attribute' => 'nis0.nis',
                'label' => 'Nis'
            ],
            'nama',
            'status',
            'waktu_presensi',
                ];
                echo Gridview::widget([
                'dataProvider' => $providerJurnalDetil,
                'pjax' => true,
                'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-jurnal-detil']],
                'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode('Jurnal Detil'),
                ],
                                    'export' => false,
                                'columns' => $gridColumnJurnalDetil
                ]);
                }
                ?>
            </div>