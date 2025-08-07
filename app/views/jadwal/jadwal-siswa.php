<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
use app\modules\UserManagement\components\GhostHtml;

/** @var yii\web\View $this */
/** @var yii\data\ArrayDataProvider $dataProvider */
/** @var yii\base\DynamicModel $model */
/** @var array $kelasList */
/** @var array $mapelList */
/** @var array $guruList */
/** @var array $jurusanList */
/** @var array $hariList */
/** @var int $totalJadwal */

$this->title = 'Jadwal Siswa';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css');
$this->registerCssFile('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
$this->registerCss("
/* Base Styles */
body { 
    font-family: 'Inter', sans-serif; 
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    margin: 0;
    padding: 20px;
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

@keyframes shimmer {
    0% { background-position: -200px 0; }
    100% { background-position: calc(200px + 100%) 0; }
}

/* Card Styles */
.jadwal-container {
    max-width: 1200px;
    margin: 0 auto;
    animation: fadeInUp 0.8s ease-out;
}

.main-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 24px;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    overflow: hidden;
    position: relative;
}

.main-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #667eea, #764ba2, #f093fb, #f5576c);
    background-size: 300% 100%;
    animation: shimmer 3s ease-in-out infinite;
}

.card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    position: relative;
    overflow: hidden;
}

.card-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    animation: pulse 4s ease-in-out infinite;
}

.header-content {
    position: relative;
    z-index: 2;
}

.header-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
}

.header-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
    font-weight: 300;
}

.card-body {
    padding: 2rem;
}

/* Section Styles */
.section-card {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.section-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.12);
}

.section-title {
    font-size: 1.3rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.section-icon {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.1rem;
}

/* Button Styles */
.kelas-btn {
    background: white;
    border: 2px solid #e2e8f0;
    border-radius: 50px;
    padding: 0.75rem 1.5rem;
    font-weight: 500;
    color: #64748b;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    margin: 0.25rem;
    position: relative;
    overflow: hidden;
}

.kelas-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.kelas-btn:hover::before {
    left: 100%;
}

.kelas-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    border-color: #667eea;
    color: #667eea;
}

.kelas-btn.active {
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-color: #667eea;
    color: white;
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
}

