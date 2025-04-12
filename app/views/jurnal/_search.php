<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\JurnalSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-jurnal-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'jurnal_id')->textInput(['placeholder' => 'Jurnal']) ?>

    <?= $form->field($model, 'guru_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\base\Guru::find()->orderBy('guru_id')->asArray()->all(), 'guru_id', 'guru_id'),
<<<<<<< HEAD
        'options' => ['placeholder' => 'Pilih Guru'],
=======
        'options' => ['placeholder' => 'Choose Guru'],
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
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

<<<<<<< HEAD
    <!-- <?php $form->field($model, 'tanggal')->widget(\kartik\widgets\DatePicker::classname(), [
    'options' => ['placeholder' => 'Pilih Tanggal'],
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'yyyy-mm-dd', // Format tanggal
        'todayHighlight' => true
    ]
]); ?> -->

=======
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
    <?= $form->field($model, 'jam_ke')->textInput(['placeholder' => 'Jam Ke']) ?>

    <?php /* echo $form->field($model, 'materi')->textarea(['rows' => 6]) */ ?>

    <?php /* echo $form->field($model, 'kode_kelas')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\base\Kelas::find()->orderBy('kode_kelas')->asArray()->all(), 'kode_kelas', 'kode_kelas'),
        'options' => ['placeholder' => 'Choose Kelas'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); */ ?>

    <?php /* echo $form->field($model, 'kode_mapel')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\base\Mapel::find()->orderBy('kode_mapel')->asArray()->all(), 'kode_mapel', 'kode_mapel'),
        'options' => ['placeholder' => 'Choose Mapel'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); */ ?>

    <?php /* echo $form->field($model, 'jam_mulai')->widget(\kartik\datecontrol\DateControl::className(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_TIME,
        'saveFormat' => 'php:H:i:s',
        'ajaxConversion' => true,
        'options' => [
            'pluginOptions' => [
                'placeholder' => 'Choose Jam Mulai',
                'autoclose' => true
            ]
        ]
    ]); */ ?>

    <?php /* echo $form->field($model, 'jam_selesai')->widget(\kartik\datecontrol\DateControl::className(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_TIME,
        'saveFormat' => 'php:H:i:s',
        'ajaxConversion' => true,
        'options' => [
            'pluginOptions' => [
                'placeholder' => 'Choose Jam Selesai',
                'autoclose' => true
            ]
        ]
    ]); */ ?>

    <?php /* echo $form->field($model, 'status')->dropDownList([ 'HADIR' => 'HADIR', '-' => '-', '' => '', ], ['prompt' => '']) */ ?>

    <?php /* echo $form->field($model, 'waktupresensi')->widget(\kartik\datecontrol\DateControl::classname(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATETIME,
        'saveFormat' => 'php:Y-m-d H:i:s',
        'ajaxConversion' => true,
        'options' => [
            'pluginOptions' => [
                'placeholder' => 'Choose Waktupresensi',
                'autoclose' => true,
            ]
        ],
    ]); */ ?>

    <?php /* echo $form->field($model, 'file_siswa')->textInput(['maxlength' => true, 'placeholder' => 'File Siswa']) */ ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
