<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use app\modules\UserManagement\components\GhostHtml;

/* @var $this yii\web\View */
/* @var $model app\models\base\Kelas */

$this->title = $model->kode_kelas;
$this->params['breadcrumbs'][] = ['label' => 'Kelas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kelas-view">
    <div class="d-flex justify-content-between mt-4 mb-2">
        <h2><?= 'Kelas'  . Html::encode($this->title) ?></h2>

        <div>
                                    
            <?= GhostHtml::a('Baru', ['/kelas/create'], ['class' => 'btn btn-success']) ?>
            <?= GhostHtml::a('List', ['/kelas/index'], ['class' => 'btn btn-info']) ?>
            <?= GhostHtml::a('Update', ['/kelas/update', 'id' => $model->kode_kelas], ['class' => 'btn btn-primary']) ?>
            <?= GhostHtml::a('Delete', ['/kelas/delete', 'id' => $model->kode_kelas], [
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
            'kode_kelas',
        [
            'attribute' => 'kodeJenjang.kode_jenjang',
            'label' => 'Kode Jenjang',
        ],
        [
            'attribute' => 'kodeJurusan.kode_jurusan',
            'label' => 'Kode Jurusan',
        ],
        'nama',
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
                'attribute' => 'kodeta0.kodeta',
                'label' => 'Kodeta'
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
                                <br>
            <h4>Jenjang<?= ' '. Html::encode($this->title) ?></h4>
            <?php 
            $gridColumnJenjang = [
                    'nama',
            ];
            echo DetailView::widget([
            'model' => $model->kodeJenjang,
            'attributes' => $gridColumnJenjang            ]);
            ?>
                                <br>
            <h4>Jurusan<?= ' '. Html::encode($this->title) ?></h4>
            <?php 
            $gridColumnJurusan = [
                    'nama',
            ];
            echo DetailView::widget([
            'model' => $model->kodeJurusan,
            'attributes' => $gridColumnJurusan            ]);
            ?>
            </div>