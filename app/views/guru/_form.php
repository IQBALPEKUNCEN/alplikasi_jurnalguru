<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\base\Guru */
/* @var $form kartik\form\ActiveForm */

\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'Jurnal', 
        'relID' => 'jurnal', 
        'value' => \yii\helpers\Json::encode($model->jurnals),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
?>

<div class="guru-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

<<<<<<< HEAD
    <?= $form->field($model, 'guru_id')->textInput(['maxlength' => true, 'placeholder' => 'Guru']) ?> 
=======
    <?= $form->field($model, 'guru_id')->textInput(['maxlength' => true, 'placeholder' => 'Guru']) ?>
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true, 'placeholder' => 'Nama']) ?>

    <?= $form->field($model, 'kode_jk')->widget(\kartik\widgets\Select2::classname(), [
<<<<<<< HEAD
        'data' => \yii\helpers\ArrayHelper::map(\app\models\base\Jeniskelamin::find()->orderBy('nama')->asArray()->all(), 'kode_jk', 'nama'),
        'options' => ['placeholder' => 'pilih  Jenis kelamin'],
=======
        'data' => \yii\helpers\ArrayHelper::map(\app\models\base\Jeniskelamin::find()->orderBy('kode_jk')->asArray()->all(), 'kode_jk', 'kode_jk'),
        'options' => ['placeholder' => 'Choose Jeniskelamin'],
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'nip')->textInput(['maxlength' => true, 'placeholder' => 'Nip']) ?>

    <?= $form->field($model, 'nik')->textInput(['maxlength' => true, 'placeholder' => 'Nik']) ?>

    <?= $form->field($model, 'tempat_lahir')->textInput(['maxlength' => true, 'placeholder' => 'Tempat Lahir']) ?>

    <?= $form->field($model, 'tanggal_lahir')->widget(\kartik\datecontrol\DateControl::classname(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
        'saveFormat' => 'php:Y-m-d',
        'ajaxConversion' => true,
        'options' => [
            'pluginOptions' => [
                'placeholder' => 'Choose Tanggal Lahir',
                'autoclose' => true
            ]
        ],
    ]); ?>

    <?= $form->field($model, 'alamat')->textInput(['maxlength' => true, 'placeholder' => 'Alamat']) ?>
<<<<<<< HEAD
 <!-- menghapus filter jurnal pada form guru  -->
    <!-- <?php
=======

    <?php
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
    $forms = [
        [
            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Html::encode('Jurnal'),
            'content' => $this->render('_formJurnal', [
                'row' => \yii\helpers\ArrayHelper::toArray($model->jurnals),
            ]),
        ],
    ];
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
<<<<<<< HEAD
    ?> -->

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Tambah' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Batal'), Yii::$app->request->referrer , ['class'=> 'btn btn-danger']) ?>
=======
    ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Cancel'), Yii::$app->request->referrer , ['class'=> 'btn btn-danger']) ?>
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
    </div>

    <?php ActiveForm::end(); ?>

</div>
