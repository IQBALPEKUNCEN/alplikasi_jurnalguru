<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\widgets\Select2;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use app\models\Siswa;
use app\models\Jurusan;
use yii\web\JsExpression;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\base\Jurnal */
/* @var $form kartik\form\ActiveForm */

$this->title = $model->isNewRecord ? 'Tambahkan Jurnal' : 'Update Jurnal';
$this->params['breadcrumbs'][] = ['label' => 'Jurnal', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

// Siswa Data
$siswaData = [];
$siswaJurusanMap = [];
try {
    $siswaList = \app\models\Siswa::find()->orderBy('nama ASC')->all();
    foreach ($siswaList as $siswa) {
        $siswaData[$siswa->id] = $siswa->nama . ' (' . $siswa->nis . ')';
        $siswaJurusanMap[$siswa->id] = [
            'nama' => $siswa->nama,
            'nis' => $siswa->nis,
            'jurusan' => $siswa->kode_jurusan ?? '',
            'kelas' => $siswa->kode_kelas ?? '',
        ];
    }
} catch (Exception $e) {
    try {
        $siswaList = \app\models\base\Siswa::find()->orderBy('nama ASC')->all();
        foreach ($siswaList as $siswa) {
            $siswaData[$siswa->nis] = $siswa->nama . ' (' . $siswa->nis . ')';
            $siswaJurusanMap[$siswa->nis] = [
                'nama' => $siswa->nama,
                'nis' => $siswa->nis,
                'jurusan' => $siswa->kode_jurusan ?? '',
                'kelas' => $siswa->kode_kelas ?? '',
            ];
        }
    } catch (Exception $e2) {
        $siswaData = [];
        $siswaJurusanMap = [];
    }
}

$this->registerJsVar('siswaJurusanMap', $siswaJurusanMap);

// Jurusan Data
$jurusanDetailData = [];
try {
    $jurusanList = \app\models\Jurusan::find()->orderBy('nama ASC')->all();
    foreach ($jurusanList as $jurusan) {
        $jurusanDetailData[$jurusan->kode_jurusan] = $jurusan->nama;
    }
} catch (Exception $e) {
    $jurusanDetailData = [];
}

// Detail Data
$detailData = [];
if (!$model->isNewRecord) {
    try {
        $jurnalDetails = $model->getJurnalDetails()->all();
        foreach ($jurnalDetails as $detail) {
            $detailData[] = [
                'id' => $detail->id,
                'siswa_id' => $detail->siswa_id ?? $detail->nis,
                'kode_jurusan' => $detail->kode_jurusan,
                'status' => $detail->status,
            ];
        }
    } catch (Exception $e) {
        $detailData = [];
    }
}
if (empty($detailData)) {
    $detailData[] = ['id' => '', 'siswa_id' => '', 'kode_jurusan' => '', 'status' => ''];
}

$js = <<<JS
let rowCount = $('#jurnal-detil-tbody tr').length;

// Fungsi menambahkan baris baru (kosong)
function addJurnalDetilRow() {
    const index = rowCount++;
    let siswaOptions = '<option value="">Pilih Siswa...</option>';
    for (const id in siswaJurusanMap) {
        const siswa = siswaJurusanMap[id];
        siswaOptions += '<option value="' + id + '">' + siswa.nama + ' (' + siswa.nis + ')</option>';
    }

    const row = '<tr id="jurnal-detil-row-' + index + '">' +
        '<td class="text-center nomor-urut">' + (index + 1) + '</td>' +
        '<td>' +
            '<select name="JurnalDetil[' + index + '][siswa_id]" class="form-control select2-siswa" data-row="' + index + '">' +
                siswaOptions +
            '</select>' +
        '</td>' +
        '<td>' +
            '<input name="JurnalDetil[' + index + '][kode_jurusan]" class="form-control jurusan-field" readonly placeholder="Akan otomatis terisi...">' +
        '</td>' +
        '<td>' +
            '<select name="JurnalDetil[' + index + '][status]" class="form-control">' +
                '<option value="">Pilih Status...</option>' +
                '<option value="HADIR">Hadir</option>' +
                '<option value="SAKIT">Sakit</option>' +
                '<option value="IZIN">Izin</option>' +
                '<option value="ALPA">Alpa</option>' +
            '</select>' +
        '</td>' +
        '<td class="text-center">' +
            '<button type="button" class="btn btn-danger btn-sm btn-hapus"><i class="fas fa-trash"></i></button>' +
        '</td>' +
    '</tr>';
    
    $('#jurnal-detil-tbody').append(row);
    initSelect2Siswa();
    updateNomorUrut();
}

// Fungsi untuk menambahkan baris dengan siswa tertentu
function addJurnalDetilRowWithSiswa(siswaId) {
    const index = rowCount++;
    const siswa = siswaJurusanMap[siswaId];
    let siswaOptions = '<option value="">Pilih Siswa...</option>';
    
    for (const id in siswaJurusanMap) {
        const siswaData = siswaJurusanMap[id];
        const selected = id === siswaId ? 'selected' : '';
        siswaOptions += '<option value="' + id + '" ' + selected + '>' + siswaData.nama + ' (' + siswaData.nis + ')</option>';
    }

    const jurusanValue = siswa ? (siswa.jurusan || '') : '';
    
    const row = '<tr id="jurnal-detil-row-' + index + '">' +
        '<td class="text-center nomor-urut">' + (index + 1) + '</td>' +
        '<td>' +
            '<select name="JurnalDetil[' + index + '][siswa_id]" class="form-control select2-siswa" data-row="' + index + '">' +
                siswaOptions +
            '</select>' +
        '</td>' +
        '<td>' +
            '<input name="JurnalDetil[' + index + '][kode_jurusan]" class="form-control jurusan-field" ' +
                   'readonly placeholder="Akan otomatis terisi..." value="' + jurusanValue + '">' +
        '</td>' +
        '<td>' +
            '<select name="JurnalDetil[' + index + '][status]" class="form-control">' +
                '<option value="">Pilih Status...</option>' +
                '<option value="HADIR" selected>Hadir</option>' +
                '<option value="SAKIT">Sakit</option>' +
                '<option value="IZIN">Izin</option>' +
                '<option value="ALPA">Alpa</option>' +
            '</select>' +
        '</td>' +
        '<td class="text-center">' +
            '<button type="button" class="btn btn-danger btn-sm btn-hapus"><i class="fas fa-trash"></i></button>' +
        '</td>' +
    '</tr>';
    
    $('#jurnal-detil-tbody').append(row);
}

// Fungsi menginisialisasi Select2
function initSelect2Siswa() {
    $('.select2-siswa').select2({
        width: '100%',
        placeholder: 'Pilih Siswa...'
    });
}

// Fungsi memperbarui nomor urut setelah hapus/tambah
function updateNomorUrut() {
    $('#jurnal-detil-tbody tr').each(function(i, tr) {
        $(tr).find('.nomor-urut').text(i + 1);
    });
}

// Fungsi untuk filter siswa berdasarkan kelas
function filterSiswaByKelas(kodeKelas) {
    const filteredSiswa = {};
    for (const id in siswaJurusanMap) {
        const siswa = siswaJurusanMap[id];
        if (siswa.kelas === kodeKelas) {
            filteredSiswa[id] = siswa;
        }
    }
    return filteredSiswa;
}

// Event handler untuk perubahan kelas
$(document).on('change', '#kode-kelas', function () {
    const kodeKelas = $(this).val();
    
    if (!kodeKelas) {
        // Jika tidak ada kelas dipilih, kosongkan jurnal detail
        $('#jurnal-detil-tbody').empty();
        rowCount = 0;
        addJurnalDetilRow();
        return;
    }

    // Filter siswa berdasarkan kelas
    const siswaByKelas = filterSiswaByKelas(kodeKelas);
    
    // Bersihkan jurnal detail yang ada
    $('#jurnal-detil-tbody').empty();
    rowCount = 0;
    
    // Otomatis tambahkan siswa ke jurnal detail
    if (Object.keys(siswaByKelas).length > 0) {
        Object.keys(siswaByKelas).forEach(function(siswaId) {
            addJurnalDetilRowWithSiswa(siswaId);
        });
        
        // Pesan konfirmasi
        alert('Berhasil memuat ' + Object.keys(siswaByKelas).length + ' siswa untuk kelas ' + kodeKelas);
    } else {
        // Jika tidak ada siswa, tambahkan baris kosong
        addJurnalDetilRow();
        alert('Tidak ada siswa ditemukan untuk kelas ' + kodeKelas);
    }
    
    // Update select2
    initSelect2Siswa();
});

// Tambah baris saat tombol ditekan
$(document).on('click', '#tambah-jurnal-detil', function () {
    addJurnalDetilRow();
});

// Hapus baris
$(document).on('click', '.btn-hapus', function () {
    if ($('#jurnal-detil-tbody tr').length > 1) {
        $(this).closest('tr').remove();
        updateNomorUrut();
    } else {
        alert('Minimal harus ada satu baris jurnal detail');
    }
});

// Auto isi jurusan saat siswa dipilih
$(document).on('change', '.select2-siswa', function () {
    const siswaId = $(this).val();
    const row = $(this).data('row');
    const jurusan = siswaJurusanMap[siswaId] ? (siswaJurusanMap[siswaId].jurusan || '') : '';
    $('input[name="JurnalDetil[' + row + '][kode_jurusan]"]').val(jurusan);
});

// Set waktu sekarang
$(document).on('click', '#set-waktu-sekarang', function () {
    const now = new Date();
    const day = String(now.getDate()).padStart(2, '0');
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const year = now.getFullYear();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    
    const formatted = day + '/' + month + '/' + year + ' ' + hours + ':' + minutes;
    $('#waktupresensi-input').val(formatted);
});

// Validation before submit
$(document).on('submit', '#jurnal-form', function(e) {
    let hasError = false;
    let errorMessage = '';
    
    // Validasi jurnal detail
    const detailRows = $('#jurnal-detil-tbody tr');
    if (detailRows.length === 0) {
        hasError = true;
        errorMessage += 'Minimal harus ada satu jurnal detail.\\n';
    }
    
    // Validasi setiap baris jurnal detail
    detailRows.each(function(index, row) {
        const siswaId = $(row).find('.select2-siswa').val();
        const status = $(row).find('select[name*="[status]"]').val();
        
        if (siswaId && !status) {
            hasError = true;
            errorMessage += 'Baris ' + (index + 1) + ': Status harus dipilih jika siswa sudah dipilih.\\n';
        }
    });
    
    if (hasError) {
        alert('Terdapat kesalahan:\\n' + errorMessage);
        e.preventDefault();
        return false;
    }
    
    // Show loading
    $('#loading-overlay').show();
});

// Inisialisasi awal Select2
initSelect2Siswa();
JS;

$this->registerJs($js, View::POS_READY);
?>

<div class="jurnal-form">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-<?= $model->isNewRecord ? 'plus-circle' : 'edit' ?>"></i>
                            <?= Html::encode($this->title) ?>
                        </h3>
                    </div>
                    <div class="card-body">

                        <?php $form = ActiveForm::begin([
                            'id' => 'jurnal-form',
                            'type' => ActiveForm::TYPE_VERTICAL,
                            'options' => ['enctype' => 'multipart/form-data'],
                            'fieldConfig' => [
                                'template' => "<div class='form-group'>{label}\n{input}\n{hint}\n{error}</div>",
                                'labelOptions' => ['class' => 'form-label font-weight-bold'],
                            ]
                        ]); ?>

                        <?= $form->errorSummary($model, [
                            'header' => '<div class="alert alert-danger"><h5><i class="fas fa-exclamation-triangle"></i> Terdapat kesalahan:</h5>',
                            'footer' => '</div>'
                        ]); ?>

                        <!-- Info untuk new record -->
                        <?php if ($model->isNewRecord): ?>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i>
                                <strong>Informasi:</strong>
                                Pilih kelas untuk otomatis memuat daftar siswa ke jurnal detail.
                            </div>
                        <?php endif; ?>

                        <!-- Data Guru, Jurusan dan Tahun Ajaran -->
                        <div class="row">
                            <div class="col-md-4">
                                <?php
                                $guruData = [];
                                try {
                                    $guruList = \app\models\base\Guru::find()->orderBy('nama')->asArray()->all();
                                    foreach ($guruList as $guru) {
                                        $nip = $guru['jabatan'] ?? $guru['jabatan'] ?? 'N/A';
                                        $namaGuru = $guru['nama'] ?? $guru['nama_guru'] ?? $guru['guru_nama'] ?? 'Unknown';
                                        $guruData[$guru['guru_id']] = $nip . ' - ' . $namaGuru;
                                    }
                                } catch (Exception $e) {
                                    $guruData = [];
                                }
                                ?>
                                <?= $form->field($model, 'guru_id')->widget(Select2::classname(), [
                                    'data' => $guruData,
                                    'options' => [
                                        'placeholder' => 'Pilih Guru',
                                        'id' => 'guru-id',
                                        'style' => 'width:100%'
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        'width' => '100%',
                                    ],
                                ])->label('Guru <span class="text-danger">*</span>'); ?>
                            </div>

                            <div class="col-md-4">
                                <?php
                                $jurusanData = [];
                                try {
                                    $jurusanList = \app\models\base\Jurusan::find()->orderBy('kode_jurusan')->asArray()->all();
                                    foreach ($jurusanList as $jurusan) {
                                        $jurusanData[$jurusan['kode_jurusan']] = $jurusan['kode_jurusan'] . ' - ' . ($jurusan['nama'] ?? 'Unknown');
                                    }
                                } catch (Exception $e) {
                                    $jurusanData = [];
                                }
                                ?>
                                <?= $form->field($model, 'kode_jurusan')->widget(Select2::classname(), [
                                    'data' => $jurusanData,
                                    'options' => [
                                        'placeholder' => 'Pilih Jurusan',
                                        'id' => 'kode_jurusan'
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label('Jurusan <span class="text-danger">*</span>'); ?>
                            </div>

                            <div class="col-md-4">
                                <?php
                                $tahunAjaranData = [];
                                try {
                                    $tahunAjaranList = \app\models\base\Tahunajaran::find()->orderBy('kodeta DESC')->asArray()->all();
                                    $tahunAjaranData = \yii\helpers\ArrayHelper::map(
                                        $tahunAjaranList,
                                        'kodeta',
                                        function ($data) {
                                            return $data['kodeta'] . ' (' . ($data['tahun_ajaran'] ?? '') . ')';
                                        }
                                    );
                                } catch (Exception $e) {
                                    $tahunAjaranData = [];
                                }
                                ?>
                                <?= $form->field($model, 'kodeta')->widget(Select2::classname(), [
                                    'data' => $tahunAjaranData,
                                    'options' => [
                                        'placeholder' => 'Pilih Tahun Ajaran',
                                        'id' => 'kodeta'
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label('Tahun Ajaran <span class="text-danger">*</span>'); ?>
                            </div>
                        </div>

                        <!-- Tanggal dan Hari -->
                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'tanggal')->widget(DateControl::className(), [
                                    'type' => DateControl::FORMAT_DATE,
                                    'saveFormat' => 'php:Y-m-d',
                                    'ajaxConversion' => true,
                                    'options' => [
                                        'id' => 'jurnal-tanggal',
                                        'pluginOptions' => [
                                            'placeholder' => 'Pilih Tanggal',
                                            'autoclose' => true,
                                            'todayHighlight' => true,
                                            'format' => 'yyyy-mm-dd',
                                        ]
                                    ]
                                ])->label('Tanggal <span class="text-danger">*</span>'); ?>
                            </div>

                            <div class="col-md-6">
                                <?php
                                $hariData = [];
                                try {
                                    $hariList = \app\models\base\Hari::find()->orderBy('hari_id')->asArray()->all();
                                    foreach ($hariList as $hari) {
                                        $namaHari = $hari['nama_hari'] ?? $hari['nama'] ?? $hari['hari'] ?? 'Unknown';
                                        $hariData[$hari['hari_id']] = $namaHari;
                                    }
                                } catch (Exception $e) {
                                    $hariData = [];
                                }
                                ?>
                                <?= $form->field($model, 'hari_id')->widget(Select2::classname(), [
                                    'data' => $hariData,
                                    'options' => [
                                        'placeholder' => 'Pilih Hari',
                                        'id' => 'hari-id'
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label('Hari <span class="text-danger">*</span>'); ?>
                            </div>
                        </div>

                        <!-- Jam Ke dan Waktu Presensi -->
                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'jam_ke')->textInput([
                                    'placeholder' => 'Masukkan Jam Ke (1-12)',
                                    'type' => 'number',
                                    'min' => 1,
                                    'max' => 12,
                                    'class' => 'form-control',
                                    'id' => 'jurnal-jam_ke'
                                ])->label('Jam Ke <span class="text-danger">*</span>'); ?>
                            </div>

                            <div class="col-md-6">
                                <?php
                                $waktuPresensiBaru = '';
                                if (!empty($model->waktupresensi)) {
                                    try {
                                        $dt = new \DateTime($model->waktupresensi);
                                        $waktuPresensiBaru = $dt->format('d/m/Y H:i');
                                    } catch (\Exception $e) {
                                        $waktuPresensiBaru = $model->waktupresensi;
                                    }
                                }
                                ?>
                                <?= $form->field($model, 'waktupresensi')->textInput([
                                    'placeholder' => 'DD/MM/YYYY HH:MM',
                                    'value' => $waktuPresensiBaru,
                                    'id' => 'waktupresensi-input',
                                    'class' => 'form-control',
                                ])->hint('Format: DD/MM/YYYY HH:MM (contoh: 15/06/2025 08:30)'); ?>

                                <button type="button" class="btn btn-sm btn-info mb-3" id="set-waktu-sekarang">
                                    <i class="fas fa-clock"></i> Set Waktu Sekarang
                                </button>
                            </div>
                        </div>

                        <!-- Kelas dan Mapel -->
                        <div class="row">
                            <div class="col-md-6">
                                <?php
                                $kelasData = [];
                                try {
                                    $kelasList = \app\models\base\Kelas::find()->orderBy('kode_kelas')->asArray()->all();
                                    $kelasData = \yii\helpers\ArrayHelper::map(
                                        $kelasList,
                                        'kode_kelas',
                                        function ($data) {
                                            $namaKelas = $data['nama_kelas'] ?? '';
                                            return $data['kode_kelas'] . ($namaKelas ? ' - ' . $namaKelas : '');
                                        }
                                    );
                                } catch (Exception $e) {
                                    $kelasData = [];
                                }
                                ?>
                                <?= $form->field($model, 'kode_kelas')->widget(Select2::classname(), [
                                    'data' => $kelasData,
                                    'options' => [
                                        'placeholder' => 'Pilih Kelas',
                                        'id' => 'kode-kelas'
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label('Kelas <span class="text-danger">*</span>')->hint('Pilih kelas untuk otomatis memuat daftar siswa'); ?>
                            </div>

                            <div class="col-md-6">
                                <?php
                                $mapelData = [];
                                try {
                                    $mapelList = \app\models\base\Mapel::find()->orderBy('kode_mapel')->asArray()->all();
                                    $mapelData = \yii\helpers\ArrayHelper::map(
                                        $mapelList,
                                        'kode_mapel',
                                        function ($data) {
                                            $namaMapel = $data['nama_mapel'] ?? '';
                                            return $data['kode_mapel'] . ($namaMapel ? ' - ' . $namaMapel : '');
                                        }
                                    );
                                } catch (Exception $e) {
                                    $mapelData = [];
                                }
                                ?>
                                <?= $form->field($model, 'kode_mapel')->widget(Select2::classname(), [
                                    'data' => $mapelData,
                                    'options' => [
                                        'placeholder' => 'Pilih Mata Pelajaran',
                                        'id' => 'kode-mapel'
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label('Mata Pelajaran <span class="text-danger">*</span>'); ?>
                            </div>
                        </div>

                        <!-- Jam Mulai dan Selesai -->
                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'jam_mulai')->widget(DateControl::class, [
                                    'type' => DateControl::FORMAT_TIME,
                                    'saveFormat' => 'php:H:i:s',
                                    'ajaxConversion' => true,
                                    'displayFormat' => 'HH:mm', // Format tampilan 24 jam
                                    'options' => [
                                        'id' => 'jurnal-jam_mulai',
                                        'pluginOptions' => [
                                            'placeholder' => 'Pilih Jam Mulai',
                                            'autoclose' => true,
                                            'showMeridian' => false,
                                            'minuteStep' => 5,
                                        ],
                                    ],
                                ])->label('Jam Mulai'); ?>
                            </div>

                            <div class="col-md-6">
                                <?= $form->field($model, 'jam_selesai')->widget(DateControl::class, [
                                    'type' => DateControl::FORMAT_TIME,
                                    'saveFormat' => 'php:H:i:s',
                                    'ajaxConversion' => true,
                                    'displayFormat' => 'HH:mm', // Format tampilan 24 jam
                                    'options' => [
                                        'id' => 'jurnal-jam_selesai',
                                        'pluginOptions' => [
                                            'placeholder' => 'Pilih Jam Selesai',
                                            'autoclose' => true,
                                            'showMeridian' => false,
                                            'minuteStep' => 5,
                                        ],
                                    ],
                                ])->label('Jam Selesai'); ?>
                            </div>
                        </div>

                        <!-- Materi Pembelajaran -->
                        <div class="row">
                            <div class="col-md-12">
                                <?php if ($model->isNewRecord): ?>
                                    <div class="form-group">
                                        <label class="form-label font-weight-bold">Materi Pembelajaran</label>
                                        <div class="alert alert-warning">
                                            <i class="fas fa-lock"></i>
                                            Materi pembelajaran dapat diisi setelah jurnal berhasil dibuat
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <?= $form->field($model, 'materi')->textarea([
                                        'rows' => 6,
                                        'placeholder' => 'Masukkan materi pembelajaran yang telah diajarkan...',
                                        'class' => 'form-control',
                                    ])->label('Materi Pembelajaran'); ?>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="row">
                            <div class="col-md-12">
                                <?= $form->field($model, 'status')->dropDownList([
                                    'HADIR' => 'HADIR - Guru mengajar sesuai jadwal',
                                    'ALPA' => 'ALPA - Guru tidak masuk tanpa keterangan',
                                    'IZIN' => 'IZIN - Guru tidak masuk dengan izin',
                                    'SAKIT' => 'SAKIT - Guru tidak masuk karena sakit'
                                ], [
                                    'prompt' => 'Pilih Status Kehadiran',
                                    'class' => 'form-control',
                                    'id' => 'jurnal-status'
                                ])->label('Status Kehadiran <span class="text-danger">*</span>'); ?>
                            </div>
                        </div>
                        <!-- Jurnal Detail -->
                        <div class="card mt-3">
                            <div class="card-header">
                                <h5 class="card-title">
                                    <i class="fas fa-users"></i> Jurnal Detail - Kehadiran Siswa
                                </h5>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-success btn-sm" id="tambah-jurnal-detil">
                                        <i class="fas fa-plus"></i> Tambah Siswa
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover" id="jurnal-detil-table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th width="5%" class="text-center">No</th>
                                                <th width="35%">Nama Siswa</th>
                                                <th width="20%">Jurusan</th>
                                                <th width="20%">Status Kehadiran</th>
                                                <th width="10%" class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="jurnal-detil-tbody">
                                            <?php if (!empty($detailData)): ?>
                                                <?php foreach ($detailData as $index => $detail): ?>
                                                    <tr id="jurnal-detil-row-<?= $index ?>">
                                                        <td class="text-center nomor-urut"><?= $index + 1 ?></td>
                                                        <td>
                                                            <?php if (!empty($detail['id'])): ?>
                                                                <!-- Hidden field untuk ID existing record -->
                                                                <input type="hidden" name="JurnalDetil[<?= $index ?>][id]" value="<?= $detail['id'] ?>">
                                                            <?php endif; ?>

                                                            <?= Select2::widget([
                                                                'name' => "JurnalDetil[{$index}][siswa_id]",
                                                                'data' => $siswaData,
                                                                'value' => $detail['siswa_id'] ?? '',
                                                                'options' => [
                                                                    'placeholder' => 'Pilih Siswa...',
                                                                    'class' => 'select2-siswa',
                                                                    'data-row' => $index,
                                                                ],
                                                                'pluginOptions' => [
                                                                    'allowClear' => true,
                                                                    'width' => '100%',
                                                                ],
                                                            ]); ?>
                                                        </td>
                                                        <td>
                                                            <input type="text"
                                                                name="JurnalDetil[<?= $index ?>][kode_jurusan]"
                                                                class="form-control jurusan-field"
                                                                readonly
                                                                placeholder="Akan otomatis terisi..."
                                                                value="<?= Html::encode($detail['kode_jurusan'] ?? '') ?>">
                                                        </td>
                                                        <td>
                                                            <?= Html::dropDownList(
                                                                "JurnalDetil[{$index}][status]",
                                                                $detail['status'] ?? 'HADIR',
                                                                [
                                                                    '' => 'Pilih Status...',
                                                                    'HADIR' => 'Hadir',
                                                                    'SAKIT' => 'Sakit',
                                                                    'IZIN' => 'Izin',
                                                                    'ALPA' => 'Alpa'
                                                                ],
                                                                [
                                                                    'class' => 'form-control',
                                                                    'id' => "status-{$index}"
                                                                ]
                                                            ); ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-danger btn-sm btn-hapus">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <!-- Baris default kosong jika tidak ada data -->
                                                <tr id="jurnal-detil-row-0">
                                                    <td class="text-center nomor-urut">1</td>
                                                    <td>
                                                        <?= Select2::widget([
                                                            'name' => 'JurnalDetil[0][siswa_id]',
                                                            'data' => $siswaData,
                                                            'options' => [
                                                                'placeholder' => 'Pilih Siswa...',
                                                                'class' => 'select2-siswa',
                                                                'data-row' => 0,
                                                            ],
                                                            'pluginOptions' => [
                                                                'allowClear' => true,
                                                                'width' => '100%',
                                                            ],
                                                        ]); ?>
                                                    </td>
                                                    <td>
                                                        <input type="text"
                                                            name="JurnalDetil[0][kode_jurusan]"
                                                            class="form-control jurusan-field"
                                                            readonly
                                                            placeholder="Akan otomatis terisi...">
                                                    </td>
                                                    <td>
                                                        <?= Html::dropDownList(
                                                            'JurnalDetil[0][status]',
                                                            '',
                                                            [
                                                                '' => 'Pilih Status...',
                                                                'HADIR' => 'Hadir',
                                                                'SAKIT' => 'Sakit',
                                                                'IZIN' => 'Izin',
                                                                'ALPA' => 'Alpa'
                                                            ],
                                                            ['class' => 'form-control']
                                                        ); ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-danger btn-sm btn-hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Info Section -->
                                <div class="mt-3">
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle"></i>
                                        <strong>Petunjuk:</strong>
                                        <ul class="mb-0 mt-2">
                                            <li>Pilih <strong>Kelas</strong> di atas untuk otomatis memuat daftar siswa</li>
                                            <li>Klik <strong>Tambah Siswa</strong> untuk menambah baris siswa secara manual</li>
                                            <li>Jurusan akan otomatis terisi berdasarkan data siswa yang dipilih</li>
                                            <li>Pastikan setiap siswa memiliki status kehadiran</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Submit -->
                        <div class="form-group mt-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="btn-group float-right">
                                        <?= Html::a(
                                            '<i class="fas fa-times"></i> Batal',
                                            ['index'],
                                            ['class' => 'btn btn-secondary']
                                        ) ?>

                                        <?= Html::submitButton(
                                            '<i class="fas fa-save"></i> ' . ($model->isNewRecord ? 'Simpan' : 'Update'),
                                            [
                                                'class' => 'btn btn-primary',
                                                'id' => 'btn-submit'
                                            ]
                                        ) ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php ActiveForm::end(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div id="loading-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999;">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; color: white;">
        <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <div class="mt-2">Menyimpan data...</div>
    </div>
</div>

<?php
// JavaScript tambahan untuk enhancement
$additionalJs = <<<JS
// Enhancement untuk UX yang lebih baik
$(document).ready(function() {
    // Auto-fokus ke field pertama jika form baru
    if ($('#jurnal-form').length && $('.has-error').length === 0) {
        $('#guru-id').focus();
    }
    
    // Konfirmasi sebelum meninggalkan halaman jika ada perubahan
    let formChanged = false;
    $('#jurnal-form input, #jurnal-form select, #jurnal-form textarea').on('change', function() {
        formChanged = true;
    });
    
    $(window).on('beforeunload', function() {
        if (formChanged) {
            return 'Ada perubahan yang belum disimpan. Yakin ingin meninggalkan halaman ini?';
        }
    });
    
    // Reset flag saat submit
    $('#jurnal-form').on('submit', function() {
        formChanged = false;
    });
    
    // Validasi real-time untuk jam ke
    $('#jurnal-jam_ke').on('input', function() {
        const val = parseInt($(this).val());
        if (val < 1 || val > 12) {
            $(this).addClass('is-invalid');
            if (!$(this).next('.invalid-feedback').length) {
                $(this).after('<div class="invalid-feedback">Jam ke harus antara 1-12</div>');
            }
        } else {
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').remove();
        }
    });
    
    // Auto-complete untuk waktu presensi dengan validasi format
    $('#waktupresensi-input').on('blur', function() {
        const val = $(this).val();
        const regex = /^(\d{2})\/(\d{2})\/(\d{4}) (\d{2}):(\d{2})$/;
        
        if (val && !regex.test(val)) {
            $(this).addClass('is-invalid');
            if (!$(this).next('.invalid-feedback').length) {
                $(this).after('<div class="invalid-feedback">Format harus DD/MM/YYYY HH:MM</div>');
            }
        } else {
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').remove();
        }
    });
    
    // Highlight baris yang dipilih di jurnal detail
    $(document).on('click', '#jurnal-detil-tbody tr', function() {
        $('#jurnal-detil-tbody tr').removeClass('table-active');
        $(this).addClass('table-active');
    });
    
    // Shortcut keyboard untuk menambah baris (Ctrl+N)
    $(document).on('keydown', function(e) {
        if (e.ctrlKey && e.which === 78) { // Ctrl+N
            e.preventDefault();
            $('#tambah-jurnal-detil').click();
        }
    });
    
    // Auto-save draft (optional - bisa diaktifkan jika diperlukan)
    // setInterval(function() {
    //     if (formChanged) {
    //         saveDraft();
    //     }
    // }, 60000); // Setiap 1 menit
});

// Fungsi untuk menyimpan draft (optional)
function saveDraft() {
    const formData = $('#jurnal-form').serializeArray();
    // Implementasi penyimpanan draft ke localStorage atau server
    localStorage.setItem('jurnal_draft', JSON.stringify(formData));
}

// Fungsi untuk memuat draft (optional)
function loadDraft() {
    const draft = localStorage.getItem('jurnal_draft');
    if (draft) {
        const formData = JSON.parse(draft);
        // Implementasi pemuatan draft
        console.log('Draft tersedia:', formData);
    }
}
JS;

$this->registerJs($additionalJs, View::POS_READY);
?>

<style>
    /* Custom CSS untuk tampilan yang lebih baik */
    .card {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border: none;
        border-radius: 8px;
    }

    .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 8px 8px 0 0 !important;
    }

    .table th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
    }

    .table-active {
        background-color: #e3f2fd !important;
    }

    .btn-hapus:hover {
        transform: scale(1.05);
        transition: all 0.2s;
    }

    .select2-container .select2-selection--single {
        height: 38px;
        border: 1px solid #ced4da;
        border-radius: 4px;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 36px;
    }

    .alert {
        border-radius: 8px;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
    }

    #loading-overlay {
        backdrop-filter: blur(5px);
    }

    .spinner-border {
        width: 3rem;
        height: 3rem;
    }

    .invalid-feedback {
        display: block;
    }

    .is-invalid {
        border-color: #dc3545;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .table-responsive {
            font-size: 14px;
        }

        .btn-sm {
            font-size: 12px;
            padding: 0.25rem 0.5rem;
        }

        .card-tools .btn {
            margin-bottom: 10px;
        }
    }

    /* Print styles */
    @media print {

        .btn,
        .card-tools,
        .alert {
            display: none !important;
        }

        .card {
            box-shadow: none;
            border: 1px solid #000;
        }
    }
</style>