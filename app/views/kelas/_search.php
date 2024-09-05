<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\KelasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-kelas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'kode_kelas')->textInput(['maxlength' => true, 'placeholder' => 'Kode Kelas']) ?>

    <?= $form->field($model, 'kode_jenjang')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\base\Jenjang::find()->orderBy('kode_jenjang')->asArray()->all(), 'kode_jenjang', 'kode_jenjang'),
        'options' => ['placeholder' => 'Choose Jenjang'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'kode_jurusan')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\base\Jurusan::find()->orderBy('kode_jurusan')->asArray()->all(), 'kode_jurusan', 'kode_jurusan'),
        'options' => ['placeholder' => 'Choose Jurusan'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true, 'placeholder' => 'Nama']) ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
