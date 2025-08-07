<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\base\Mapel */
/* @var $form kartik\form\ActiveForm */

$this->title = $model->isNewRecord ? 'Tambah Mapel' : 'Edit Mapel';
$this->params['breadcrumbs'][] = ['label' => '📘 Mata Pelajaran', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

// CSS modern ala UI component
$this->registerCss(<<<CSS
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');

body {
    font-family: 'Inter', sans-serif;
    background-color: #f8fafc;
    padding: 40px;
}

.mapel-form {
    background: #ffffff;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
    max-width: 600px;
    margin: auto;
}

.mapel-form h1 {
    font-size: 24px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 30px;
    text-align: center;
}

.mapel-form .form-group {
    margin-bottom: 20px;
}

.mapel-form input {
    border-radius: 8px !important;
    padding: 10px;
    border: 1px solid #cbd5e1;
}

.mapel-form .btn {
    font-weight: 600;
    border-radius: 8px;
    padding: 10px 20px;
    margin-right: 10px;
}

.mapel-form .btn-success {
    background-color: #10b981;
    color: white;
}

.mapel-form .btn-success:hover {
    background-color: #059669;
}

.mapel-form .btn-primary {
    background-color: #3b82f6;
    color: white;
}

.mapel-form .btn-primary:hover {
    background-color: #2563eb;
}

.mapel-form .btn-danger {
    background-color: #ef4444;
    color: white;
}

.mapel-form .btn-danger:hover {
    background-color: #dc2626;
}
CSS);
?>

<div class="mapel-form">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'kode_mapel')->textInput([
        'maxlength' => true,
        'placeholder' => 'Contoh: MTH101',
    ]) ?>

    <?= $form->field($model, 'nama')->textInput([
        'maxlength' => true,
        'placeholder' => 'Contoh: Matematika',
    ]) ?>

    <div class="form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? '💾 Simpan' : '✏️ Update', [
            'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'
        ]) ?>
        <?= Html::a('❌ Batal', Yii::$app->request->referrer ?: ['index'], ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>