<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\GuruSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-guru-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'guru_id')->textInput(['maxlength' => true, 'placeholder' => 'Guru']) ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true, 'placeholder' => 'Nama']) ?>

    <?= $form->field($model, 'kode_jk')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\base\Jeniskelamin::find()->orderBy('kode_jk')->asArray()->all(), 'kode_jk', 'kode_jk'),
        'options' => ['placeholder' => 'Choose Jeniskelamin'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'nip')->textInput(['maxlength' => true, 'placeholder' => 'Nip']) ?>

    <?= $form->field($model, 'nik')->textInput(['maxlength' => true, 'placeholder' => 'Nik']) ?>

    <?php /* echo $form->field($model, 'tempat_lahir')->textInput(['maxlength' => true, 'placeholder' => 'Tempat Lahir']) */ ?>

    <?php /* echo $form->field($model, 'tanggal_lahir')->widget(\kartik\datecontrol\DateControl::classname(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
        'saveFormat' => 'php:Y-m-d',
        'ajaxConversion' => true,
        'options' => [
            'pluginOptions' => [
                'placeholder' => 'Choose Tanggal Lahir',
                'autoclose' => true
            ]
        ],
    ]); */ ?>

    <?php /* echo $form->field($model, 'alamat')->textInput(['maxlength' => true, 'placeholder' => 'Alamat']) */ ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
