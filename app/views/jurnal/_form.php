<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\base\Jurnal */
/* @var $form kartik\form\ActiveForm */

\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'JurnalDetil', 
        'relID' => 'jurnal-detil', 
        'value' => \yii\helpers\Json::encode($model->jurnalDetils),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
?>

<div class="jurnal-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'jurnal_id')->textInput(['placeholder' => 'Jurnal']) ?>

    <?= $form->field($model, 'guru_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\base\Guru::find()->orderBy('guru_id')->asArray()->all(), 'guru_id', 'guru_id'),
        'options' => ['placeholder' => 'Choose Guru'],
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

    <?= $form->field($model, 'hari_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\base\Hari::find()->orderBy('hari_id')->asArray()->all(), 'hari_id', 'hari_id'),
        'options' => ['placeholder' => 'Choose Hari'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'jam_ke')->textInput(['placeholder' => 'Jam Ke']) ?>

    <?= $form->field($model, 'materi')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'kode_kelas')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\base\Kelas::find()->orderBy('kode_kelas')->asArray()->all(), 'kode_kelas', 'kode_kelas'),
        'options' => ['placeholder' => 'Choose Kelas'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'kode_mapel')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\base\Mapel::find()->orderBy('kode_mapel')->asArray()->all(), 'kode_mapel', 'kode_mapel'),
        'options' => ['placeholder' => 'Choose Mapel'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'jam_mulai')->widget(\kartik\datecontrol\DateControl::className(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_TIME,
        'saveFormat' => 'php:H:i:s',
        'ajaxConversion' => true,
        'options' => [
            'pluginOptions' => [
                'placeholder' => 'Choose Jam Mulai',
                'autoclose' => true
            ]
        ]
    ]); ?>

    <?= $form->field($model, 'jam_selesai')->widget(\kartik\datecontrol\DateControl::className(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_TIME,
        'saveFormat' => 'php:H:i:s',
        'ajaxConversion' => true,
        'options' => [
            'pluginOptions' => [
                'placeholder' => 'Choose Jam Selesai',
                'autoclose' => true
            ]
        ]
    ]); ?>

    <?= $form->field($model, 'status')->dropDownList([ 'HADIR' => 'HADIR', '-' => '-', '' => '', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'waktupresensi')->widget(\kartik\datecontrol\DateControl::classname(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATETIME,
        'saveFormat' => 'php:Y-m-d H:i:s',
        'ajaxConversion' => true,
        'options' => [
            'pluginOptions' => [
                'placeholder' => 'Choose Waktupresensi',
                'autoclose' => true,
            ]
        ],
    ]); ?>

    <?= $form->field($model, 'file_siswa')->textInput(['maxlength' => true, 'placeholder' => 'File Siswa']) ?>

    <?php
    $forms = [
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
    ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Cancel'), Yii::$app->request->referrer , ['class'=> 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
