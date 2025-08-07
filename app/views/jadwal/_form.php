<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Guru;
use app\models\Kelas;
use app\models\Mapel;
use app\models\Jurusan;
use app\models\Ruangan;

/** @var yii\web\View $this */
/** @var app\models\Jadwal $model */
/** @var yii\widgets\ActiveForm $form */

// CSS tambahan agar tampilan form lebih menarik
$this->registerCss(<<<CSS
.jadwal-form {
    background: #ffffff;
    padding: 30px;
    border-radius: 15px;
    max-width: 800px;
    margin: 30px auto;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    font-family: 'Inter', sans-serif;
}

.jadwal-form h1 {
    font-weight: bold;
    color: #1e3a8a;
    text-align: center;
    margin-bottom: 25px;
}

.jadwal-form .form-group label {
    font-weight: 600;
    color: #333;
}

.jadwal-form .form-control {
    border-radius: 8px;
    padding: 10px 12px;
    font-size: 14px;
}

.jadwal-form .btn-success {
    background: linear-gradient(to right, #059669, #10b981);
    border: none;
    border-radius: 8px;
    padding: 10px 25px;
    font-weight: bold;
    color: white;
    transition: 0.3s ease;
}

.jadwal-form .btn-success:hover {
    background: linear-gradient(to right, #047857, #059669);
    transform: scale(1.05);
}
CSS);
?>

<div class="jadwal-form">

    <h1><?= $model->isNewRecord ? '➕ Tambah Jadwal' : '✏️ Edit Jadwal' ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'hari')->dropDownList([
        'Senin' => 'Senin',
        'Selasa' => 'Selasa',
        'Rabu' => 'Rabu',
        'Kamis' => 'Kamis',
        'Jumat' => 'Jumat',
        'Sabtu' => 'Sabtu',
    ], ['prompt' => '- Pilih Hari -']) ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'jam_mulai')->textInput([
                'type' => 'time',
                'value' => $model->jam_mulai ? substr($model->jam_mulai, 0, 5) : null
            ]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'jam_selesai')->textInput([
                'type' => 'time',
                'value' => $model->jam_selesai ? substr($model->jam_selesai, 0, 5) : null
            ]) ?>
        </div>
    </div>

    <?= $form->field($model, 'ruangan_id')->dropDownList(
        ArrayHelper::map(Ruangan::find()->all(), 'id', 'nama'),
        ['prompt' => '- Pilih Ruangan -']
    ) ?>

    <?= $form->field($model, 'guru_id')->dropDownList(
        ArrayHelper::map(Guru::find()->all(), 'guru_id', function ($guru) {
            return $guru->jabatan . ' - ' . $guru->nama;
        }),
        ['prompt' => '- Pilih Guru -']
    ) ?>

    <?= $form->field($model, 'kode_kelas')->dropDownList(
        ArrayHelper::map(Kelas::find()->all(), 'kode_kelas', 'nama'),
        ['prompt' => '- Pilih Kelas -']
    ) ?>

    <?= $form->field($model, 'kode_mapel')->dropDownList(
        ArrayHelper::map(Mapel::find()->all(), 'kode_mapel', 'nama'),
        ['prompt' => '- Pilih Mata Pelajaran -']
    ) ?>

    <?= $form->field($model, 'kode_jurusan')->dropDownList(
        ArrayHelper::map(Jurusan::find()->all(), 'kode_jurusan', 'nama'),
        ['prompt' => '- Pilih Jurusan -']
    ) ?>

    <div class="form-group text-center mt-4">
        <?= Html::submitButton('💾 Simpan Jadwal', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>