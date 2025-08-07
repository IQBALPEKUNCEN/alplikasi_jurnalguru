<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Siswa;
use app\models\Mapel;
use app\models\Tahunajaran;

/** @var yii\web\View $this */
/** @var app\models\Nilai $model */
/** @var yii\widgets\ActiveForm $form */

$this->registerCss(<<<CSS
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(to right, #83a4d4, #b6fbff);
    padding: 30px;
}

.nilai-form {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    max-width: 800px;
    margin: auto;
    animation: fadeInUp 0.5s ease-out;
}

.form-group label {
    font-weight: 600;
    color: #2d3748;
}

.form-control {
    border-radius: 12px;
    padding: 10px 14px;
    border: 2px solid #e2e8f0;
    transition: 0.3s;
    background: #ffffff;
}

.form-control:focus {
    border-color: #4299e1;
    box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.2);
    transform: scale(1.02);
}

.btn-success {
    background: linear-gradient(45deg, #00c6ff, #0072ff);
    border: none;
    padding: 12px 30px;
    font-weight: 600;
    border-radius: 12px;
    color: white;
    transition: 0.3s ease;
    box-shadow: 0 5px 15px rgba(0, 114, 255, 0.4);
    text-transform: uppercase;
}

.btn-success:hover {
    background: linear-gradient(45deg, #0072ff, #00c6ff);
    transform: translateY(-2px);
}

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}
CSS);
?>

<div class="nilai-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nis')->dropDownList(
        \yii\helpers\ArrayHelper::map(
            \app\models\Siswa::find()->with('kelas')->all(),
            'nis',
            function ($siswa) {
                $kelas = $siswa->kelas->nama ?? '(kelas tidak ditemukan)';
                return "{$siswa->nis} - {$kelas} - {$siswa->nama}";
            }
        ),
        ['prompt' => '👨‍🎓 Pilih Siswa', 'class' => 'form-control']
    ) ?>

    <?= $form->field($model, 'kode_mapel')->dropDownList(
        ArrayHelper::map(Mapel::find()->all(), 'kode_mapel', function ($mapel) {
            return $mapel->kode_mapel . ' - ' . $mapel->nama;
        }),
        ['prompt' => '📚 Pilih Mata Pelajaran', 'class' => 'form-control']
    ) ?>

    <?= $form->field($model, 'nilai_angka')->input('number', [
        'min' => 0,
        'max' => 100,
        'step' => 1,
        'class' => 'form-control',
        'placeholder' => 'Masukkan nilai (0 - 100)'
    ]) ?>

    <?= $form->field($model, 'semester')->dropDownList([
        'Ganjil' => 'Ganjil',
        'Genap' => 'Genap',
    ], ['prompt' => '🗓️ Pilih Semester', 'class' => 'form-control']) ?>

    <?= $form->field($model, 'tahun_ajaran')->dropDownList(
        ArrayHelper::map(Tahunajaran::find()->all(), 'kodeta', 'kodeta'),
        ['prompt' => '📅 Pilih Tahun Ajaran', 'class' => 'form-control']
    ) ?>

    <div class="form-group text-center mt-4">
        <?= Html::submitButton('💾 Simpan Nilai', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>