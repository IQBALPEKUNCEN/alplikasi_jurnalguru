<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Tugas;
use app\models\Siswa;
use app\models\Jurusan;

/** @var yii\web\View $this */
/** @var app\models\PengumpulanTugas $model */

$this->title = 'Detail Pengumpulan Tugas #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pengumpulan Tugas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

// Ambil data tugas
$tugas = Tugas::findOne($model->tugas_id);

// Ambil data siswa berdasarkan nama (jika model menyimpan nama_siswa)
$siswa = Siswa::findOne(['nis' => $model->nis]);

// Tentukan status berdasarkan deadline (opsional)
// $isLate = false;
// if ($tugas && $tugas->deadline) {
//     $isLate = strtotime($model->tanggal_kumpul) > strtotime($tugas->deadline);
// }
?>

<style>
    .pengumpulan-tugas-view {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .header-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 15px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    }

    .header-card h1 {
        margin: 0;
        font-size: 2.2em;
        font-weight: 300;
    }

    .header-card .subtitle {
        opacity: 0.9;
        margin-top: 8px;
        font-size: 1.1em;
    }

    .action-buttons {
        margin: 25px 0;
        text-align: center;
    }

    .action-buttons .btn {
        margin: 0 8px;
        padding: 12px 25px;
        border-radius: 25px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-primary {
        background: linear-gradient(45deg, #4CAF50, #45a049);
        color: white;
    }

    .btn-primary:hover {
        background: linear-gradient(45deg, #45a049, #4CAF50);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(76, 175, 80, 0.4);
    }

    .btn-danger {
        background: linear-gradient(45deg, #f44336, #d32f2f);
        color: white;
    }

    .btn-danger:hover {
        background: linear-gradient(45deg, #d32f2f, #f44336);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(244, 67, 54, 0.4);
    }

    .detail-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-bottom: 20px;
    }

    .detail-card-header {
        background: linear-gradient(90deg, #3a6073 0%, #16222a 100%);
        color: white;
        padding: 20px 30px;
        font-size: 1.3em;
        font-weight: 500;
    }


    .detail-card-body {
        padding: 0;
    }

    .custom-detail-view table {
        width: 100%;
        margin: 0;
    }

    .custom-detail-view th {
        background: #f8f9fa;
        color: #495057;
        font-weight: 600;
        padding: 18px 25px;
        border: none;
        width: 35%;
        font-size: 0.95em;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .custom-detail-view td {
        padding: 18px 25px;
        border: none;
        color: #333;
        font-size: 1em;
        border-bottom: 1px solid #eee;
    }

    .custom-detail-view tr:last-child td {
        border-bottom: none;
    }

    .custom-detail-view tr:hover {
        background-color: #f8f9fa;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.85em;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-ontime {
        background-color: #d4edda;
        color: #155724;
    }

    .status-late {
        background-color: #f8d7da;
        color: #721c24;
    }

    .file-info {
        background: #e3f2fd;
        padding: 10px 15px;
        border-radius: 8px;
        border-left: 4px solid #2196F3;
        display: inline-block;
    }

    .student-info {
        background: #f3e5f5;
        padding: 10px 15px;
        border-radius: 8px;
        border-left: 4px solid #9c27b0;
    }

    .task-info {
        background: #fff3e0;
        padding: 10px 15px;
        border-radius: 8px;
        border-left: 4px solid #ff9800;
    }

    .icon {
        margin-right: 8px;
        font-size: 1.1em;
    }

    @media (max-width: 768px) {
        .header-card {
            padding: 20px;
            text-align: center;
        }

        .header-card h1 {
            font-size: 1.8em;
        }

        .action-buttons .btn {
            display: block;
            margin: 8px auto;
            width: 200px;
        }

        .custom-detail-view th,
        .custom-detail-view td {
            padding: 12px 15px;
            font-size: 0.9em;
        }
    }
</style>

<div class="pengumpulan-tugas-view">

    <!-- Header Card -->
    <div class="header-card">
        <h1><i class="fas fa-file-alt icon"></i><?= Html::encode($this->title) ?></h1>
        <div class="subtitle">
            <i class="fas fa-calendar-alt icon"></i>
            Dikumpulkan pada: <?= date('d F Y, H:i', strtotime($model->tanggal_kumpul)) ?> WIB
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="action-buttons">
        <?= Html::a('<i class="fas fa-edit"></i> Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fas fa-trash-alt"></i> Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Yakin ingin menghapus data ini?',
                'method' => 'post',
            ],
        ]) ?>
    </div>

    <!-- Detail Information Card -->
    <div class="detail-card">
        <div class="detail-card-header">
            <i class="fas fa-info-circle icon"></i>
            Detail Pengumpulan Tugas
        </div>
        <div class="detail-card-body">
            <div class="custom-detail-view">
                <?= DetailView::widget([
                    'model' => $model,
                    'options' => ['class' => ''],
                    'attributes' => [
                        [
                            'label' => 'ID Pengumpulan',
                            'value' => '#' . $model->id,
                        ],
                        [
                            'label' => 'Judul Tugas',
                            'format' => 'html',
                            'value' => $tugas ?
                                '<div class="task-info"><i class="fas fa-tasks icon"></i><strong>' .
                                Html::encode($tugas->judul_tugas) . '</strong></div>' :
                                '<span class="text-muted">(Tidak ditemukan)</span>',
                        ],
                        [
                            'label' => 'Informasi Siswa',
                            'format' => 'html',
                            'value' => $siswa ?
                                '<div class="student-info">
                                    <i class="fas fa-user-graduate icon"></i>
                                    <strong>' . Html::encode($siswa->nama) . '</strong><br>
                                    <small>
                                        <i class="fas fa-id-card icon"></i>NIS: ' . Html::encode($model->nis) . ' | 
                                        <i class="fas fa-school icon"></i>Kelas: ' .
                                Html::encode($siswa->kelas->kode_kelas ?? '-') . ' - ' .
                                Html::encode($siswa->kelas->jurusan->kode_jurusan ?? '-') . '
                                    </small>
                                </div>' :
                                '<span class="text-muted">(Siswa tidak ditemukan)</span>',
                        ],
                        [
                            'label' => 'File Tugas',
                            'format' => 'html',
                            'value' => $model->file_tugas ?
                                '<div class="file-info">
                                    <i class="fas fa-download icon"></i>
                                    <strong>' . Html::encode($model->file_tugas) . '</strong>
                                </div>' :
                                '<span class="text-muted">Tidak ada file</span>',
                        ],
                        [
                            'label' => 'Keterangan',
                            'format' => 'html',
                            'value' => $model->keterangan ?
                                '<div style="background: #f8f9fa; padding: 10px; border-radius: 5px; border-left: 3px solid #28a745;">
                                    <i class="fas fa-comment-alt icon"></i>' .
                                Html::encode($model->keterangan) . '
                                </div>' :
                                '<span class="text-muted">Tidak ada keterangan</span>',
                        ],

                        [
                            'label' => 'File Tugas',
                            'format' => 'html',
                            'value' => $model->file_tugas ?
                                '<div class="file-info">
            <i class="fas fa-download icon"></i>
            <strong>' . Html::encode($model->file_tugas) . '</strong><br>' .
                                Html::a('<i class="fas fa-eye"></i> Lihat File', ['view-file', 'id' => $model->id], [
                                    'class' => 'btn btn-sm btn-primary mt-2',
                                    'target' => '_blank',
                                    'style' => 'margin-top: 10px;'
                                ]) .
                                '</div>' :
                                '<span class="text-muted">Tidak ada file</span>',
                        ],


                    ],
                ]) ?>
            </div>
        </div>
    </div>

</div>

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">