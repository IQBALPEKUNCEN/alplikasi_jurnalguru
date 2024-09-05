<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TahunajaranSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-tahunajaran-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'kodeta')->textInput(['maxlength' => true, 'placeholder' => 'Kodeta']) ?>

    <?= $form->field($model, 'semester')->dropDownList([ 'GASAL' => 'GASAL', 'GENAP' => 'GENAP', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'namata')->textInput(['maxlength' => true, 'placeholder' => 'Namata']) ?>

    <?= $form->field($model, 'isaktif')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
