<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\base\Historykelas */
/* @var $form kartik\form\ActiveForm */

?>

<div class="historykelas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

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
