<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\JurnalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Jurnal Pembelajaran';
$this->params['breadcrumbs'][] = $this->title;

// Mendapatkan informasi user yang login
$currentUser = Yii::$app->user->identity;
$currentUserName = $currentUser ? $currentUser->username : 'Guest';
$currentUserRole = $currentUser ? $currentUser->role : 'guest';

// CSS tambahan untuk menyamakan dengan halaman form
$this->registerCss("
    .card {
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        border: none;
        border-radius: 8px;
    }
    
    .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 8px 8px 0 0;
    }
    
    .btn-success {
        background: linear-gradient(135deg, #56ccf2 0%, #2f80ed 100%);
        border: none;
    }
    
    .btn-info {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
    }
    
    .btn-warning {
        background: linear-gradient(135deg, #ffeaa7 0%, #fdcb6e 100%);
        border: none;
        color: #2d3436;
    }
    
    .btn-danger {
        background: linear-gradient(135deg, #fd79a8 0%, #e84393 100%);
        border: none;
    }
    
    .btn-secondary {
        background: linear-gradient(135deg, #a8a8a8 0%, #7b7b7b 100%);
        border: none;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        transition: all 0.3s ease;
    }
    
    .action-buttons {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }
    
    .action-buttons .btn {
        border-radius: 25px;
        padding: 10px 20px;
        font-weight: 600;
    }
    
    .kv-grid-table {
        border-radius: 8px;
        overflow: hidden;
    }
    
    .kv-panel-primary > .panel-heading {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        font-weight: 600;
    }
    
    .status-badge {
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
    }
    
    .status-hadir {
        background: linear-gradient(135deg, #00b894 0%, #00a085 100%);
        color: white;
    }
    
    .status-tidak-hadir {
        background: linear-gradient(135deg, #e17055 0%, #d63031 100%);
        color: white;
    }
    
    .status-izin {
        background: linear-gradient(135deg, #fdcb6e 0%, #e17055 100%);
        color: white;
    }
    
    .status-sakit {
        background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
        color: white;
    }
    
    .status-ALPA {
        background: linear-gradient(135deg, #636e72 0%, #2d3436 100%);
        color: white;
    }
    
    .grid-action-buttons {
        display: flex;
        gap: 5px;
        justify-content: center;
    }
    
    .grid-action-buttons .btn {
        padding: 5px 10px;
        font-size: 12px;
        border-radius: 15px;
    }
    
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }
    
    .page-header h1 {
        margin: 0;
        color: white;
        font-weight: 300;
    }
    
    .user-info {
        background: linear-gradient(135deg, #00b894 0%, #00a085 100%);
        color: white;
        padding: 10px 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .user-info .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }
    
    .stats-card {
        background: linear-gradient(135deg, #ffeaa7 0%, #fdcb6e 100%);
        border-radius: 8px;
        padding: 15px;
        color: #2d3436;
        margin-bottom: 20px;
    }
    
    .filter-section {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }
");

// JavaScript untuk interaksi tambahan
$this->registerJs("
    // Konfirmasi hapus
    $(document).on('click', '.delete-btn', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        
        if (confirm('Apakah Anda yakin ingin menghapus data jurnal ini?')) {
            window.location.href = url;
        }
    });
    
    // Loading state untuk tombol aksi
    $(document).on('click', '.btn-action', function() {
        var btn = $(this);
        var originalText = btn.html();
        
        btn.html('<i class=\"fas fa-spinner fa-spin\"></i> Loading...');
        btn.prop('disabled', true);
        
        // Restore setelah 2 detik (adjust sesuai kebutuhan)
        setTimeout(function() {
            btn.html(originalText);
            btn.prop('disabled', false);
        }, 2000);
    });
    
    // Auto refresh setiap 5 menit
    setInterval(function() {
        // Reload halaman untuk data terbaru
        if (document.hidden === false) {
            $('.kv-grid-container').trigger('refresh');
        }
    }, 300000); // 5 menit
    
    // Update real-time user info
    function updateUserInfo() {
        $('.user-greeting').text('Selamat " . (date('H') < 12 ? 'Pagi' : (date('H') < 15 ? 'Siang' : (date('H') < 18 ? 'Sore' : 'Malam'))) . ", " . $currentUserName . "!');
    }
    
    updateUserInfo();
");
?>

<div class="jurnal-index">
    <div class="container-fluid">

        <!-- User Info Section -->
        <div class="user-info">
            <div class="user-avatar">
                <i class="fas fa-user"></i>
            </div>
            <div class="user-details">
                <h6 class="mb-0 user-greeting">Selamat <?= date('H') < 12 ? 'Pagi' : (date('H') < 15 ? 'Siang' : (date('H') < 18 ? 'Sore' : 'Malam')) ?>, <?= Html::encode($currentUserName) ?>!</h6>
                <small>Role: <?= Html::encode(ucfirst($currentUserRole)) ?> | Login: <?= date('d/m/Y H:i') ?></small>
            </div>
        </div>

        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1>
                        <i class="fas fa-book-open"></i>
                        <?= Html::encode($this->title) ?>
                    </h1>
                    <p class="mb-0">Kelola data jurnal pembelajaran harian - <?= Html::encode($currentUserName) ?></p>
                </div>
                <div class="text-right">
                    <small>Total Data: <strong id="total-records"><?= $dataProvider->totalCount ?></strong></small><br>
                    <small>Terakhir Update: <strong><?= date('d/m/Y H:i') ?></strong></small>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <?= Html::a(
                '<i class="fas fa-plus-circle"></i> Tambah Jurnal Baru',
                ['create'],
                [
                    'class' => 'btn btn-success btn-action',
                    'title' => 'Buat jurnal pembelajaran baru'
                ]
            ) ?>
            <?= Html::a(
                '<i class="fas fa-sync-alt"></i> Refresh',
                ['index'],
                [
                    'class' => 'btn btn-secondary btn-action',
                    'title' => 'Muat ulang data'
                ]
            ) ?>
        </div>

        <!-- Data Grid -->
        <div class="card">
            <div class="card-body p-0">
                <?php
                $gridColumn = [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'header' => 'No.',
                        'headerOptions' => ['style' => 'width:60px; text-align:center'],
                        'contentOptions' => ['style' => 'text-align:center; vertical-align:middle']
                    ],
                    [
                        'attribute' => 'jurnal_id',
                        'label' => 'ID',
                        'headerOptions' => ['style' => 'width:80px; text-align:center'],
                        'contentOptions' => ['style' => 'text-align:center; vertical-align:middle'],
                        'value' => function ($model) {
                            return '<span class="badge badge-secondary">' . $model->jurnal_id . '</span>';
                        },
                        'format' => 'raw'
                    ],
                    [
                        'attribute' => 'guru_id',
                        'label' => 'Guru',
                        'value' => function ($model) {
                            $namaGuru = 'N/A';
                            if (isset($model->guru) && $model->guru) {
                                $namaGuru = $model->guru->nama;
                            }
                            return '<div style="min-width:120px"><i class="fas fa-user-tie text-primary"></i> ' . $namaGuru . '</div>';
                        },
                        'format' => 'raw',
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => \yii\helpers\ArrayHelper::map(
                            \app\models\base\Guru::find()->orderBy('nama')->asArray()->all(),
                            'guru_id',
                            'nama'
                        ),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Pilih Guru'],
                    ],
                    [
                        'attribute' => 'kodeta',
                        'label' => 'Tahun Ajaran',
                        'value' => function ($model) {
                            $tahunAjaran = 'N/A';
                            if (isset($model->kodeta0) && $model->kodeta0) {
                                $tahunAjaran = $model->kodeta0->namata;
                            } elseif ($model->kodeta) {
                                $tahunAjaran = $model->kodeta;
                            }
                            return '<div style="min-width:100px"><i class="fas fa-calendar-alt text-info"></i> ' . $tahunAjaran . '</div>';
                        },
                        'format' => 'raw',
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => \yii\helpers\ArrayHelper::map(
                            \app\models\base\Tahunajaran::find()->orderBy('namata')->asArray()->all(),
                            'kodeta',
                            'namata'
                        ),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Pilih Tahun Ajaran'],
                    ],
                    [
                        'attribute' => 'tanggal',
                        'label' => 'Tanggal',
                        'format' => 'raw',
                        'value' => function ($model) {
                            if (!empty($model->tanggal)) {
                                $tanggal = Yii::$app->formatter->asDate($model->tanggal, 'php:d-m-Y');
                                $hari = date('l', strtotime($model->tanggal));
                                $hariIndo = [
                                    'Monday' => 'Senin',
                                    'Tuesday' => 'Selasa',
                                    'Wednesday' => 'Rabu',
                                    'Thursday' => 'Kamis',
                                    'Friday' => 'Jumat',
                                    'Saturday' => 'Sabtu',
                                    'Sunday' => 'Minggu'
                                ];
                                return '<div style="min-width:100px">
                                    <i class="fas fa-calendar text-success"></i> ' . $tanggal . '<br>
                                    <small class="text-muted">' . ($hariIndo[$hari] ?? $hari) . '</small>
                                </div>';
                            }
                            return '<span class="text-muted">N/A</span>';
                        },
                        'filter' => DatePicker::widget([
                            'model' => $searchModel,
                            'attribute' => 'tanggal',
                            'options' => ['placeholder' => 'Pilih Tanggal'],
                            'pluginOptions' => [
                                'format' => 'yyyy-mm-dd',
                                'todayHighlight' => true,
                                'autoclose' => true,
                            ]
                        ]),
                        'headerOptions' => ['style' => 'width:120px']
                    ],
                    [
                        'attribute' => 'hari_id',
                        'label' => 'Hari',
                        'value' => function ($model) {
                            $hari = 'N/A';
                            if (isset($model->hari) && $model->hari) {
                                $hari = $model->hari->nama;
                            }
                            return '<span class="badge badge-light"><i class="far fa-clock"></i> ' . $hari . '</span>';
                        },
                        'format' => 'raw',
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => \yii\helpers\ArrayHelper::map(
                            \app\models\base\Hari::find()->orderBy('nama')->asArray()->all(),
                            'hari_id',
                            'nama'
                        ),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Pilih Hari'],
                        'headerOptions' => ['style' => 'width:100px']
                    ],
                    [
                        'attribute' => 'jam_ke',
                        'label' => 'Jam Ke',
                        'value' => function ($model) {
                            return '<div class="text-center">
                                <span class="badge badge-primary" style="font-size:14px">' . ($model->jam_ke ?: '-') . '</span>
                            </div>';
                        },
                        'format' => 'raw',
                        'headerOptions' => ['style' => 'width:80px; text-align:center'],
                        'contentOptions' => ['style' => 'text-align:center; vertical-align:middle']
                    ],
                    [
                        'attribute' => 'kode_kelas',
                        'label' => 'Kelas',
                        'value' => function ($model) {
                            $kelas = 'N/A';
                            if (isset($model->kodeKelas) && $model->kodeKelas) {
                                $kelas = $model->kodeKelas->nama;
                            } elseif ($model->kode_kelas) {
                                $kelas = $model->kode_kelas;
                            }
                            return '<div style="min-width:80px"><i class="fas fa-users text-warning"></i> ' . $kelas . '</div>';
                        },
                        'format' => 'raw',
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => \yii\helpers\ArrayHelper::map(
                            \app\models\base\Kelas::find()->orderBy('nama')->asArray()->all(),
                            'kode_kelas',
                            'nama'
                        ),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Pilih Kelas'],
                    ],
                    [
                        'attribute' => 'materi',
                        'label' => 'Materi',
                        'value' => function ($model) {
                            $materi = $model->materi ?: 'Belum diisi';
                            if (strlen($materi) > 50) {
                                $materi = substr($materi, 0, 47) . '...';
                            }
                            return '<div style="min-width:150px; max-width:200px">
                                <i class="fas fa-book text-info"></i> ' . $materi . '
                            </div>';
                        },
                        'format' => 'raw',
                        'headerOptions' => ['style' => 'width:200px']
                    ],
                    [
                        'attribute' => 'status',
                        'label' => 'Status',
                        'value' => function ($model) {
                            if (!empty($model->status)) {
                                $status = strtoupper($model->status);
                                switch ($status) {
                                    case 'HADIR':
                                        return '<span class="status-badge status-hadir"><i class="fas fa-check"></i> HADIR</span>';
                                    case 'TIDAKH ADIR':
                                        return '<span class="status-badge status-tidak-hadir"><i class="fas fa-times"></i> TIDAK HADIR</span>';
                                    case 'IZIN':
                                        return '<span class="status-badge status-izin"><i class="fas fa-exclamation"></i> IZIN</span>';
                                    case 'SAKIT':
                                        return '<span class="status-badge status-sakit"><i class="fas fa-thermometer-half"></i> SAKIT</span>';
                                    case 'ALPA':
                                        return '<span class="status-badge status-alpa"><i class="fas fa-user-slash"></i> ALPA</span>';
                                    default:
                                        return '<span class="status-badge" style="background:#636e72; color:white">' . $model->status . '</span>';
                                }
                            }
                            return '<span class="text-muted">N/A</span>';
                        },
                        'format' => 'raw',
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => [
                            'HADIR' => 'HADIR',
                            'TIDAK HADIR' => 'TIDAK HADIR',
                            'IZIN' => 'IZIN',
                            'SAKIT' => 'SAKIT',
                            'ALPA' => 'ALPA'
                        ],
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Pilih Status'],
                        'headerOptions' => ['style' => 'width:120px']
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => 'Aksi',
                        'headerOptions' => ['style' => 'width:120px; text-align:center'],
                        'contentOptions' => ['style' => 'text-align:center; vertical-align:middle'],
                        'template' => '{view} {update} {delete}',
                        'buttons' => [
                            'view' => function ($url, $model, $key) {
                                return Html::a(
                                    '<i class="fas fa-eye"></i>',
                                    $url,
                                    [
                                        'class' => 'btn btn-info btn-sm',
                                        'title' => 'Lihat Detail',
                                        'style' => 'margin:2px'
                                    ]
                                );
                            },
                            'update' => function ($url, $model, $key) {
                                return Html::a(
                                    '<i class="fas fa-edit"></i>',
                                    $url,
                                    [
                                        'class' => 'btn btn-warning btn-sm',
                                        'title' => 'Edit Jurnal',
                                        'style' => 'margin:2px'
                                    ]
                                );
                            },
                            'delete' => function ($url, $model, $key) {
                                return Html::a(
                                    '<i class="fas fa-trash"></i>',
                                    $url,
                                    [
                                        'class' => 'btn btn-danger btn-sm delete-btn',
                                        'title' => 'Hapus Jurnal',
                                        'style' => 'margin:2px',
                                        'data-confirm' => 'Apakah Anda yakin ingin menghapus jurnal ini?',
                                        'data-method' => 'post'
                                    ]
                                );
                            },
                        ],
                        // Bagian untuk mengatur visibility tombol update dan delete
                        // Ganti bagian 'visibleButtons' dalam ActionColumn dengan kode berikut:

                        'visibleButtons' => [
                            'update' => function ($model, $key, $index) {
                                $currentUser = Yii::$app->user->identity;
                                if (!$currentUser) return false;

                                // Jika admin, bisa edit semua
                                if ($currentUser->role === 'admin') {
                                    return true;
                                }

                                // Jika guru, cek berdasarkan username atau user_id
                                if ($currentUser->role === 'guru') {
                                    // Opsi 1: Jika ada relasi guru dengan user
                                    if (isset($model->guru) && $model->guru && isset($model->guru->user_id)) {
                                        return $model->guru->user_id === $currentUser->id;
                                    }

                                    // Opsi 2: Jika menggunakan username langsung
                                    if (isset($model->guru) && $model->guru && isset($model->guru->username)) {
                                        return $model->guru->username === $currentUser->username;
                                    }

                                    // Opsi 3: Jika ada field created_by atau user_id di tabel jurnal
                                    if (isset($model->created_by)) {
                                        return $model->created_by === $currentUser->id;
                                    }

                                    // Opsi 4: Jika ada field username di tabel jurnal
                                    if (isset($model->username)) {
                                        return $model->username === $currentUser->username;
                                    }
                                }

                                return false;
                            },
                            'delete' => function ($model, $key, $index) {
                                $currentUser = Yii::$app->user->identity;
                                if (!$currentUser) return false;

                                // Jika admin, bisa hapus semua
                                if ($currentUser->role === 'admin') {
                                    return true;
                                }

                                // Jika guru, cek berdasarkan username atau user_id
                                if ($currentUser->role === 'guru') {
                                    // Opsi 1: Jika ada relasi guru dengan user
                                    if (isset($model->guru) && $model->guru && isset($model->guru->user_id)) {
                                        return $model->guru->user_id === $currentUser->id;
                                    }

                                    // Opsi 2: Jika menggunakan username langsung
                                    if (isset($model->guru) && $model->guru && isset($model->guru->username)) {
                                        return $model->guru->username === $currentUser->username;
                                    }

                                    // Opsi 3: Jika ada field created_by atau user_id di tabel jurnal
                                    if (isset($model->created_by)) {
                                        return $model->created_by === $currentUser->id;
                                    }

                                    // Opsi 4: Jika ada field username di tabel jurnal
                                    if (isset($model->username)) {
                                        return $model->username === $currentUser->username;
                                    }
                                }

                                return false;
                            }
                        ]
                    ],
                ];

                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => $gridColumn,
                    'condensed' => true,
                    'hover' => true,
                    'striped' => true,
                    'bordered' => false,
                    'responsive' => true,
                    'responsiveWrap' => false,
                    'panel' => [
                        'type' => GridView::TYPE_PRIMARY,
                        'heading' => '<i class="fas fa-table"></i> Data Jurnal Pembelajaran - ' . Html::encode($currentUserName),
                        'headingOptions' => ['style' => 'background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; font-weight: 600;'],
                        'footer' => false
                    ],
                    'toolbar' => [
                        [
                            'content' =>
                            Html::a('<i class="fas fa-plus"></i> Tambah Baru', ['create'], [
                                'class' => 'btn btn-success btn-sm',
                                'title' => 'Tambah Jurnal Baru'
                            ]) . ' ' .
                                Html::a('<i class="fas fa-sync-alt"></i>', ['index'], [
                                    'class' => 'btn btn-secondary btn-sm',
                                    'title' => 'Refresh Data'
                                ]),
                            'options' => ['class' => 'btn-group mr-2']
                        ],
                        '{export}',
                        '{toggleData}'
                    ],
                    'toggleDataContainer' => ['class' => 'btn-group mr-2 btn-group-sm'],
                    'exportContainer' => ['class' => 'btn-group mr-2 btn-group-sm'],
                    'export' => [
                        'fontAwesome' => true,
                        'showConfirmAlert' => false,
                        'target' => GridView::TARGET_BLANK
                    ],
                    'pjax' => true,
                    'pjaxSettings' => [
                        'options' => [
                            'enablePushState' => false,
                            'id' => 'jurnal-grid-pjax'
                        ]
                    ]
                ]);
                ?>
            </div>
        </div>
    </div>
</div>

<!-- Loading Modal -->
<div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <p class="mt-2">Memuat data...</p>
            </div>
        </div>
    </div>
</div>