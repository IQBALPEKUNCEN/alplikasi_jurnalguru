<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use app\modules\UserManagement\components\GhostHtml;

/* @var $this yii\web\View */
/* @var $model app\models\base\Jurusan */

$this->title = $model->kode_jurusan;
$this->params['breadcrumbs'][] = ['label' => 'Jurusan', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jurusan-view">
    <div class="d-flex justify-content-between mt-4 mb-2">
        <h2><?= 'Jurusan'  . Html::encode($this->title) ?></h2>

        <div>
                                    
            <?= GhostHtml::a('Baru', ['/jurusan/create'], ['class' => 'btn btn-success']) ?>
            <?= GhostHtml::a('List', ['/jurusan/index'], ['class' => 'btn btn-info']) ?>
            <?= GhostHtml::a('Update', ['/jurusan/update', 'id' => $model->kode_jurusan], ['class' => 'btn btn-primary']) ?>
            <?= GhostHtml::a('Delete', ['/jurusan/delete', 'id' => $model->kode_jurusan], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Apakah anda ingin menghapus ini?',
                    'method' => 'post',
                ],
            ])
            ?>
        </div>
    </div>

    <?php 
    $gridColumn = [
            'kode_jurusan',
        'nama',
    ];
    echo DetailView::widget([
    'model' => $model,
    'attributes' => $gridColumn
    ]);
    ?>
    <br>
                            <?php
                if($providerKelas->totalCount){
                $gridColumnKelas = [
                ['class' => 'yii\grid\SerialColumn'],
                            'kode_kelas',
            [
                'attribute' => 'kodeJenjang.kode_jenjang',
                'label' => 'Kode Jenjang'
            ],
                        'nama',
                ];
                echo Gridview::widget([
                'dataProvider' => $providerKelas,
                'pjax' => true,
                'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-kelas']],
                'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode('Kelas'),
                ],
                                    'export' => false,
                                'columns' => $gridColumnKelas
                ]);
                }
                ?>
            </div>