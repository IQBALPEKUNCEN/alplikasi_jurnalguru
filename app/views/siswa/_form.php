<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\base\Siswa */
/* @var $form kartik\form\ActiveForm */

\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'Historykelas', 
        'relID' => 'historykelas', 
        'value' => \yii\helpers\Json::encode($model->historykelas),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'JurnalDetil', 
        'relID' => 'jurnal-detil', 
        'value' => \yii\helpers\Json::encode($model->jurnalDetils),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
<<<<<<< HEAD
    
=======
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
]);
?>

<div class="siswa-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'nis')->textInput(['maxlength' => true, 'placeholder' => 'Nis']) ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true, 'placeholder' => 'Nama']) ?>

<<<<<<< HEAD
    <?= $form->field($model, 'kode_kelas')->widget(\kartik\widgets\Select2::classname(), [
    'data' => \yii\helpers\ArrayHelper::map(\app\models\Kelas::find()->orderBy('nama')->asArray()->all(), 'kode_kelas', 'nama'),
    'options' => ['placeholder' => 'Pilih Kode Kelas'],
    'pluginOptions' => [
        'allowClear' => true,
    ],
]); ?>


    <?= $form->field($model, 'kode_jk')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\base\Jeniskelamin::find()->orderBy('nama')->asArray()->all(), 'kode_jk', 'nama'),
        'options' => ['placeholder' => 'pilih  Jenis kelamin'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>
=======
    <?= $form->field($model, 'kode_kelas')->textInput(['maxlength' => true, 'placeholder' => 'Kode Kelas']) ?>

    <?= $form->field($model, 'kode_jk')->textInput(['maxlength' => true, 'placeholder' => 'Kode Jk']) ?>
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da

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

    <?= $form->field($model, 'no_hp')->textInput(['maxlength' => true, 'placeholder' => 'No Hp']) ?>

    <?= $form->field($model, 'alamat')->textInput(['maxlength' => true, 'placeholder' => 'Alamat']) ?>

<<<<<<< HEAD
    <!-- <?php
=======
    <?php
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
    $forms = [
        [
            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Html::encode('Historykelas'),
            'content' => $this->render('_formHistorykelas', [
                'row' => \yii\helpers\ArrayHelper::toArray($model->historykelas),
            ]),
        ],
        [
            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Html::encode('JurnalDetil'),
            'content' => $this->render('_formJurnalDetil', [
                'row' => \yii\helpers\ArrayHelper::toArray($model->jurnalDetils),
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
