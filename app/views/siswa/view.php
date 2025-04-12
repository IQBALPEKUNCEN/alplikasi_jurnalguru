<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use app\modules\UserManagement\components\GhostHtml;

/* @var $this yii\web\View */
/* @var $model app\models\base\Siswa */

$this->title = $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Siswa', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="siswa-view">
    <div class="d-flex justify-content-between mt-4 mb-2">
        <h2><?= ''  . Html::encode($this->title) ?></h2>

        <div>
                                    
            <?= GhostHtml::a('Baru', ['/siswa/create'], ['class' => 'btn btn-success']) ?>
            <?= GhostHtml::a('List', ['/siswa/index'], ['class' => 'btn btn-info']) ?>
            <?= GhostHtml::a('Update', ['/siswa/update', 'id' => $model->nis], ['class' => 'btn btn-primary']) ?>
            <?= GhostHtml::a('Delete', ['/siswa/delete', 'id' => $model->nis], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Apakah anda ingin menghapus data ini?',
                    'method' => 'post',
                ],
            ])
            ?>
        </div>
    </div>

    <?php 
    $gridColumn = [
            'nis',
        'nama',
        'kode_kelas',
        [
            'attribute' => 'kode_jk',
            'label' => 'Jenis kelamin',
            'value' => function($model) {
                return $model->kode_jk == 'L' ? 'Laki-laki' : 'Perempuan';
            },
        ],
        'tempat_lahir',
        'tanggal_lahir',
        'no_hp',
        'alamat',
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
                'attribute' => 'kodeta0.kodeta',
                'label' => 'Kodeta'
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
                if($providerJurnalDetil->totalCount){
                $gridColumnJurnalDetil = [
                ['class' => 'yii\grid\SerialColumn'],
                            'detil_id',
            [
                'attribute' => 'jurnal.jurnal_id',
                'label' => 'Jurnal'
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