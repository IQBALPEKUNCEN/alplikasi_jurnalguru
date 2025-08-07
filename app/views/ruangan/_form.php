<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Ruangan $model */
/** @var yii\widgets\ActiveForm $form */

$this->registerCss(<<<CSS
.ruangan-form {
    background: #ffffff;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    max-width: 600px;
    margin: auto;
    animation: fadeIn 0.5s ease-in-out;
}

.ruangan-form label {
    font-weight: 600;
    color: #2c3e50;
}

.ruangan-form .form-control {
    border-radius: 8px;
    padding: 10px;
    font-size: 16px;
}

.ruangan-form .btn-success {
    background: linear-gradient(45deg, #28a745, #218838);
    border: none;
    padding: 10px 25px;
    border-radius: 8px;
    font-weight: bold;
    color: #fff;
    transition: all 0.3s ease;
}

.ruangan-form .btn-success:hover {
    background: linear-gradient(45deg, #218838, #28a745);
    transform: scale(1.05);
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(40px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
CSS);
?>

<div class="ruangan-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nama')->textInput([
        'maxlength' => true,
        'placeholder' => 'Masukkan nama ruangan'
    ]) ?>

    <?php /* Jika ingin diaktifkan nanti:
    <?= $form->field($model, 'keterangan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kapasitas')->textInput(['type' => 'number']) ?>
    */ ?>

    <div class="form-group text-center mt-3">
        <?= Html::submitButton('💾 Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>