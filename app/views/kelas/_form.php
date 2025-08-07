<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;

\mootensai\components\JsBlock::widget([
    'viewFile' => '_script',
    'pos' => \yii\web\View::POS_END,
    'viewParams' => [
        'class' => 'Historykelas',
        'relID' => 'historykelas',
        'value' => \yii\helpers\Json::encode($model->historykelas),
        'isNewRecord' => $model->isNewRecord ? 1 : 0
    ]
]);

\mootensai\components\JsBlock::widget([
    'viewFile' => '_script',
    'pos' => \yii\web\View::POS_END,
    'viewParams' => [
        'class' => 'Jurnal',
        'relID' => 'jurnal',
        'value' => \yii\helpers\Json::encode($model->jurnals),
        'isNewRecord' => $model->isNewRecord ? 1 : 0
    ]
]);

// CSS Kustom
$this->registerCss("
    .kelas-form .card {
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        border: none;
        border-radius: 12px;
        margin-top: 30px;
    }

    .kelas-form .card-header {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
        font-size: 22px;
        padding: 20px;
        border-radius: 12px 12px 0 0;
        font-weight: 700;
        text-align: center;
    }

    .kelas-form .card-body {
        padding: 30px;
    }

    .kelas-form .form-group .btn-success {
        background: linear-gradient(135deg, #56ccf2 0%, #2f80ed 100%);
        border: none;
        font-weight: 600;
        padding: 10px 30px;
        font-size: 16px;
    }

    .kelas-form .form-group .btn-primary {
        background: linear-gradient(135deg, #8e44ad 0%, #5e60ce 100%);
        border: none;
        font-weight: 600;
        padding: 10px 30px;
        font-size: 16px;
    }

    .kelas-form .form-group .btn-danger {
        background: linear-gradient(135deg, #fd79a8 0%, #e84393 100%);
        border: none;
        font-weight: 600;
        padding: 10px 30px;
        font-size: 16px;
    }

    .kelas-form .form-group .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0,0,0,0.2);
        transition: all 0.3s ease;
    }

    .select2-container--krajee .select2-selection {
        border-radius: 6px;
        padding: 6px;
        min-height: 40px;
        transition: all 0.3s ease;
    }

    .select2-container--krajee .select2-selection__rendered {
        font-weight: 500;
    }

    .form-control {
        border-radius: 6px;
        transition: all 0.3s ease;
    }
");

?>

<div class="container mt-4 mb-4">
    <div class="kelas-form card">
        <div class="card-header">
            <?= $model->isNewRecord ? '➕ Tambah Kelas Baru' : '✏️ Ubah Data Kelas' ?>
        </div>

        <div class="card-body">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->errorSummary($model); ?>

            <?= $form->field($model, 'kode_kelas')->textInput([
                'maxlength' => true,
                'placeholder' => 'Kode Kelas'
            ]) ?>

            <?= $form->field($model, 'kode_jenjang')->widget(\kartik\widgets\Select2::classname(), [
                'data' => \yii\helpers\ArrayHelper::map(
                    \app\models\base\Jenjang::find()->orderBy('kode_jenjang')->asArray()->all(),
                    'kode_jenjang',
                    'kode_jenjang'
                ),
                'options' => ['placeholder' => 'Pilih Jenjang'],
                'pluginOptions' => ['allowClear' => true],
            ]); ?>

            <?= $form->field($model, 'kode_jurusan')->widget(\kartik\widgets\Select2::classname(), [
                'data' => \yii\helpers\ArrayHelper::map(
                    \app\models\base\Jurusan::find()->orderBy('kode_jurusan')->asArray()->all(),
                    'kode_jurusan',
                    'kode_jurusan'
                ),
                'options' => ['placeholder' => 'Pilih Jurusan'],
                'pluginOptions' => ['allowClear' => true],
            ]); ?>

            <?= $form->field($model, 'nama')->textInput([
                'maxlength' => true,
                'placeholder' => 'Nama Kelas'
            ]) ?>

            <div class="form-group text-center mt-4">
                <?= Html::submitButton(
                    $model->isNewRecord ? '💾 Simpan Data' : '✅ Update Data',
                    ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
                ) ?>
                <?= Html::a('❌ Batal', Yii::$app->request->referrer, ['class' => 'btn btn-danger']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>