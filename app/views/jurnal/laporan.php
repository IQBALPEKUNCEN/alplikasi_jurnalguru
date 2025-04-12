<?php

use kartik\datetime\DateTimePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $laporans app\models\Laporan[] */
/* @var $laporan app\models\Laporan */
/* @var $jenjangs array */
/* @var $kelases array */
/* @var $mapels array */

$this->title = 'Laporan Kehadiran Guru';
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success">
        <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>

<div>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tanggal')->textInput(['type' => 'date']) ?>
    
    <?= $form->field($model, 'kode_kelas')->dropDownList(
        ['All' => 'All'] + $kelases,  // Tambahkan opsi "All"
        ['prompt' => 'Pilih Kelas']
    ) ?>
    
    <?= $form->field($model, 'kode_mapel')->dropDownList(
        ['All' => 'All'] + $mapels,  // Tambahkan opsi "All"
        ['prompt' => 'Pilih Mapel']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Filter', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Reset', ['jurnal/laporan'], ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<div>
    <h2>Daftar Laporan</h2>
</div>

<!-- Tambahkan ID pada tabel untuk akses JavaScript -->
<table id="data-table" class="table">
    <thead>
        <tr>
            <th>No</th> <!-- Kolom untuk nomor urut -->
            <th>Tanggal</th>
            <th>Nama Guru</th>
            <th>Kode Kelas</th>
            <th>Kode Mapel</th>
            <th>Status</th>
            <th>Waktu Presensi</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; // Inisialisasi nomor urut ?>
        <?php foreach ($laporans as $laporan): ?>
            <tr>
                <td><?= $no++ ?></td> <!-- Tampilkan nomor urut dan increment -->
                <td><?= date('d-m-Y', strtotime($laporan['tanggal'])) ?></td>
                <td><?= Html::encode($laporan['nama']) ?></td>
                <td><?= Html::encode($laporan['kode_kelas']) ?></td>
                <td><?= Html::encode($laporan['kode_mapel']) ?></td>
                <td>
                    <?php if ($laporan['status'] == 'Hadir'): ?>
                        <span class="badge badge-success">Hadir</span> <!-- Tanda hijau untuk hadir -->
                    <?php else: ?>
                        <span class="badge badge-secondary"><?= Html::encode($laporan['status']) ?></span> <!-- Warna abu-abu untuk status lain -->
                    <?php endif; ?>
                </td>
                <td><?= date('d-m-Y H:i:s', strtotime($laporan['waktupresensi'])) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Tambahkan tombol untuk ekspor -->
<button id="export-btn" class="btn btn-success">Excel</button>

<!-- Sertakan library XLSX -->
<script src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>

<script>
    document.getElementById('export-btn').addEventListener('click', function() {
        // Mendapatkan tabel
        var table = document.getElementById('data-table');
        
        // Mengonversi tabel ke workbook
        var workbook = XLSX.utils.table_to_book(table, { sheet: 'Sheet1' });
        
        // Mengekspor workbook ke file Excel
        XLSX.writeFile(workbook, 'laporan_kehadiran_guru.xlsx');
    });
</script>
