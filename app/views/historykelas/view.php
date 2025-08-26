<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use app\modules\UserManagement\components\GhostHtml;

/* @var $this yii\web\View */
/* @var $model app\models\base\Historykelas */

$this->title = 'Pengumuman Kelas #' . $model->history_id;
$this->params['breadcrumbs'][] = ['label' => 'Pengumuman Kelas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

// Pastikan jQuery ter-load
\yii\web\JqueryAsset::register($this);

// CSS Modern dengan dominasi biru
$this->registerCss(<<<CSS
    body {
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
        min-height: 100vh;
    }

    .historykelas-view {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 15px 35px rgba(13, 71, 161, 0.2);
        margin: 20px auto;
        max-width: 1200px;
    }

    .page-header {
        background: linear-gradient(135deg, #1565c0 0%, #0d47a1 100%);
        color: white;
        padding: 30px;
        border-radius: 15px;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(13, 71, 161, 0.3);
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="2" fill="rgba(255,255,255,0.1)"/></svg>') repeat;
        animation: float 20s linear infinite;
    }

    @keyframes float {
        0% { transform: translate(0, 0) rotate(0deg); }
        100% { transform: translate(-50px, -50px) rotate(360deg); }
    }

    .page-header h1 {
        margin: 0;
        font-size: 2.5rem;
        font-weight: 700;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        position: relative;
        z-index: 1;
    }

    .page-header .subtitle {
        opacity: 0.9;
        font-size: 1.1rem;
        margin-top: 10px;
        position: relative;
        z-index: 1;
    }

    .action-buttons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 30px;
        justify-content: center;
    }

    .btn-modern {
        border: none;
        border-radius: 25px;
        padding: 12px 25px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    .btn-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.5s;
    }

    .btn-modern:hover::before {
        left: 100%;
    }

    .btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.3);
    }

    .btn-success-modern {
        background: linear-gradient(45deg, #00796b, #004d40);
        color: white;
    }

    .btn-info-modern {
        background: linear-gradient(45deg, #0288d1, #01579b);
        color: white;
    }

    .btn-primary-modern {
        background: linear-gradient(45deg, #1565c0, #0d47a1);
        color: white;
    }

    .btn-danger-modern {
        background: linear-gradient(45deg, #d32f2f, #b71c1c);
        color: white;
    }

    .detail-section {
        background: white;
        border-radius: 15px;
        margin-bottom: 25px;
        box-shadow: 0 5px 20px rgba(13, 71, 161, 0.1);
        overflow: hidden;
        transition: transform 0.2s ease;
    }

    .detail-section:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(13, 71, 161, 0.15);
    }

    .detail-header {
        background: linear-gradient(45deg, #1976d2, #1565c0);
        color: white;
        padding: 20px 25px;
        font-size: 1.3rem;
        font-weight: 700;
        position: relative;
    }

    .detail-header i {
        margin-right: 10px;
        font-size: 1.5rem;
    }

    .detail-content {
        padding: 25px;
    }

    .table-detail {
        margin: 0;
    }

    .table-detail th {
        background: linear-gradient(45deg, #e3f2fd, #bbdefb);
        color: #0d47a1;
        font-weight: 600;
        border: none;
        padding: 15px 20px;
        width: 200px;
    }

    .table-detail td {
        background: #f8faff;
        border: none;
        padding: 15px 20px;
        color: #2c3e50;
        font-weight: 500;
    }

    .table-detail tr:nth-child(even) th {
        background: linear-gradient(45deg, #bbdefb, #90caf9);
    }

    .table-detail tr:nth-child(even) td {
        background: #f1f8ff;
    }

    .info-card {
        background: linear-gradient(135deg, #e8f4fd 0%, #d1e7dd 100%);
        border-left: 5px solid #1565c0;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .info-card h3 {
        color: #0d47a1;
        margin: 0 0 15px 0;
        font-size: 1.4rem;
        font-weight: 700;
    }

    .fade-in {
        animation: fadeIn 0.6s ease-in;
    }

    @keyframes fadeIn {
        from { 
            opacity: 0; 
            transform: translateY(30px); 
        }
        to { 
            opacity: 1; 
            transform: translateY(0); 
        }
    }

    .slide-in {
        animation: slideIn 0.8s ease-out;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-50px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .status-badge {
        display: inline-block;
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .status-active {
        background: linear-gradient(45deg, #4caf50, #2e7d32);
        color: white;
    }

    .status-inactive {
        background: linear-gradient(45deg, #ff9800, #f57c00);
        color: white;
    }

    .gender-badge {
        padding: 6px 12px;
        border-radius: 15px;
        font-weight: 500;
        font-size: 0.85rem;
    }

    .gender-male {
        background: linear-gradient(45deg, #2196f3, #1976d2);
        color: white;
    }

    .gender-female {
        background: linear-gradient(45deg, #e91e63, #c2185b);
        color: white;
    }

    @media (max-width: 768px) {
        .historykelas-view {
            margin: 10px;
            padding: 20px;
        }
        
        .page-header {
            padding: 20px;
        }
        
        .page-header h1 {
            font-size: 1.8rem;
        }
        
        .action-buttons {
            justify-content: center;
        }
        
        .btn-modern {
            margin: 5px;
            width: calc(50% - 10px);
        }
        
        .table-detail th {
            width: auto;
        }
    }
CSS);

// Load FontAwesome untuk ikon
echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">';
?>

<div class="historykelas-view fade-in">
    <!-- Header Section -->
    <div class="page-header">
        <h1><i class="fas fa-history"></i> <?= Html::encode($this->title) ?></h1>
        <div class="subtitle">
            <i class="fas fa-info-circle"></i> Informasi lengkap tentang riwayat kelas siswa
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="action-buttons slide-in">
        <?= GhostHtml::a(
            '<i class="fas fa-plus"></i> Buat Baru',
            ['/historykelas/create'],
            ['class' => 'btn btn-modern btn-success-modern']
        ) ?>
        <?= GhostHtml::a(
            '<i class="fas fa-list"></i> Daftar',
            ['/historykelas/index'],
            ['class' => 'btn btn-modern btn-info-modern']
        ) ?>
        <?= GhostHtml::a(
            '<i class="fas fa-edit"></i> Edit',
            ['/historykelas/update', 'id' => $model->history_id],
            ['class' => 'btn btn-modern btn-primary-modern']
        ) ?>
        <?= GhostHtml::a(
            '<i class="fas fa-trash"></i> Hapus',
            ['/historykelas/delete', 'id' => $model->history_id],
            [
                'class' => 'btn btn-modern btn-danger-modern',
                'data' => [
                    'confirm' => 'Apakah Anda yakin ingin menghapus data history ini?',
                    'method' => 'post',
                ],
            ]
        ) ?>
    </div>

    <!-- Info Card Overview -->
    <div class="info-card fade-in">
        <h3><i class="fas fa-clipboard-list"></i> Ringkasan Pengumuman Kelas</h3>
        <div class="row">
            <div class="col-md-3">
                <strong>ID Pengumuman:</strong><br>
                <span style="color: #1565c0; font-size: 1.2rem; font-weight: 600;">
                    #<?= Html::encode($model->history_id) ?>
                </span>
            </div>
            <!-- <div class="col-md-3">
                <strong>NIS Siswa:</strong><br>
                <span style="color: #00796b; font-size: 1.1rem; font-weight: 600;">
                    <?= $model->nis0 ? Html::encode($model->nis0->nis) : '-' ?>
                </span>
            </div> -->
            <div class="col-md-3">
                <strong>Kelas:</strong><br>
                <span style="color: #d32f2f; font-size: 1.1rem; font-weight: 600;">
                    <?= $model->kodeKelas ? Html::encode($model->kodeKelas->kode_kelas) : '-' ?>
                </span>
            </div>
            <div class="col-md-3">
                <strong>Tahun Ajaran:</strong><br>
                <span style="color: #0288d1; font-size: 1.1rem; font-weight: 600;">
                    <?= $model->kodeta0 ? Html::encode($model->kodeta0->kodeta) : '-' ?>
                </span>
            </div>
        </div>
    </div>

    <!-- Detail History Section -->
    <div class="detail-section slide-in">
        <div class="detail-header">
            <i class="fas fa-clipboard-list"></i> Detail Kelas
        </div>
        <div class="detail-content">
            <?= DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'table table-detail'],
                'attributes' => [
                    [
                        'attribute' => 'history_id',
                        'label' => 'ID History',
                        'value' => '#' . $model->history_id
                    ],
                    // [
                    //     'attribute' => 'nis0.nis',
                    //     'label' => 'Nomor Induk Siswa (NIS)',
                    //     'value' => $model->nis0 ? $model->nis0->nis : 'Data tidak tersedia'
                    // ],
                    [
                        'attribute' => 'kodeta0.kodeta',
                        'label' => 'Kode Tahun Ajaran',
                        'value' => $model->kodeta0 ? $model->kodeta0->kodeta : 'Data tidak tersedia'
                    ],
                    [
                        'attribute' => 'kodeKelas.kode_kelas',
                        'label' => 'Kode Kelas',
                        'value' => $model->kodeKelas ? $model->kodeKelas->kode_kelas : 'Data tidak tersedia'
                    ],
                ],
            ]) ?>
        </div>
    </div>

    <?php if ($model->kodeKelas): ?>
        <!-- Detail Kelas Section -->
        <div class="detail-section slide-in">
            <div class="detail-header">
                <i class="fas fa-school"></i> Informasi Kelas
            </div>
            <div class="detail-content">
                <?= DetailView::widget([
                    'model' => $model->kodeKelas,
                    'options' => ['class' => 'table table-detail'],
                    'attributes' => [
                        [
                            'attribute' => 'kode_jenjang',
                            'label' => 'Jenjang Pendidikan',
                        ],
                        [
                            'attribute' => 'kode_jurusan',
                            'label' => 'Kode Jurusan',
                        ],
                        [
                            'attribute' => 'nama',
                            'label' => 'Nama Kelas',
                        ],
                    ],
                ]) ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($model->nis0): ?>
        <!-- Detail Siswa Section -->
        <div class="detail-section slide-in">
            <div class="detail-header">
                <i class="fas fa-user-graduate"></i> Informasi Siswa
            </div>
            <div class="detail-content">
                <?= DetailView::widget([
                    'model' => $model->nis0,
                    'options' => ['class' => 'table table-detail'],
                    'attributes' => [
                        [
                            'attribute' => 'nama',
                            'label' => 'Nama Lengkap',
                        ],
                        [
                            'attribute' => 'kode_kelas',
                            'label' => 'Kelas Saat Ini',
                        ],
                        [
                            'attribute' => 'kode_jk',
                            'label' => 'Jenis Kelamin',
                            'format' => 'raw',
                            'value' => function ($model) {
                                if ($model->kode_jk === 'L') {
                                    return '<span class="gender-badge gender-male"><i class="fas fa-mars"></i> Laki-laki</span>';
                                } else {
                                    return '<span class="gender-badge gender-female"><i class="fas fa-venus"></i> Perempuan</span>';
                                }
                            },
                        ],
                        [
                            'attribute' => 'tempat_lahir',
                            'label' => 'Tempat Lahir',
                        ],
                        [
                            'attribute' => 'tanggal_lahir',
                            'label' => 'Tanggal Lahir',
                            'value' => function ($model) {
                                return date('d F Y', strtotime($model->tanggal_lahir));
                            }
                        ],
                        [
                            'attribute' => 'no_hp',
                            'label' => 'Nomor HP/WhatsApp',
                            'format' => 'raw',
                            'value' => function ($model) {
                                if ($model->no_hp) {
                                    return '<i class="fas fa-phone"></i> ' . $model->no_hp;
                                }
                                return 'Tidak tersedia';
                            }
                        ],
                        [
                            'attribute' => 'alamat',
                            'label' => 'Alamat Lengkap',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return '<i class="fas fa-map-marker-alt"></i> ' . ($model->alamat ?: 'Tidak tersedia');
                            }
                        ],
                    ],
                ]) ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($model->kodeta0): ?>
        <!-- Detail Tahun Ajaran Section -->
        <div class="detail-section slide-in">
            <div class="detail-header">
                <i class="fas fa-calendar-alt"></i> Informasi Tahun Ajaran
            </div>
            <div class="detail-content">
                <?= DetailView::widget([
                    'model' => $model->kodeta0,
                    'options' => ['class' => 'table table-detail'],
                    'attributes' => [
                        [
                            'attribute' => 'semester',
                            'label' => 'Semester',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return '<strong>Semester ' . $model->semester . '</strong>';
                            }
                        ],
                        [
                            'attribute' => 'namata',
                            'label' => 'Nama Tahun Ajaran',
                        ],
                        [
                            'attribute' => 'isaktif',
                            'label' => 'Status Tahun Ajaran',
                            'format' => 'raw',
                            'value' => function ($model) {
                                if ($model->isaktif) {
                                    return '<span class="status-badge status-active"><i class="fas fa-check-circle"></i> Aktif</span>';
                                } else {
                                    return '<span class="status-badge status-inactive"><i class="fas fa-times-circle"></i> Tidak Aktif</span>';
                                }
                            },
                        ],
                    ],
                ]) ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Footer Info -->
    <div class="info-card fade-in" style="margin-top: 30px;">
        <div class="row">
            <div class="col-md-12 text-center">
                <h3><i class="fas fa-info-circle"></i> Informasi</h3>
                <p style="margin: 0; color: #6c757d;">
                    Data Pengumuman ini menunjukkan riwayat penempatan siswa dalam kelas tertentu pada tahun ajaran yang bersangkutan.
                    Pastikan semua informasi sudah benar sebelum melakukan perubahan.
                </p>
            </div>
        </div>
    </div>
</div>

<?php
// JavaScript untuk animasi dan interaksi
$script = <<<JS
$(document).ready(function() {
    // Smooth scroll untuk elemen yang baru muncul
    $('.detail-section').each(function(index) {
        $(this).delay(index * 200).queue(function(next) {
            $(this).addClass('slide-in');
            next();
        });
    });
    
    // Tooltip untuk button
    $('[data-toggle="tooltip"]').tooltip();
    
    // Konfirmasi hapus yang lebih menarik
    $('.btn-danger-modern').click(function(e) {
        e.preventDefault();
        var href = $(this).attr('href');
        
        if (confirm('⚠️ PERHATIAN!\\n\\nApakah Anda yakin ingin menghapus data history kelas ini?\\n\\nData yang sudah dihapus tidak dapat dikembalikan!')) {
            // Buat form untuk POST request
            var form = $('<form method="post" action="' + href + '"></form>');
            form.append('<input type="hidden" name="_csrf" value="' + $('meta[name=csrf-token]').attr('content') + '">');
            $('body').append(form);
            form.submit();
        }
    });
    
    // Animasi hover untuk detail section
    $('.detail-section').hover(
        function() {
            $(this).addClass('shadow-lg');
        },
        function() {
            $(this).removeClass('shadow-lg');
        }
    );
});
JS;

$this->registerJs($script);
?>