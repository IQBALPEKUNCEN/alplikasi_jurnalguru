<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\HistorykelasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-historykelas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'history_id')->textInput(['placeholder' => 'History']) ?>

    <?= $form->field($model, 'nis')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\base\Siswa::find()->orderBy('nis')->asArray()->all(), 'nis', 'nis'),
        'options' => ['placeholder' => 'Choose Siswa'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'kodeta')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\base\Tahunajaran::find()->orderBy('kodeta')->asArray()->all(), 'kodeta', 'kodeta'),
        'options' => ['placeholder' => 'Choose Tahunajaran'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'kode_kelas')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\base\Kelas::find()->orderBy('kode_kelas')->asArray()->all(), 'kode_kelas', 'kode_kelas'),
        'options' => ['placeholder' => 'Choose Kelas'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
