<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\DatePicker;
use yii\helpers\ArrayHelper;
use app\models\base\Guru;
use app\models\base\Tahunajaran;
use app\models\base\Hari;
use app\models\base\Kelas;

/* @var $this yii\web\View */
/* @var $model app\models\JurnalSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-jurnal-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'jurnal_id')->textInput(['placeholder' => 'ID Jurnal']) ?>

    <?= $form->field($model, 'nip')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Guru::find()->orderBy('nama')->all(), 'nip', 'nama'),
        'options' => ['placeholder' => 'Pilih Guru'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <?= $form->field($model, 'kodeta')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Tahunajaran::find()->orderBy('namata')->all(), 'kodeta', 'namata'),
        'options' => ['placeholder' => 'Pilih Tahun Ajaran'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <?= $form->field($model, 'hari_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Hari::find()->orderBy('nama')->all(), 'hari_id', 'nama'),
        'options' => ['placeholder' => 'Pilih Hari'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <?= $form->field($model, 'jam_ke')->textInput(['placeholder' => 'Jam ke']) ?>

    <?php /*
    <?= $form->field($model, 'tanggal')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => 'Pilih Tanggal'],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd',
            'todayHighlight' => true
        ]
    ]) ?>
    */ ?>

    <?php /*
    <?= $form->field($model, 'kode_kelas')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Kelas::find()->orderBy('nama')->all(), 'kode_kelas', 'nama'),
        'options' => ['placeholder' => 'Pilih Kelas'],
        'pluginOptions' => ['allowClear' => true],
    ]) ?>
    */ ?>

    <?php /*
    <?= $form->field($model, 'status')->dropDownList([
        'HADIR' => 'HADIR',
        'TIDAK HADIR' => 'TIDAK HADIR',
        'IZIN' => 'IZIN',
        'SAKIT' => 'SAKIT',
        'ALFA' => 'ALFA',
    ], ['prompt' => 'Pilih Status']) ?>
    */ ?>

    <div class="form-group">
        <?= Html::submitButton('Cari', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>