/* Tab Styles */
.custom-tabs {
    display: flex;
    background: #f8fafc;
    border-radius: 16px;
    padding: 0.5rem;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.tab-item {
    flex: 1;
    min-width: 120px;
    text-align: center;
    padding: 1rem;
    border-radius: 12px;
    background: transparent;
    color: #64748b;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    position: relative;
}

.tab-item:hover {
    background: rgba(102, 126, 234, 0.1);
    color: #667eea;
    transform: translateY(-1px);
}

.tab-item.active {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 1rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
}

.btn-modern {
    background: white;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 0.75rem 1.5rem;
    font-weight: 500;
    color: #64748b;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    border-color: #667eea;
    color: #667eea;
}

.btn-export {
    background: linear-gradient(135deg, #48bb78, #38a169);
    color: white;
    border: none;
}

.btn-export:hover {
    background: linear-gradient(135deg, #38a169, #2f855a);
    color: white;
}

.btn-reset {
    background: linear-gradient(135deg, #f56565, #e53e3e);
    color: white;
    border: none;
}

.btn-reset:hover {
    background: linear-gradient(135deg, #e53e3e, #c53030);
    color: white;
}

/* Table Styles */
.table-container {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.table {
    margin-bottom: 0;
}

.table thead th {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    font-weight: 600;
    border: none;
    padding: 1.5rem 1rem;
    text-align: center;
    position: relative;
}

.table tbody tr {
    transition: all 0.3s ease;
    border-bottom: 1px solid #f1f5f9;
}

.table tbody tr:hover {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.05));
    transform: scale(1.01);
}

.table tbody td {
    padding: 1.5rem 1rem;
    vertical-align: middle;
    border: none;
}

/* Badge Styles */
.badge-mapel {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    font-weight: 600;
    margin-right: 1rem;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.badge-mapel::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, rgba(255,255,255,0.1), transparent);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.badge-mapel:hover {
    transform: scale(1.1) rotate(5deg);
}

.badge-mapel:hover::before {
    opacity: 1;
}

.badge-biru { background: linear-gradient(135deg, #3b82f6, #1e40af); color: white; }
.badge-hijau { background: linear-gradient(135deg, #10b981, #059669); color: white; }
.badge-merah { background: linear-gradient(135deg, #f59e0b, #d97706); color: white; }
.badge-ungu { background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; }
.badge-kuning { background: linear-gradient(135deg, #f59e0b, #d97706); color: white; }
.badge-pink { background: linear-gradient(135deg, #ec4899, #db2777); color: white; }
.badge-orange { background: linear-gradient(135deg, #f97316, #ea580c); color: white; }
.badge-tosca { background: linear-gradient(135deg, #06b6d4, #0891b2); color: white; }

/* Mapel Card */
.mapel-card {
    display: flex;
    align-items: center;
    padding: 0.5rem;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.mapel-info {
    flex: 1;
}

.mapel-name {
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 0.25rem;
}

.mapel-code {
    font-size: 0.85rem;
    color: #64748b;
}

/* Time Badge */
.time-badge {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    padding: 1rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 1.1rem;
    display: inline-block;
    min-width: 140px;
    text-align: center;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

/* Info Cards */
.info-card {
    background: white;
    border-radius: 12px;
    padding: 1rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.info-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.1rem;
}

.info-content {
    flex: 1;
}

.info-label {
    font-size: 0.85rem;
    color: #64748b;
    margin-bottom: 0.25rem;
}

.info-value {
    font-weight: 600;
    color: #2d3748;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: #64748b;
}

.empty-state i {
    font-size: 4rem;
    margin-bottom: 1rem;
    opacity: 0.3;
}

.empty-state h4 {
    font-weight: 600;
    margin-bottom: 0.5rem;
}

/* Responsive */
@media (max-width: 768px) {
    .card-body {
        padding: 1rem;
    }
    
    .header-title {
        font-size: 2rem;
    }
    
    .custom-tabs {
        flex-direction: column;
    }
    
    .tab-item {
        flex: none;
        min-width: auto;
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .table-container {
        overflow-x: auto;
    }
}

/* Print Styles */
@media print {
    body {
        background: white;
        padding: 0;
    }
    
    .print-hide {
        display: none !important;
    }
    
    .main-card {
        box-shadow: none;
        border: 1px solid #ddd;
    }
    
    .card-header {
        background: #f8f9fa !important;
        color: #333 !important;
    }
}
");

function getMapelBadge($namaMapel)
{
    $badges = [
        'Bahasa Indonesia' => ['badge-biru', 'fas fa-book'],
        'Matematika' => ['badge-hijau', 'fas fa-calculator'],
        'IPA' => ['badge-merah', 'fas fa-atom'],
        'Bahasa Inggris' => ['badge-ungu', 'fas fa-globe'],
        'IPS' => ['badge-kuning', 'fas fa-map'],
        'Agama' => ['badge-pink', 'fas fa-pray'],
        'Olahraga' => ['badge-orange', 'fas fa-running'],
        'Seni' => ['badge-tosca', 'fas fa-palette']
    ];
    foreach ($badges as $mapel => $badge) {
        if (stripos($namaMapel, $mapel) !== false) {
            return $badge;
        }
    }
    return ['badge-biru', 'fas fa-book'];
}

// Kolom untuk ExportMenu dan GridView
$gridColumn = [
    ['class' => 'yii\grid\SerialColumn'],
    [
        'label' => 'Jam',
        'value' => function ($model) {
            return date('H:i', strtotime($model->jam_mulai)) . ' - ' . date('H:i', strtotime($model->jam_selesai));
        },
    ],
    [
        'label' => 'Mapel',
        'value' => function ($model) {
            return $model->kodeMapel->nama ?? 'Tidak ada data';
        },
    ],
    [
        'label' => 'Guru',
        'value' => function ($model) {
            return $model->guru->nama ?? 'Tidak ada';
        },
    ],
    [
        'label' => 'Ruangan',
        'value' => function ($model) {
            return $model->ruangan->nama ?? 'Tidak ada';
        },
    ],
];
?>

<div class="jadwal-container">
    <div class="main-card">
        <!-- Header -->
        <div class="card-header">
            <div class="header-content">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="header-title">
                            <i class="fas fa-calendar-alt me-3"></i>
                            Jadwal Siswa
                        </h1>
                        <p class="header-subtitle">
                            Kelola dan lihat jadwal pelajaran dengan mudah
                        </p>
                    </div>
                    <div class="d-flex gap-2 print-hide">
                        <?= Html::a('<i class="fas fa-sync-alt me-2"></i>Reset', ['jadwal-siswa'], [
                            'class' => 'btn-modern btn-reset'
                        ]) ?>
                        <?= Html::a('<i class="fas fa-print me-2"></i>Cetak', '#', [
                            'class' => 'btn-modern',
                            'onclick' => 'window.print(); return false;'
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Body -->
        <div class="card-body">
            <!-- Pilih Kelas -->
            <div class="section-card">
                <div class="section-title">
                    <div class="section-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    Pilih Kelas
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <?php foreach ($kelasList as $kode => $nama): ?>
                        <?= Html::a(
                            '<i class="fas fa-graduation-cap me-2"></i>' . Html::encode($nama),
                            ['jadwal-siswa', 'kode_kelas' => $kode, 'hari' => Yii::$app->request->get('hari')],
                            [
                                'class' => 'kelas-btn ' . (Yii::$app->request->get('kode_kelas') == $kode ? 'active' : '')
                            ]
                        ) ?>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Pilih Hari -->
            <div class="section-card">
                <div class="section-title">
                    <div class="section-icon">
                        <i class="fas fa-calendar-week"></i>
                    </div>
                    Pilih Hari
                </div>
                <div class="custom-tabs">
                    <?php foreach ($hariList as $kode => $hari): ?>
                        <?= Html::a(
                            '<i class="fas fa-calendar-day me-2"></i>' . Html::encode($hari),
                            ['jadwal-siswa', 'kode_kelas' => Yii::$app->request->get('kode_kelas'), 'hari' => $hari],
                            [
                                'class' => 'tab-item' . (strtolower(Yii::$app->request->get('hari') ?? '') === strtolower($hari) ? ' active' : '')
                            ]
                        ) ?>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons print-hide">
                <?= ExportMenu::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => $gridColumn,
                    'target' => ExportMenu::TARGET_BLANK,
                    'fontAwesome' => true,
                    'dropdownOptions' => [
                        'label' => '<i class="fas fa-download me-2"></i>Export Data',
                        'class' => 'btn-modern btn-export',
                        'itemsBefore' => [
                            '<li class="dropdown-header">Pilih format export</li>',
                        ],
                    ],
                    'exportConfig' => [
                        ExportMenu::FORMAT_HTML => false,
                        ExportMenu::FORMAT_TEXT => false,
                        ExportMenu::FORMAT_EXCEL => false,
                        ExportMenu::FORMAT_PDF => false,
                        ExportMenu::FORMAT_CSV => [
                            'icon' => 'fas fa-file-csv',
                            'label' => 'CSV',
                        ],
                        ExportMenu::FORMAT_EXCEL_X => [
                            'label' => 'Excel (xlsx)',
                            'icon' => 'fas fa-file-excel',
                            'iconOptions' => ['class' => 'text-success'],
                            'alertMsg' => 'File Excel akan diunduh.',
                        ],
                    ],
                ]); ?>
            </div>

            <!-- Tabel Jadwal -->
            <div class="table-container">
                <?php Pjax::begin(['id' => 'jadwal-pjax']); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'summary' => '',
                    'emptyText' => '
                        <div class="empty-state">
                            <i class="fas fa-calendar-times"></i>
                            <h4>Tidak ada jadwal</h4>
                            <p>Silakan pilih kelas dan hari untuk melihat jadwal pelajaran</p>
                        </div>
                    ',
                    'tableOptions' => ['class' => 'table'],
                    'columns' => [
                        [
                            'label' => 'Waktu',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return '<div class="time-badge">' .
                                    date('H:i', strtotime($model->jam_mulai)) . ' - ' .
                                    date('H:i', strtotime($model->jam_selesai)) .
                                    '</div>';
                            },
                            'contentOptions' => ['class' => 'text-center', 'style' => 'width: 180px;']
                        ],
                        [
                            'label' => 'Mata Pelajaran',
                            'format' => 'raw',
                            'value' => function ($model) {
                                $namaMapel = $model->kodeMapel->nama ?? 'Tidak ada data';
                                $badge = getMapelBadge($namaMapel);
                                return '
                                    <div class="mapel-card">
                                        <div class="badge-mapel ' . $badge[0] . '">
                                            <i class="' . $badge[1] . '"></i>
                                        </div>
                                        <div class="mapel-info">
                                            <div class="mapel-name">' . Html::encode($namaMapel) . '</div>
                                            <div class="mapel-code">Kode: ' . Html::encode($model->kode_mapel ?? '-') . '</div>
                                        </div>
                                    </div>
                                ';
                            },
                        ],
                        [
                            'label' => 'Pengajar',
                            'format' => 'raw',
                            'value' => function ($model) {
                                $namaGuru = $model->guru->nama ?? 'Tidak ada';
                                return '
                                    <div class="info-card">
                                        <div class="info-icon">
                                            <i class="fas fa-user-tie"></i>
                                        </div>
                                        <div class="info-content">
                                            <div class="info-label">Guru</div>
                                            <div class="info-value">' . Html::encode($namaGuru) . '</div>
                                        </div>
                                    </div>
                                ';
                            },
                        ],
                        [
                            'label' => 'Ruangan',
                            'format' => 'raw',
                            'value' => function ($model) {
                                $namaRuangan = $model->ruangan->nama ?? 'Tidak ada';
                                return '
                                    <div class="info-card">
                                        <div class="info-icon">
                                            <i class="fas fa-door-open"></i>
                                        </div>
                                        <div class="info-content">
                                            <div class="info-label">Ruang Kelas</div>
                                            <div class="info-value">' . Html::encode($namaRuangan) . '</div>
                                        </div>
                                    </div>
                                ';
                            },
                        ],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>

<?php
$this->registerJs("
// Auto refresh setiap 5 menit
setInterval(function() {
    $.pjax.reload({container: '#jadwal-pjax'});
}, 300000);

// Smooth scroll untuk navigasi
$('a[href^=\"#\"]').on('click', function(e) {
    e.preventDefault();
    var target = $(this.getAttribute('href'));
    if (target.length) {
        $('html, body').animate({
            scrollTop: target.offset().top - 100
        }, 500);
    }
});

// Loading animation untuk PJAX
$(document).on('pjax:start', function() {
    $('#jadwal-pjax').addClass('loading');
});

$(document).on('pjax:end', function() {
    $('#jadwal-pjax').removeClass('loading');
});
");
?>