<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;

$this->registerCss("
    .jenjang-form {
        background: #ffffff;
        padding: 30px;
        border-radius: 20px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
        max-width: 600px;
        margin: 30px auto;
    }

    .jenjang-form h2 {
        text-align: center;
        color: #2c3e50;
        font-weight: 600;
        margin-bottom: 25px;
    }

    .form-control {
        border-radius: 10px;
    }

    .btn-primary {
        background: linear-gradient(to right, #56ccf2, #2f80ed);
        color: white;
        font-weight: bold;
        border: none;
        border-radius: 10px;
        padding: 10px 25px;
    }

    .btn-danger {
        background: linear-gradient(to right, #ef5350, #e53935);
        color: white;
        border: none;
        border-radius: 10px;
        padding: 10px 25px;
    }

    .btn:hover {
        opacity: 0.9;
        transform: translateY(-2px);
        transition: all 0.3s ease;
    }
");
?>

<div class="jenjang-form">

    <h2><?= $model->isNewRecord ? 'Tambah Jenjang Baru' : 'Ubah Data Jenjang' ?></h2>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'kode_jenjang')->textInput(['maxlength' => true, 'placeholder' => 'Kode Jenjang']) ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true, 'placeholder' => 'Nama Jenjang']) ?>

    <div class="form-group text-center mt-4">
        <?= Html::submitButton($model->isNewRecord ? '➕ Simpan' : '💾 Update', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('❌ Batal', Yii::$app->request->referrer, ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>