<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\base\JurnalDetil */
/* @var $form kartik\form\ActiveForm */

?>

<div class="jurnal-detil-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

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

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true, 'placeholder' => 'Nama']) ?>

    <?= $form->field($model, 'status')->dropDownList([ 'SAKIT' => 'SAKIT', 'IZIN' => 'IZIN', 'HADIR' => 'HADIR', 'ALPA' => 'ALPA', '-' => '-', '' => '', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'waktu_presensi')->widget(\kartik\datecontrol\DateControl::classname(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATETIME,
        'saveFormat' => 'php:Y-m-d H:i:s',
        'ajaxConversion' => true,
        'options' => [
            'pluginOptions' => [
                'placeholder' => 'Choose Waktu Presensi',
                'autoclose' => true,
            ]
        ],
    ]); ?>

    <div class="form-group">
<<<<<<< HEAD
        <?= Html::submitButton($model->isNewRecord ? 'Tambah' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Batal'), Yii::$app->request->referrer , ['class'=> 'btn btn-danger']) ?>
=======
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Cancel'), Yii::$app->request->referrer , ['class'=> 'btn btn-danger']) ?>
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
    </div>

    <?php ActiveForm::end(); ?>

</div>
