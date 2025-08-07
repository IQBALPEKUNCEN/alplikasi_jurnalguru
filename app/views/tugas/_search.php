<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TugasSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tugas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'judul_tugas') ?>

    <?= $form->field($model, 'deskripsi') ?>

    <?= $form->field($model, 'tanggal_dibuat') ?>

    <?= $form->field($model, 'tanggal_selesai') ?>

    <?php // echo $form->field($model, 'kode_mapel') ?>

    <?php // echo $form->field($model, 'kode_kelas') ?>

    <?php // echo $form->field($model, 'guru_id') ?>

    <?php // echo $form->field($model, 'file_tugas') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
