<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use app\modules\UserManagement\components\GhostHtml;

/**
 * File View untuk menampilkan daftar jurusan
 *
 * @var yii\web\View $this - Objek view untuk rendering
 * @var yii\data\ActiveDataProvider $dataProvider - Penyedia data untuk tabel grid
 * @var app\models\search\JurusanSearch $searchModel - Model pencarian untuk filter tabel
 */

// === KONFIGURASI HALAMAN ===
$this->title = '📚 Daftar Jurusan';
$this->params['breadcrumbs'][] = $this->title;

// === STYLING CSS MODERN: PALET WARNA TEAL & ABU-ABU ===
// Mengimplementasikan CSS kustom untuk tampilan yang segar dan profesional.
$this->registerCss("
    /* === KONFIGURASI DASAR === */
    /* Reset dan konfigurasi dasar untuk seluruh halaman */
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
    /* Styling untuk kontainer utama halaman */
    .jurusan-index {
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
    .jurusan-index:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12), 
                    0 8px 16px rgba(0, 0, 0, 0.06);
    }

    /* === STYLING JUDUL === */
    /* Styling untuk heading utama halaman */
    .jurusan-index h1 {
        font-weight: 800;
        /* Warna teks yang kontras dengan background */
        color: #263238;
        font-size: 2.5rem;
        text-align: center;
        margin-bottom: 30px;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        letter-spacing: -0.5px;
    }

    /* Dekorasi garis bawah pada judul */
    .jurusan-index h1::after {
        content: '';
        width: 80px;
        height: 4px;
        /* Gradien garis yang sesuai dengan palet warna baru */
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
    /* Layout untuk area tombol 'Tambah' dan 'Export' */
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
    /* Styling untuk tombol 'Tambah Jurusan Baru' */
    .btn-tambah {
        /* Gradien background warna hijau teal yang menarik */
        background: linear-gradient(45deg, #00bfa5, #26a69a);
        color: white;
        font-weight: 700;
        padding: 12px 25px;
        font-size: 1.1rem;
        border-radius: 12px;
        /* Bayangan yang menonjol */
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
    /* Kontainer utama GridView */
    .kv-grid-container {
        border-radius: 15px;
        overflow: hidden;
        border: 1px solid rgba(0, 0, 0, 0.08);
        background: white;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    }

    /* Header tabel dengan styling menarik */
    .kv-grid-table thead tr {
        /* Background gradien untuk header tabel */
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
    
    /* Efek hover pada header */
    .kv-grid-table thead tr th:hover {
        background: rgba(255, 255, 255, 0.1);
    }

    /* Styling untuk baris body tabel */
    .kv-grid-table tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    /* Efek hover pada baris tabel */
    .kv-grid-table tbody tr:hover {
        /* Background saat hover yang sesuai dengan palet */
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
    /* Kontainer untuk tombol aksi 'Lihat', 'Ubah', 'Hapus' */
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

    /* === STYLING TOMBOL EXPORT === */
    /* Styling untuk tombol dropdown 'Export Data' */
    .btn-export-custom {
        background: linear-gradient(135deg, #eceff1, #cfd8dc);
        border-color: #b0bec5;
        color: #546e7a;
        font-weight: 600;
        border-radius: 12px;
        padding: 12px 20px;
        transition: all 0.3s ease;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        font-size: 1rem;
    }

    /* Efek hover untuk tombol export */
    .btn-export-custom:hover {
        background: linear-gradient(135deg, #cfd8dc, #b0bec5);
        border-color: #90a4ae;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.12);
        color: #546e7a;
    }
    
    /* === RESPONSIVE DESIGN === */
    @media (max-width: 768px) {
        .jurusan-index {
            padding: 20px 15px;
            margin: 15px;
            border-radius: 15px;
        }
        
        .jurusan-index h1 {
            font-size: 1.8rem;
            margin-bottom: 20px;
        }
        
        .button-container {
            flex-direction: column;
            gap: 20px;
            align-items: stretch;
        }
        
        .btn-tambah, .btn-export-custom {
            width: 100%;
            text-align: center;
        }
    }
    
    /* === ANIMASI DAN EFEK TAMBAHAN === */
    .jurusan-index {
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
    
    .kv-grid-container .summary {
        padding: 15px;
        /* Warna background summary yang sesuai palet */
        background: linear-gradient(90deg, #eceff1, #cfd8dc);
        color: #607d8b;
        font-weight: 600;
        border-top: 1px solid rgba(0, 0, 0, 0.05);
        text-align: center;
        font-size: 0.95rem;
    }
");

// === KONFIGURASI KOLOM GRID ===
// Definisi kolom-kolom yang akan ditampilkan dalam tabel
$gridColumns = [
    // Kolom nomor urut otomatis
    [
        'class' => 'yii\grid\SerialColumn',
        'header' => '№',
        'headerOptions' => ['class' => 'text-center', 'style' => 'width: 80px;'],
        'contentOptions' => ['class' => 'text-center font-weight-bold'],
    ],
    [
        // Kolom kode jurusan dengan styling badge
        'attribute' => 'kode_jurusan',
        'label' => '🔢 Kode Jurusan',
        'headerOptions' => ['class' => 'text-center', 'style' => 'width: 150px;'],
        'contentOptions' => ['class' => 'text-center'],
        'format' => 'raw',
        'value' => function ($model) {
            return '<span class="badge badge-primary" style="font-size: 0.9rem; padding: 6px 12px; background: linear-gradient(45deg, #4db6ac, #26a69a); border-radius: 20px; color: white;">'
                . Html::encode($model->kode_jurusan) . '</span>';
        },
    ],
    [
        // Kolom nama jurusan dengan styling teks
        'attribute' => 'nama',
        'label' => '📚 Nama Jurusan',
        'headerOptions' => ['class' => 'text-center'],
        'contentOptions' => ['class' => 'text-left'],
        'format' => 'raw',
        'value' => function ($model) {
            return '<strong style="color: #263238; font-size: 1.05rem;">'
                . Html::encode($model->nama) . '</strong>';
        },
    ],
];
?>

<!-- === STRUKTUR HTML HALAMAN === -->
<div class="jurusan-index">
    <!-- Judul halaman dengan ikon modern -->
    <h1><i class="fas fa-sitemap"></i> <?= Html::encode($this->title) ?></h1>

    <!-- Kontainer untuk tombol aksi dan export -->
    <div class="button-container">
        <!-- Tombol untuk menambah jurusan baru -->
        <?= GhostHtml::a(
            '<i class="fas fa-plus-circle"></i> Tambah Jurusan Baru',
            ['/jurusan/create'],
            [
                'class' => 'btn btn-tambah',
                'title' => 'Klik untuk menambah jurusan baru'
            ]
        ) ?>

        <!-- Widget Export Menu dengan konfigurasi lengkap -->
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

        // Menggabungkan kolom data dan kolom aksi
        'columns' => array_merge($gridColumns, [
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'header' => '⚙️ Aksi',
                'headerOptions' => ['class' => 'text-center', 'style' => 'width: 150px;'],
                'contentOptions' => ['class' => 'grid-action-buttons text-center'],

                // Konfigurasi tombol-tombol aksi
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a(
                            '<i class="fas fa-eye"></i>',
                            ['view', 'id' => $model->kode_jurusan],
                            [
                                'title' => 'Lihat detail jurusan: ' . $model->nama,
                                'data-toggle' => 'tooltip',
                                'data-placement' => 'top'
                            ]
                        );
                    },
                    'update' => function ($url, $model) {
                        return Html::a(
                            '<i class="fas fa-edit"></i>',
                            ['update', 'id' => $model->kode_jurusan],
                            [
                                'title' => 'Edit jurusan: ' . $model->nama,
                                'data-toggle' => 'tooltip',
                                'data-placement' => 'top'
                            ]
                        );
                    },
                    'delete' => function ($url, $model) {
                        return Html::a(
                            '<i class="fas fa-trash-alt"></i>',
                            ['delete', 'id' => $model->kode_jurusan],
                            [
                                'title' => 'Hapus jurusan: ' . $model->nama,
                                'data-toggle' => 'tooltip',
                                'data-placement' => 'top',
                                'data' => [
                                    'confirm' => 'Apakah Anda yakin ingin menghapus jurusan "' . $model->nama . '"? Tindakan ini tidak dapat dibatalkan.',
                                    'method' => 'post',
                                ],
                            ]
                        );
                    },
                ],
            ],
        ]),

        // === OPSI STYLING GRIDVIEW ===
        'hover' => true,
        'striped' => true,
        'condensed' => false,
        'bordered' => false,
        'responsiveWrap' => false,

        // Pesan ringkasan (summary) yang informatif
        'summary' => '<div class="text-center mt-3 mb-3">
                        <strong>📊 Menampilkan <span style="color: #00897b;">{begin}-{end}</span> dari total <span style="color: #00bfa5;">{totalCount}</span> jurusan</strong>
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
// Mendaftarkan JavaScript untuk fungsionalitas tambahan seperti tooltip
$this->registerJs("
    // Inisialisasi tooltip Bootstrap untuk tombol aksi
    $(document).ready(function() {
        // Aktifkan tooltip pada semua elemen yang memiliki atribut data-toggle='tooltip'
        $('[data-toggle=\"tooltip\"]').tooltip({
            container: 'body',
            trigger: 'hover'
        });
        
        // Efek smooth scroll jika ada anchor link
        $('a[href*=\"#\"]').on('click', function(e) {
            var target = $(this.getAttribute('href'));
            if (target.length) {
                e.preventDefault();
                $('html, body').stop().animate({
                    scrollTop: target.offset().top - 100
                }, 1000);
            }
        });
        
        // Notifikasi success jika ada parameter success di URL
        var urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('success')) {
            // Membutuhkan library notifikasi eksternal seperti 'toastr'
            if (typeof toastr !== 'undefined') {
                toastr.success('Operasi berhasil dilakukan!', 'Sukses');
            }
        }
    });
");
?>