<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use app\modules\UserManagement\components\GhostHtml;

/**
 * File View untuk menampilkan daftar tahun ajaran.
 *
 * @var yii\web\View $this - Objek view untuk rendering.
 * @var yii\data\ActiveDataProvider $dataProvider - Penyedia data untuk tabel grid.
 * @var app\models\search\TahunAjaranSearch $searchModel - Model pencarian untuk filter tabel.
 */

// === KONFIGURASI HALAMAN ===
// Menetapkan judul halaman dan breadcrumbs untuk navigasi.
$this->title = '📆 Daftar Tahun Ajaran';
$this->params['breadcrumbs'][] = $this->title;

// === STYLING CSS MODERN: PALET WARNA TEAL & ABU-ABU ===
// Mengimplementasikan CSS kustom untuk tampilan yang segar dan profesional menggunakan `$this->registerCss`.
// Ini adalah metode di Yii2 untuk menambahkan blok CSS langsung ke halaman.
$this->registerCss("
    /* === KONFIGURASI DASAR === */
    body {
        /* Background gradien lembut dengan warna teal dan abu-abu muda */
        background: linear-gradient(135deg, #e0f2f1 0%, #b2dfdb 100%);
        min-height: 100vh;
        /* Menggunakan font modern 'Inter' untuk keterbacaan yang baik */
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif;
        margin: 0;
        padding: 20px 0;
    }

    /* === KONTAINER UTAMA === */
    .tahunajaran-index {
        /* Background putih dengan sedikit transparansi untuk efek 'glass' */
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(8px);
        padding: 40px 35px;
        border-radius: 20px;
        /* Bayangan (shadow) yang lebih halus dan profesional */
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08), 
                    0 5px 10px rgba(0, 0, 0, 0.04);
        margin: 30px auto;
        max-width: 1200px;
        border: 1px solid rgba(255, 255, 255, 0.4);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    /* Efek saat mouse mengarah (hover) pada kontainer utama */
    .tahunajaran-index:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12), 
                    0 8px 16px rgba(0, 0, 0, 0.06);
    }

    /* === STYLING JUDUL === */
    .tahunajaran-index h1 {
        font-weight: 800;
        color: #263238;
        font-size: 2.5rem;
        text-align: center;
        margin-bottom: 30px;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        letter-spacing: -0.5px;
    }

    /* Dekorasi garis bawah pada judul */
    .tahunajaran-index h1::after {
        content: '';
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, #00bfa5, #00897b);
        display: block;
        margin: 15px auto 0 auto;
        border-radius: 2px;
        animation: shimmer 2s infinite;
    }
    
    /* Animasi shimmer untuk garis dekorasi */
    @keyframes shimmer {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }

    /* === KONTAINER TOMBOL === */
    .button-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        padding: 0 5px;
        flex-wrap: wrap;
        gap: 15px;
    }
    
    /* === STYLING TOMBOL TAMBAH === */
    .btn-tambah {
        background: linear-gradient(45deg, #00bfa5, #26a69a);
        color: white;
        font-weight: 700;
        padding: 12px 25px;
        font-size: 1.1rem;
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(0, 191, 165, 0.3);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        letter-spacing: 0.5px;
    }

    /* Efek hover untuk tombol tambah */
    .btn-tambah:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 10px 30px rgba(0, 191, 165, 0.4);
        background: linear-gradient(45deg, #26a69a, #4db6ac);
        color: white;
        text-decoration: none;
    }
    
    /* Efek saat tombol ditekan (active) */
    .btn-tambah:active {
        transform: translateY(-1px) scale(1.01);
    }

    /* === STYLING TABEL GRIDVIEW === */
    .kv-grid-container {
        border-radius: 15px;
        overflow: hidden;
        border: 1px solid rgba(0, 0, 0, 0.08);
        background: white;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    }

    /* Header tabel dengan styling menarik */
    .kv-grid-table thead tr {
        background: linear-gradient(135deg, #80cbc4, #4db6ac);
        color: white;
    }

    /* Styling untuk sel header */
    .kv-grid-table thead tr th {
        text-align: center;
        font-weight: 700;
        border: none;
        padding: 18px 15px;
        font-size: 1.05rem;
        letter-spacing: 0.5px;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        position: relative;
    }
    
    /* Styling untuk baris body tabel */
    .kv-grid-table tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    /* Efek hover pada baris tabel */
    .kv-grid-table tbody tr:hover {
        background: rgba(0, 191, 165, 0.05);
        transform: translateX(5px);
        box-shadow: inset 4px 0 0 rgba(0, 191, 165, 0.3);
    }

    /* Styling untuk sel body tabel */
    .kv-grid-table tbody td {
        vertical-align: middle;
        padding: 15px 12px;
        font-size: 1rem;
        color: #495057;
        line-height: 1.5;
    }

    /* === STYLING TOMBOL AKSI === */
    .grid-action-buttons {
        text-align: center;
    }
    
    /* Styling untuk link aksi */
    .grid-action-buttons a {
        font-size: 1.2rem;
        margin: 0 8px;
        color: #607d8b; /* Warna abu-abu kebiruan */
        transition: all 0.3s ease;
        padding: 8px;
        border-radius: 8px;
        display: inline-block;
        text-decoration: none;
    }

    /* Efek hover untuk tombol 'Lihat' (mata) */
    .grid-action-buttons a[title='Lihat']:hover {
        color: #00796b; /* Hijau teal tua */
        background: rgba(0, 121, 107, 0.1);
        transform: scale(1.2);
    }
    
    /* Efek hover untuk tombol 'Ubah' (pensil) */
    .grid-action-buttons a[title='Ubah']:hover {
        color: #ff9800; /* Oranye hangat */
        background: rgba(255, 152, 0, 0.1);
        transform: scale(1.2);
    }
    
    /* Efek hover untuk tombol 'Hapus' (tempat sampah) */
    .grid-action-buttons a[title='Hapus']:hover {
        color: #d32f2f; /* Merah gelap */
        background: rgba(211, 47, 47, 0.1);
        transform: scale(1.2);
    }

    /* === RESPONSIVE DESIGN === */
    /* CSS yang mengatur tampilan saat lebar layar 768px atau kurang (misalnya pada tablet dan ponsel) */
    @media (max-width: 768px) {
        .tahunajaran-index {
            padding: 20px 15px;
            margin: 15px;
            border-radius: 15px;
        }
        
        .tahunajaran-index h1 {
            font-size: 1.8rem;
            margin-bottom: 20px;
        }
        
        .button-container {
            /* Mengubah tata letak tombol menjadi kolom agar lebih rapi di layar kecil */
            flex-direction: column;
            gap: 20px;
            align-items: stretch;
        }
        
        .btn-tambah {
            width: 100%;
            text-align: center;
        }
    }
    
    /* === ANIMASI DAN EFEK TAMBAHAN === */
    .tahunajaran-index {
        /* Animasi fade-in saat halaman dimuat */
        animation: fadeInUp 0.8s ease-out;
    }
    
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
    
    /* Styling untuk bagian ringkasan (summary) data */
    .kv-grid-container .summary {
        padding: 15px;
        background: linear-gradient(90deg, #eceff1, #cfd8dc);
        color: #607d8b;
        font-weight: 600;
        border-top: 1px solid rgba(0, 0, 0, 0.05);
        text-align: center;
        font-size: 0.95rem;
    }
");

// === KONFIGURASI KOLOM GRID ===
// Mendefinisikan kolom-kolom yang akan ditampilkan dalam tabel GridView.
$gridColumns = [
    // Kolom nomor urut otomatis
    [
        'class' => 'yii\grid\SerialColumn',
        'header' => '№',
        'headerOptions' => ['class' => 'text-center', 'style' => 'width: 80px;'],
        'contentOptions' => ['class' => 'text-center font-weight-bold'],
    ],
    [
        'attribute' => 'kodeta',
        'label' => '📌 Kode TA',
        'headerOptions' => ['class' => 'text-center'],
        'contentOptions' => ['class' => 'text-center'],
        'format' => 'raw',
        'value' => function ($model) {
            // Menggunakan badge dengan styling gradien untuk menampilkan kode tahun ajaran.
            return '<span class="badge badge-primary" style="font-size: 0.9rem; padding: 6px 12px; background: linear-gradient(45deg, #4db6ac, #26a69a); border-radius: 20px; color: white;">'
                . Html::encode($model->kodeta) . '</span>';
        },
    ],
    [
        'attribute' => 'semester',
        'label' => '🗓️ Semester',
        'headerOptions' => ['class' => 'text-center'],
        'contentOptions' => ['class' => 'text-center'],
        'format' => 'raw',
        'value' => function ($model) {
            // Memberikan styling tebal pada teks semester.
            return '<strong style="color: #263238; font-size: 1.05rem;">'
                . Html::encode($model->semester) . '</strong>';
        },
    ],
    [
        'attribute' => 'namata',
        'label' => '📖 Nama Tahun Ajaran',
        'headerOptions' => ['class' => 'text-center'],
        'contentOptions' => ['class' => 'text-left'],
        'format' => 'raw',
        'value' => function ($model) {
            // Memberikan styling tebal pada teks nama tahun ajaran.
            return '<strong style="color: #263238; font-size: 1.05rem;">'
                . Html::encode($model->namata) . '</strong>';
        },
    ],
    [
        'attribute' => 'isaktif',
        'label' => '🔔 Status',
        'headerOptions' => ['class' => 'text-center'],
        'contentOptions' => ['class' => 'text-center'],
        // Mengubah nilai 1/0 menjadi teks 'Aktif'/'Tidak Aktif'.
        'value' => function ($model) {
            return $model->isaktif ? 'Aktif' : 'Tidak Aktif';
        },
        // Menambahkan filter dropdown untuk kolom ini.
        'filter' => [1 => 'Aktif', 0 => 'Tidak Aktif'],
        // Memberikan styling berbeda berdasarkan status aktif/tidak aktif.
        'contentOptions' => function ($model) {
            return [
                'class' => 'text-center ' . ($model->isaktif ? 'text-success font-weight-bold' : 'text-muted font-italic')
            ];
        }
    ],
];
?>

<!-- === STRUKTUR HTML HALAMAN === -->
<!-- Kontainer utama dengan kelas untuk styling CSS yang telah didefinisikan di atas. -->
<div class="tahunajaran-index">
    <!-- Judul halaman dengan ikon modern -->
    <h1><i class="fas fa-calendar-alt"></i> <?= Html::encode($this->title) ?></h1>

    <!-- Kontainer untuk tombol aksi dan export -->
    <div class="button-container">
        <!-- Tombol untuk menambah tahun ajaran baru -->
        <?= Html::a(
            '<i class="fas fa-plus-circle"></i> Tambah Tahun Ajaran',
            ['create'],
            [
                'class' => 'btn btn-tambah',
                'title' => 'Klik untuk menambah tahun ajaran baru'
            ]
        ) ?>

        <!-- Widget Export Menu dengan konfigurasi lengkap dari Kartk. -->
        <?= ExportMenu::widget([
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns,
            'target' => ExportMenu::TARGET_BLANK,
            'fontAwesome' => true,
            'dropdownOptions' => [
                'label' => '<i class="fas fa-download"></i> 📤 Export Data',
                'encodeLabel' => false,
                'class' => 'btn btn-export-custom',
                'title' => 'Klik untuk mengexport data ke berbagai format',
                'itemsBefore' => [
                    '<li class="dropdown-header" style="color: #00bfa5; font-weight: bold;">📋 Pilih Format Export</li>',
                ],
            ],
            // Konfigurasi format ekspor yang tersedia.
            'exportConfig' => [
                ExportMenu::FORMAT_TEXT => false,
                ExportMenu::FORMAT_HTML => false,
                ExportMenu::FORMAT_EXCEL => false,
                ExportMenu::FORMAT_PDF => [
                    'label' => 'PDF',
                    'icon' => 'fas fa-file-pdf',
                    'iconOptions' => ['class' => 'text-danger'],
                    'alertMsg' => 'File PDF akan segera diunduh.',
                    'options' => ['title' => 'Export ke format PDF'],
                ],
                ExportMenu::FORMAT_CSV => [
                    'label' => 'CSV',
                    'icon' => 'fas fa-file-csv',
                    'iconOptions' => ['class' => 'text-info'],
                    'alertMsg' => 'File CSV akan segera diunduh.',
                    'options' => ['title' => 'Export ke format CSV']
                ],
                ExportMenu::FORMAT_EXCEL_X => [
                    'label' => 'Excel (XLSX)',
                    'icon' => 'fas fa-file-excel',
                    'iconOptions' => ['class' => 'text-success'],
                    'alertMsg' => 'File Excel akan segera diunduh.',
                    'options' => ['title' => 'Export ke format Excel XLSX'],
                ],
            ],
        ]); ?>
    </div>

    <!-- Widget GridView untuk menampilkan data dalam tabel -->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        // Menggabungkan kolom-kolom yang sudah didefinisikan dengan kolom aksi.
        'columns' => array_merge($gridColumns, [
            [
                'class' => \yii\grid\ActionColumn::class,
                // Mengatur tombol-tombol aksi (Lihat, Ubah, Hapus).
                'template' => '{view} {update} {delete}',
                'header' => '⚙️ Aksi',
                'headerOptions' => ['class' => 'text-center', 'style' => 'width: 150px;'],
                'contentOptions' => ['class' => 'grid-action-buttons text-center'],
                'buttons' => [
                    // Tombol 'Lihat' (mata)
                    'view' => function ($url, $model) {
                        return Html::a(
                            '<i class="fas fa-eye"></i>',
                            ['view', 'id' => $model['kodeta']],
                            [
                                'title' => 'Lihat detail tahun ajaran: ' . $model['namata'],
                                'data-toggle' => 'tooltip',
                                'data-placement' => 'top'
                            ]
                        );
                    },
                    // Tombol 'Ubah' (pensil)
                    'update' => function ($url, $model) {
                        return Html::a(
                            '<i class="fas fa-edit"></i>',
                            ['update', 'id' => $model['kodeta']],
                            [
                                'title' => 'Ubah tahun ajaran: ' . $model['namata'],
                                'data-toggle' => 'tooltip',
                                'data-placement' => 'top'
                            ]
                        );
                    },
                    // Tombol 'Hapus' (tempat sampah)
                    'delete' => function ($url, $model) {
                        return Html::a(
                            '<i class="fas fa-trash-alt"></i>',
                            ['delete', 'id' => $model['kodeta']],
                            [
                                'title' => 'Hapus tahun ajaran: ' . $model['namata'],
                                'data-toggle' => 'tooltip',
                                'data-placement' => 'top',
                                'data' => [
                                    // Konfirmasi saat tombol hapus ditekan.
                                    'confirm' => 'Apakah Anda yakin ingin menghapus tahun ajaran "' . $model['namata'] . '"? Tindakan ini tidak dapat dibatalkan.',
                                    'method' => 'post',
                                ],
                            ]
                        );
                    },
                ],
            ],
        ]),

        // === OPSI STYLING GRIDVIEW ===
        'hover' => true, // Mengaktifkan efek hover pada baris tabel
        'striped' => true, // Mengaktifkan efek baris belang
        'condensed' => false,
        'bordered' => false,
        'responsiveWrap' => false,

        // Pesan ringkasan (summary) yang informatif
        'summary' => '<div class="text-center mt-3 mb-3">
                        <strong>📊 Menampilkan <span style="color: #00897b;">{begin}-{end}</span> dari total <span style="color: #00bfa5;">{totalCount}</span> tahun ajaran</strong>
                    </div>',

        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'before' => false,
            'after' => false,
            'footer' => false,
        ],
        'toolbar' => false,
        'responsive' => true,
        'responsiveWrap' => false,

        // Konfigurasi pager (pagination)
        'pager' => [
            'class' => 'yii\bootstrap4\LinkPager',
            'options' => ['class' => 'pagination justify-content-center'],
            'linkOptions' => ['class' => 'page-link'],
            'activePageCssClass' => 'active',
            'disabledPageCssClass' => 'disabled',
            'prevPageLabel' => '<i class="fas fa-chevron-left"></i> Sebelumnya',
            'nextPageLabel' => 'Selanjutnya <i class="fas fa-chevron-right"></i>',
            'firstPageLabel' => '<i class="fas fa-fast-backward"></i>',
            'lastPageLabel' => '<i class="fas fa-fast-forward"></i>',
        ],
    ]); ?>
</div>

<!-- === JAVASCRIPT TAMBAHAN === -->
<?php
// Mendaftarkan JavaScript untuk fungsionalitas tambahan seperti tooltip.
$this->registerJs("
    // Inisialisasi tooltip Bootstrap untuk tombol aksi
    $(document).ready(function() {
        // Aktifkan tooltip pada semua elemen yang memiliki atribut data-toggle='tooltip'
        $('[data-toggle=\"tooltip\"]').tooltip({
            container: 'body',
            trigger: 'hover'
        });
    });
");
?>