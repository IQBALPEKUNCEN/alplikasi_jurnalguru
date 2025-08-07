<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\base\Guru */
/* @var $form kartik\form\ActiveForm */

\mootensai\components\JsBlock::widget([
    'viewFile' => '_script',
    'pos' => \yii\web\View::POS_END,
    'viewParams' => [
        'class' => 'Jurnal',
        'relID' => 'jurnal',
        'value' => \yii\helpers\Json::encode($model->jurnals),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);

$this->registerCss("
    .guru-form {
        background: #ffffff;
        border-radius: 16px;
        padding: 40px 30px;
        box-shadow: 0 12px 25px rgba(0,0,0,0.08);
        max-width: 800px;
        margin: 30px auto;
        font-family: 'Segoe UI', sans-serif;
    }

    .guru-form h2 {
        text-align: center;
        margin-bottom: 25px;
        font-weight: bold;
        color: #1e40af;
    }

    .guru-form .form-group {
        margin-bottom: 20px;
    }

    .guru-form label {
        font-weight: 600;
        color: #374151;
    }

    .guru-form .form-control {
        border-radius: 10px;
        padding: 10px 12px;
        font-size: 14px;
        background-color: #f9fafb;
    }

    .guru-form .select2-selection {
        border-radius: 10px !important;
        padding: 6px;
    }

    .guru-form .btn {
        border-radius: 30px;
        padding: 10px 25px;
        font-weight: 600;
        font-size: 14px;
        margin-right: 10px;
    }

    .guru-form .btn-success {
        background: linear-gradient(135deg, #00c853, #2e7d32);
        color: #fff;
        border: none;
    }

    .guru-form .btn-primary {
        background: linear-gradient(135deg, #1e88e5, #1565c0);
        color: #fff;
        border: none;
    }

    .guru-form .btn-danger {
        background: linear-gradient(135deg, #e53935, #b71c1c);
        color: #fff;
        border: none;
    }
");
?>

<div class="guru-form">

    <h2><?= $model->isNewRecord ? 'Tambah Data Guru' : 'Perbarui Data Guru' ?></h2>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'guru_id')->textInput(['maxlength' => true, 'placeholder' => 'ID Guru']) ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true, 'placeholder' => 'Nama Lengkap']) ?>

    <?= $form->field($model, 'kode_jk')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(
            \app\models\base\Jeniskelamin::find()->orderBy('nama')->asArray()->all(),
            'kode_jk',
            'nama'
        ),
        'options' => ['placeholder' => 'Pilih Jenis Kelamin'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'nip')->textInput(['maxlength' => true, 'placeholder' => 'NIP']) ?>

    <?= $form->field($model, 'nik')->textInput(['maxlength' => true, 'placeholder' => 'NIK']) ?>

    <?= $form->field($model, 'tempat_lahir')->textInput(['maxlength' => true, 'placeholder' => 'Tempat Lahir']) ?>

    <?= $form->field($model, 'tanggal_lahir')->widget(\kartik\datecontrol\DateControl::classname(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
        'saveFormat' => 'php:Y-m-d',
        'ajaxConversion' => true,
        'options' => [
            'pluginOptions' => [
                'placeholder' => 'Pilih Tanggal Lahir',
                'autoclose' => true
            ]
        ],
    ]); ?>

    <?= $form->field($model, 'alamat')->textInput(['maxlength' => true, 'placeholder' => 'Alamat Lengkap']) ?>

    <?= $form->field($model, 'jabatan')->textInput(['maxlength' => true, 'placeholder' => 'Jabatan Guru']) ?>


    <!-- Tabs Jurnal (jika diaktifkan) -->
    <?php
    $forms = [];
    echo kartik\tabs\TabsX::widget([
        'items' => $forms,
        'position' => kartik\tabs\TabsX::POS_ABOVE,
        'encodeLabels' => false,
        'pluginOptions' => [
            'bordered' => true,
            'sideways' => true,
            'enableCache' => false,
        ],
    ]);
    ?>

    <div class="form-group text-center mt-4">
        <?= Html::submitButton(
            $model->isNewRecord
                ? '<i class="fa fa-plus-circle"></i> Tambah'
                : '<i class="fa fa-save"></i> Simpan',
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
        ) ?>
        <?= Html::a('<i class="fa fa-times"></i> Batal', Yii::$app->request->referrer, ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>