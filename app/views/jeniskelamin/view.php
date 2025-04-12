<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use app\modules\UserManagement\components\GhostHtml;

/* @var $this yii\web\View */
/* @var $model app\models\base\Jeniskelamin */

$this->title = $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Jenis kelamin', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jeniskelamin-view">
    <div class="d-flex justify-content-between mt-4 mb-2">
        <h2><?= 'Jeniskelamin'  . Html::encode($this->title) ?></h2>

        <div>
                                    
            <?= GhostHtml::a('Baru', ['/jeniskelamin/create'], ['class' => 'btn btn-success']) ?>
            <?= GhostHtml::a('List', ['/jeniskelamin/index'], ['class' => 'btn btn-info']) ?>
            <?= GhostHtml::a('Update', ['/jeniskelamin/update', 'id' => $model->nama], ['class' => 'btn btn-primary']) ?>
            <?= GhostHtml::a('Delete', ['/jeniskelamin/delete', 'id' => $model->nama], [
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
            'kode_jk',
        'nama',
    ];
    echo DetailView::widget([
    'model' => $model,
    'attributes' => $gridColumn
    ]);
    ?>
    <br>
                            <?php
                if($providerGuru->totalCount){
                $gridColumnGuru = [
                ['class' => 'yii\grid\SerialColumn'],
                            'guru_id',
            'nama',
                        'nip',
            'nik',
            'tempat_lahir',
            'tanggal_lahir',
            'alamat',
                ];
                echo Gridview::widget([
                'dataProvider' => $providerGuru,
                'pjax' => true,
                'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-guru']],
                'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode('Guru'),
                ],
                                    'export' => false,
                                'columns' => $gridColumnGuru
                ]);
                }
                ?>
            </div>