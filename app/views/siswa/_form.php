<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\widgets\Select2;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $model app\models\base\Siswa */
/* @var $form kartik\form\ActiveForm */

$this->registerCss("
    .siswa-form-container {
        background: linear-gradient(145deg, #f4faff, #e9f1ff);
        border-radius: 16px;
        padding: 40px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        margin-top: 30px;
        margin-bottom: 30px;
    }

    .siswa-form h3 {
        color: #2f80ed;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .siswa-form .form-control {
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 15px;
    }

    .siswa-form .form-group {
        margin-bottom: 25px;
    }

    .siswa-form .btn {
        padding: 12px 28px;
        font-size: 16px;
        border-radius: 30px;
    }

    .siswa-form .btn-success {
        background: linear-gradient(120deg, #00c6ff, #0072ff);
        border: none;
        color: white;
    }

    .siswa-form .btn-primary {
        background: linear-gradient(120deg, #9b59b6, #8e44ad);
        border: none;
        color: white;
    }

    .siswa-form .btn-danger {
        background: linear-gradient(120deg, #ff6a6a, #ff4e50);
        border: none;
        color: white;
    }

    .row .col-md-6 {
        padding-right: 15px;
        padding-left: 15px;
    }
");

?>

<div class="siswa-form-container">
    <div class="siswa-form">

        <h3><i class="fas fa-user-graduate"></i> Formulir Data Siswa</h3>
        <p>Silakan lengkapi data siswa dengan benar dan lengkap.</p>

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->errorSummary($model); ?>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'nis')->textInput(['maxlength' => true, 'placeholder' => 'Nomor Induk Siswa']) ?>

                <?= $form->field($model, 'nama')->textInput(['maxlength' => true, 'placeholder' => 'Nama Lengkap']) ?>

                <?= $form->field($model, 'kode_kelas')->widget(Select2::classname(), [
                    'data' => \yii\helpers\ArrayHelper::map(\app\models\Kelas::find()->orderBy('nama')->all(), 'kode_kelas', 'nama'),
                    'options' => ['placeholder' => 'Pilih Kelas'],
                    'pluginOptions' => ['allowClear' => true],
                ]) ?>

                <?= $form->field($model, 'kode_jk')->widget(Select2::classname(), [
                    'data' => \yii\helpers\ArrayHelper::map(\app\models\base\Jeniskelamin::find()->all(), 'kode_jk', 'nama'),
                    'options' => ['placeholder' => 'Pilih Jenis Kelamin'],
                    'pluginOptions' => ['allowClear' => true],
                ]) ?>
            </div>

            <div class="col-md-6">
                <?= $form->field($model, 'tempat_lahir')->textInput(['maxlength' => true, 'placeholder' => 'Contoh: Jakarta']) ?>

                <?= $form->field($model, 'tanggal_lahir')->widget(DateControl::classname(), [
                    'type' => DateControl::FORMAT_DATE,
                    'saveFormat' => 'php:Y-m-d',
                    'ajaxConversion' => true,
                    'options' => [
                        'pluginOptions' => [
                            'placeholder' => 'Pilih Tanggal Lahir',
                            'autoclose' => true
                        ]
                    ]
                ]) ?>

                <?= $form->field($model, 'no_hp')->textInput(['maxlength' => true, 'placeholder' => '08xxxxxxxx']) ?>

                <?= $form->field($model, 'alamat')->textarea(['rows' => 3, 'placeholder' => 'Alamat lengkap siswa']) ?>
                <?= $form->field($model, 'telegram_id')->textInput([
                    'maxlength' => true,
                    'placeholder' => 'Masukkan Telegram ID siswa'
                ]) ?>

            </div>
        </div>

        <div class="form-group text-center mt-4">
            <?= Html::submitButton($model->isNewRecord ? 'Tambah Siswa' : 'Simpan Perubahan', [
                'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'
            ]) ?>
            <?= Html::a('Batal', Yii::$app->request->referrer, ['class' => 'btn btn-danger']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>