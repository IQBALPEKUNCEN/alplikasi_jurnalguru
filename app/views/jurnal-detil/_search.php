<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\JurnalDetilSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-jurnal-detil-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'detil_id')->textInput(['placeholder' => 'Detil']) ?>

    <?= $form->field($model, 'jurnal_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\base\Jurnal::find()->orderBy('jurnal_id')->asArray()->all(), 'jurnal_id', 'jurnal_id'),
        'options' => ['placeholder' => 'Choose Jurnal'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'nis')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\base\Siswa::find()->orderBy('nis')->asArray()->all(), 'nis', 'nis'),
        'options' => ['placeholder' => 'Choose Siswa'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

<?= $form->field($model, 'nama')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\base\Siswa::find()->orderBy('nama')->asArray()->all(), 'nama', 'nama'),
        'options' => ['placeholder' => 'Choose Siswa'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'status')->dropDownList([ 'SAKIT' => 'SAKIT', 'IZIN' => 'IZIN', 'HADIR' => 'HADIR', 'ALPA' => 'ALPA', '-' => '-', '' => '', ], ['prompt' => '']) ?>

    <?php /* echo $form->field($model, 'waktu_presensi')->widget(\kartik\datecontrol\DateControl::classname(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATETIME,
        'saveFormat' => 'php:Y-m-d H:i:s',
        'ajaxConversion' => true,
        'options' => [
            'pluginOptions' => [
                'placeholder' => 'Choose Waktu Presensi',
                'autoclose' => true,
            ]
        ],
    ]); */ ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
