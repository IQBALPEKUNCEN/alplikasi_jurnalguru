<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\base\Jurusan */
/* @var $form kartik\form\ActiveForm */

\mootensai\components\JsBlock::widget([
    'viewFile' => '_script',
    'pos' => \yii\web\View::POS_END,
    'viewParams' => [
        'class' => 'Kelas',
        'relID' => 'kelas',
        'value' => \yii\helpers\Json::encode($model->kelas),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);

// Background halaman
$this->registerCss("
    body {
        background: linear-gradient(to bottom right, #a0d8f1, #e8faff);
        font-family: 'Segoe UI', sans-serif;
    }

    .jurusan-form {
        background-color: #ffffff;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        max-width: 600px;
        margin: 40px auto;
    }

    .jurusan-form label {
        font-weight: 600;
        color: #34495e;
    }

    .jurusan-form .form-control {
        border-radius: 10px;
        padding: 12px;
        font-size: 14px;
        border: 1px solid #ccc;
        transition: border-color 0.3s ease;
    }

    .jurusan-form .form-control:focus {
        border-color: #1e88e5;
        box-shadow: 0 0 5px rgba(30,136,229,0.5);
    }

    .jurusan-form .btn-success {
        background: linear-gradient(to right, #00c853, #43a047);
        color: #fff;
        border: none;
        padding: 12px 28px;
        border-radius: 30px;
        font-weight: bold;
        font-size: 15px;
    }

    .jurusan-form .btn-primary {
        background: linear-gradient(to right, #2196f3, #1565c0);
        color: #fff;
        border: none;
        padding: 12px 28px;
        border-radius: 30px;
        font-weight: bold;
        font-size: 15px;
    }

    .jurusan-form .btn-danger {
        background: linear-gradient(to right, #e53935, #b71c1c);
        color: #fff;
        border: none;
        padding: 12px 28px;
        border-radius: 30px;
        font-weight: bold;
        font-size: 15px;
    }

    .form-group.mt-3 {
        text-align: center;
        margin-top: 30px;
    }
");
?>

<div class="jurusan-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'kode_jurusan')->textInput([
        'maxlength' => true,
        'placeholder' => 'Masukkan Kode Jurusan',
        'autofocus' => true
    ]) ?>

    <?= $form->field($model, 'nama')->textInput([
        'maxlength' => true,
        'placeholder' => 'Masukkan Nama Jurusan'
    ]) ?>

    <div class="form-group mt-3">
        <?= Html::submitButton(
            $model->isNewRecord
                ? '<i class="fa fa-plus-circle"></i> Tambah Jurusan'
                : '<i class="fa fa-save"></i> Simpan',
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
        ) ?>
        <?= Html::a('<i class="fa fa-times"></i> Batal', Yii::$app->request->referrer ?: ['index'], ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>