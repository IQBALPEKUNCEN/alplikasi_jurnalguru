<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use app\modules\UserManagement\components\GhostHtml;

/* @var $this yii\web\View */
/* @var $model app\models\base\Jenjang */

$this->title = $model->kode_jenjang;
$this->params['breadcrumbs'][] = ['label' => 'Jenjang', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jenjang-view">
    <div class="d-flex justify-content-between mt-4 mb-2">
        <h2><?= 'Jenjang'  . Html::encode($this->title) ?></h2>

        <div>
                                    
            <?= GhostHtml::a('Baru', ['/jenjang/create'], ['class' => 'btn btn-success']) ?>
            <?= GhostHtml::a('List', ['/jenjang/index'], ['class' => 'btn btn-info']) ?>
            <?= GhostHtml::a('Update', ['/jenjang/update', ], ['class' => 'btn btn-primary']) ?>
            <?= GhostHtml::a('Delete', ['/jenjang/delete', ], [
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
            'kode_jenjang',
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
                'attribute' => 'kodeJurusan.kode_jurusan',
                'label' => 'Kode Jurusan'
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