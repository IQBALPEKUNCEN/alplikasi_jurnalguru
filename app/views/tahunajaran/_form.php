<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Tahunajaran */
/* @var $form yii\widgets\ActiveForm */

// CSS untuk styling form tahun ajaran
$this->registerCss("
    /* Background gradient untuk body */
    body {
        background: linear-gradient(to right, #c9d6ff, #e2e2e2); // Gradient biru ke abu-abu untuk background
    }

    /* Styling untuk card utama */
    .tahunajaran-form .card {
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1); // Shadow untuk efek kedalaman
        border: none;
        border-radius: 15px; // Rounded corners
        margin: 30px auto;
        max-width: 600px;
    }

    /* Styling untuk header card */
    .tahunajaran-form .card-header {
        background: linear-gradient(135deg, #2196f3, #1e88e5); // Gradient biru untuk header
        color: white;
        font-size: 22px;
        padding: 20px;
        border-radius: 15px 15px 0 0;
        font-weight: 700;
        text-align: center;
    }

    /* Styling untuk body card */
    .tahunajaran-form .card-body {
        padding: 25px;
        background-color: #fff; // Background putih untuk body
        border-radius: 0 0 15px 15px;
    }

    /* Styling untuk input form */
    .form-control {
        border-radius: 8px; // Rounded corners untuk input
        padding: 10px;
    }

    /* Styling untuk label form */
    .form-group label {
        font-weight: 600; // Bold untuk label
    }

    /* Styling untuk tombol success (hijau) */
    .tahunajaran-form .btn-success {
        background: linear-gradient(135deg, #43e97b, #38f9d7); // Gradient hijau untuk tombol simpan
        color: #fff;
        font-weight: bold;
        border: none;
        padding: 10px 20px;
        border-radius: 25px; // Rounded button
    }

    /* Styling untuk tombol primary (ungu) */
    .tahunajaran-form .btn-primary {
        background: linear-gradient(135deg, #a29bfe, #6c5ce7); // Gradient ungu untuk tombol update
        color: #fff;
        font-weight: bold;
        border: none;
        padding: 10px 20px;
        border-radius: 25px; // Rounded button
    }

    /* Styling untuk tombol danger (merah) */
    .tahunajaran-form .btn-danger {
        border-radius: 25px; // Rounded button
        padding: 10px 20px;
    }

    /* Efek hover untuk semua tombol */
    .tahunajaran-form .form-group .btn:hover {
        transform: translateY(-2px); // Efek naik saat hover
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2); // Shadow saat hover
        transition: all 0.3s ease; // Transisi smooth
    }
");
?>

<div class="tahunajaran-form card">
    <!-- Header card dengan judul dinamis berdasarkan operasi (tambah/edit) -->
    <div class="card-header">
        <?= $model->isNewRecord ? '🆕 Tambah Tahun Ajaran' : '✏️ Ubah Tahun Ajaran' ?>
    </div>

    <div class="card-body">
        <?php $form = ActiveForm::begin(); ?>

        <!-- Input untuk kode tahun ajaran -->
        <?= $form->field($model, 'kodeta')->textInput(['maxlength' => true, 'placeholder' => 'Contoh: TA2024']) ?>

        <!-- Dropdown untuk semester -->
        <?= $form->field($model, 'semester')->dropDownList([
            'ganjil' => '🟢 Ganjil',
            'genap' => '🔵 Genap',
        ], ['prompt' => '📚 Pilih Semester']) ?>

        <!-- Input untuk nama tahun ajaran -->
        <?= $form->field($model, 'namata')->textInput(['maxlength' => true, 'placeholder' => 'Contoh: Tahun Ajaran 2024/2025']) ?>

        <!-- Checkbox untuk status aktif -->
        <?= $form->field($model, 'isaktif')->checkbox(['label' => '✅ Tandai sebagai Tahun Ajaran Aktif']) ?>

        <!-- Group tombol aksi -->
        <div class="form-group mt-4 text-center">
            <!-- Tombol submit dengan teks dinamis -->
            <?= Html::submitButton($model->isNewRecord ? '💾 Simpan' : '🔄 Update', [
                'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'
            ]) ?>
            <!-- Tombol batal -->
            <?= Html::a('❌ Batal', Yii::$app->request->referrer, ['class' => 'btn btn-danger']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>