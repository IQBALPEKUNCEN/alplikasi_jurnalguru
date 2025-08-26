<?php
// ===== FILE: views/historykelas/index.php (Versi Diperbaiki) =====

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

$this->title = 'Pengumuman Kelas (Telegram)';
$this->params['breadcrumbs'][] = $this->title;

// Pastikan jQuery ter-load
\yii\web\JqueryAsset::register($this);

// Custom CSS untuk tampilan yang menarik
$css = <<<CSS
.pengumuman-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 15px;
    color: white;
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
}

.pengumuman-header h1 {
    margin: 0;
    font-weight: 700;
    font-size: 2.5rem;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.pengumuman-header p {
    margin: 10px 0 0 0;
    font-size: 1.1rem;
    opacity: 0.9;
}

.action-buttons {
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    margin-bottom: 25px;
}

.btn-create {
    background: linear-gradient(45deg, #FF6B6B, #FF8E53);
    border: none;
    border-radius: 25px;
    padding: 12px 30px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
}

.btn-create:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 107, 107, 0.4);
    color: white;
}

.btn-massal {
    background: linear-gradient(45deg, #4ECDC4, #44A08D);
    border: none;
    border-radius: 25px;
    padding: 12px 30px;
    font-weight: 600;
    color: white;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(78, 205, 196, 0.3);
}

.btn-massal:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(78, 205, 196, 0.4);
    color: white;
}

.grid-container {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 25px rgba(0,0,0,0.1);
}

.kv-grid-table {
    border: none !important;
}

.kv-grid-table thead th {
    background: linear-gradient(45deg, #f8f9fa, #e9ecef);
    color: #495057;
    font-weight: 600;
    border: none;
    padding: 15px 10px;
    text-align: center;
}

.kv-grid-table tbody tr:hover {
    background: #f8f9ff;
    transition: all 0.2s ease;
}

.kv-grid-table tbody td {
    border: none;
    border-bottom: 1px solid #f1f3f4;
    padding: 12px 10px;
    vertical-align: middle;
}

.badge-terkirim {
    background: linear-gradient(45deg, #28a745, #20c997);
    color: white;
    padding: 6px 15px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 500;
}

.badge-belum-kirim {
    background: linear-gradient(45deg, #ffc107, #fd7e14);
    color: white;
    padding: 6px 15px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 500;
}

.btn-telegram {
    border-radius: 20px;
    padding: 8px 16px;
    font-size: 0.85rem;
    font-weight: 500;
    transition: all 0.3s ease;
    border: none;
}

.btn-telegram:not([disabled]):hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}

.modal-content {
    border: none;
    border-radius: 20px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.3);
}

.modal-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 20px 20px 0 0;
    padding: 20px 30px;
}

.modal-title {
    font-weight: 700;
    font-size: 1.3rem;
}

.modal-body {
    padding: 30px;
}

.loading-spinner {
    text-align: center;
    padding: 40px;
    color: #6c757d;
}

.loading-spinner i {
    color: #667eea;
    margin-bottom: 15px;
}

.stats-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    border-left: 4px solid #667eea;
}

.stats-number {
    font-size: 2rem;
    font-weight: 700;
    color: #667eea;
    margin: 0;
}

.stats-label {
    color: #6c757d;
    font-size: 0.9rem;
    margin: 0;
}

@media (max-width: 768px) {
    .pengumuman-header {
        padding: 20px;
        text-align: center;
    }
    
    .pengumuman-header h1 {
        font-size: 1.8rem;
    }
    
    .action-buttons {
        text-align: center;
    }
    
    .btn-create, .btn-massal {
        margin: 5px;
        width: 100%;
    }
}

.fade-in {
    animation: fadeIn 0.5s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
CSS;

$this->registerCss($css);
?>

<div class="historykelas-index fade-in">
    <!-- Header Section yang Menarik -->
    <div class="pengumuman-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1><i class="fas fa-bullhorn"></i> <?= Html::encode($this->title) ?></h1>
                <p><i class="fas fa-info-circle"></i> Kelola dan kirim pengumuman kelas melalui Telegram dengan mudah</p>
            </div>
            <div class="col-md-4 text-right">
                <div class="stats-card d-inline-block">
                    <p class="stats-number"><?= $dataProvider->totalCount ?? 0 ?></p>
                    <p class="stats-label">Total Pengumuman</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons Section -->
    <div class="action-buttons">
        <div class="row">
            <div class="col-md-6">
                <?= Html::a(
                    '<i class="fas fa-plus-circle"></i> Buat Pengumuman Baru',
                    ['create'],
                    ['class' => 'btn btn-create btn-lg']
                ) ?>
            </div>
            <!-- <div class="col-md-6 text-right">
                <?= Html::button('<i class="fas fa-paper-plane"></i> Kirim Massal', [
                    'class' => 'btn btn-massal btn-lg',
                    'data-toggle' => 'modal',
                    'data-target' => '#kirim-massal-modal',
                    'id' => 'btn-kirim-massal'
                ]) ?>
            </div> -->
        </div>
    </div>

    <!-- Grid Section dengan Styling Menarik -->
    <div class="grid-container">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{items}\n{pager}",
            'tableOptions' => ['class' => 'table table-hover'],
            'headerRowOptions' => ['class' => 'text-center'],
            'columns' => [
                [
                    'class' => 'yii\grid\SerialColumn',
                    'headerOptions' => ['style' => 'width: 60px;'],
                ],
                [
                    'attribute' => 'judul_pengumuman',
                    'label' => 'Judul Pengumuman',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return '<strong style="color: #495057;">' . Html::encode($model->judul_pengumuman) . '</strong>';
                    }
                ],
                [
                    'attribute' => 'isi_pengumuman',
                    'label' => 'Isi Pengumuman',
                    'format' => 'raw',
                    'value' => function ($model) {
                        $content = strlen($model->isi_pengumuman) > 100
                            ? substr($model->isi_pengumuman, 0, 100) . '...'
                            : $model->isi_pengumuman;
                        return '<div style="color: #6c757d; line-height: 1.4;">' . Html::encode($content) . '</div>';
                    }
                ],
                [
                    'attribute' => 'kode_kelas',
                    'label' => 'Kelas',
                    'format' => 'raw',
                    'value' => function ($model) {
                        $kelas = $model->kodeKelas ? $model->kodeKelas->kode_kelas : '-';
                        return '<span class="badge badge-info" style="font-size: 0.9rem; padding: 6px 12px;">' . $kelas . '</span>';
                    },
                    'headerOptions' => ['style' => 'width: 120px;'],
                ],
                [
                    'attribute' => 'tanggal_pengumuman',
                    'label' => 'Tanggal',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return '<i class="fas fa-calendar-alt text-muted"></i> ' .
                            date('d/m/Y', strtotime($model->tanggal_pengumuman));
                    },
                    'headerOptions' => ['style' => 'width: 130px;'],
                ],
                [
                    'attribute' => 'status_kirim',
                    'label' => 'Status',
                    'format' => 'raw',
                    'value' => function ($model) {
                        if (method_exists($model, 'getStatusLabel')) {
                            return $model->getStatusLabel();
                        } else {
                            $status = $model->status_kirim ?? 'belum_kirim';
                            $class = $status == 'terkirim' ? 'badge-terkirim' : 'badge-belum-kirim';
                            $icon = $status == 'terkirim' ? 'fas fa-check-circle' : 'fas fa-clock';
                            $text = $status == 'terkirim' ? 'Terkirim' : 'Belum Kirim';
                            return "<span class='{$class}'><i class='{$icon}'></i> {$text}</span>";
                        }
                    },
                    'headerOptions' => ['style' => 'width: 130px;'],
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => 'Aksi',
                    'headerOptions' => ['style' => 'width: 180px;'],
                    'template' => '{view} {update} {delete} {telegram}',
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return Html::a('<i class="fas fa-eye"></i>', $url, [
                                'class' => 'btn btn-info btn-sm',
                                'title' => 'Lihat Detail',
                                'style' => 'margin: 2px;'
                            ]);
                        },
                        'update' => function ($url, $model) {
                            return Html::a('<i class="fas fa-edit"></i>', $url, [
                                'class' => 'btn btn-warning btn-sm',
                                'title' => 'Edit',
                                'style' => 'margin: 2px;'
                            ]);
                        },
                        'delete' => function ($url, $model) {
                            return Html::a('<i class="fas fa-trash"></i>', $url, [
                                'class' => 'btn btn-danger btn-sm',
                                'title' => 'Hapus',
                                'style' => 'margin: 2px;',
                                'data-confirm' => 'Apakah Anda yakin ingin menghapus pengumuman ini?',
                                'data-method' => 'post',
                            ]);
                        },
                        'telegram' => function ($url, $model) {
                            if ($model->status_kirim == 'terkirim') {
                                return Html::button(
                                    '<i class="fas fa-check"></i> Terkirim',
                                    [
                                        'class' => 'btn btn-secondary btn-sm btn-telegram',
                                        'disabled' => true,
                                        'style' => 'margin: 2px;'
                                    ]
                                );
                            } else {
                                return Html::button(
                                    '<i class="fab fa-telegram"></i> Kirim',
                                    [
                                        'class' => 'btn btn-success btn-sm btn-telegram',
                                        'data-id' => $model->history_id,
                                        'onclick' => "quickSendTelegram({$model->history_id})",
                                        'style' => 'margin: 2px;'
                                    ]
                                );
                            }
                        }
                    ]
                ]
            ],
        ]); ?>
    </div>
</div>

<!-- Modal Kirim Massal dengan Desain Menarik -->
<div class="modal fade" id="kirim-massal-modal" tabindex="-1" role="dialog" aria-labelledby="massalModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="massalModalLabel">
                    <i class="fas fa-paper-plane"></i> Kirim Pengumuman Massal
                </h4>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="pengumuman-massal-list">
                <div class="loading-spinner">
                    <i class="fas fa-spinner fa-spin fa-2x"></i>
                    <p>Memuat daftar pengumuman...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success btn-lg" id="confirm-kirim-massal">
                    <i class="fas fa-paper-plane"></i> Kirim Terpilih
                </button>
                <button type="button" class="btn btn-secondary btn-lg" data-dismiss="modal">
                    <i class="fas fa-times"></i> Batal
                </button>
            </div>
        </div>
    </div>
</div>

<?php
$sendUrl = Url::to(['send-telegram']);
$massalUrl = Url::to(['kirim-massal-telegram']);
$loadMassalUrl = Url::to(['load-pengumuman-massal']);

$script = <<<JS
$(document).ready(function() {
    
    // === Quick Send Telegram dengan Animasi ===
    window.quickSendTelegram = function(historyId) {
        Swal.fire({
            title: 'Konfirmasi Pengiriman',
            text: 'Apakah Anda yakin ingin mengirim pengumuman ini via Telegram?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#dc3545',
            confirmButtonText: '<i class="fas fa-paper-plane"></i> Ya, Kirim!',
            cancelButtonText: '<i class="fas fa-times"></i> Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Disable button dengan animasi
                var btn = $('button[data-id="' + historyId + '"]');
                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Mengirim...');

                $.ajax({
                    url: '$sendUrl',
                    type: 'POST',
                    data: {
                        history_id: historyId,
                        '_csrf': $('meta[name=csrf-token]').attr("content") || yii.getCsrfToken()
                    },
                    dataType: 'json',
                    success: function(res) {
                        if(res.success) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: res.message,
                                icon: 'success',
                                confirmButtonColor: '#28a745'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'Gagal!',
                                text: res.message,
                                icon: 'error',
                                confirmButtonColor: '#dc3545'
                            });
                            btn.prop('disabled', false).html('<i class="fab fa-telegram"></i> Kirim');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', xhr.responseText);
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan: ' + error,
                            icon: 'error',
                            confirmButtonColor: '#dc3545'
                        });
                        btn.prop('disabled', false).html('<i class="fab fa-telegram"></i> Kirim');
                    }
                });
            }
        });
    };

    // === Load daftar pengumuman massal ===
    $('#kirim-massal-modal').on('show.bs.modal show.modal', function() {
        $('#pengumuman-massal-list').html(`
            <div class="loading-spinner">
                <i class="fas fa-spinner fa-spin fa-2x"></i>
                <p>Memuat daftar pengumuman...</p>
            </div>
        `);

        $.ajax({
            url: '$loadMassalUrl',
            type: 'GET',
            success: function(data) {
                $('#pengumuman-massal-list').fadeOut(200, function() {
                    $(this).html(data).fadeIn(300);
                });
            },
            error: function(xhr, status, error) {
                console.error('Load Massal Error:', xhr.responseText);
                $('#pengumuman-massal-list').html(`
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Error!</strong> Gagal memuat daftar pengumuman.
                        <br>Detail: ` + error + `
                    </div>
                `);
            }
        });
    });

    // === Konfirmasi kirim massal dengan SweetAlert2 ===
    $('#confirm-kirim-massal').click(function() {
        var selected = $('input[name="pengumuman_terpilih[]"]:checked');
        
        if(selected.length === 0) {
            Swal.fire({
                title: 'Peringatan!',
                text: 'Pilih minimal satu pengumuman untuk dikirim',
                icon: 'warning',
                confirmButtonColor: '#ffc107'
            });
            return;
        }

        Swal.fire({
            title: 'Konfirmasi Kirim Massal',
            text: 'Apakah Anda yakin ingin mengirim ' + selected.length + ' pengumuman terpilih?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#dc3545',
            confirmButtonText: '<i class="fas fa-paper-plane"></i> Ya, Kirim Semua!',
            cancelButtonText: '<i class="fas fa-times"></i> Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                var ids = [];
                selected.each(function() {
                    ids.push($(this).val());
                });

                // Disable button dengan animasi
                $('#confirm-kirim-massal').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Mengirim...');

                $.ajax({
                    url: '$massalUrl',
                    type: 'POST',
                    data: {
                        pengumuman_ids: ids,
                        '_csrf': $('meta[name=csrf-token]').attr("content") || yii.getCsrfToken()
                    },
                    dataType: 'json',
                    success: function(res) {
                        if(res.success) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: res.message,
                                icon: 'success',
                                confirmButtonColor: '#28a745'
                            }).then(() => {
                                $('#kirim-massal-modal').modal('hide');
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'Gagal!',
                                text: res.message,
                                icon: 'error',
                                confirmButtonColor: '#dc3545'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Kirim Massal Error:', xhr.responseText);
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan: ' + error,
                            icon: 'error',
                            confirmButtonColor: '#dc3545'
                        });
                    },
                    complete: function() {
                        $('#confirm-kirim-massal').prop('disabled', false).html('<i class="fas fa-paper-plane"></i> Kirim Terpilih');
                    }
                });
            }
        });
    });

    // === Select All checkbox functionality ===
    $(document).on('change', '#select-all-pengumuman', function() {
        $('input[name="pengumuman_terpilih[]"]').prop('checked', $(this).is(':checked'));
    });

    // === Update select all when individual checkboxes change ===
    $(document).on('change', 'input[name="pengumuman_terpilih[]"]', function() {
        var total = $('input[name="pengumuman_terpilih[]"]').length;
        var checked = $('input[name="pengumuman_terpilih[]"]:checked').length;
        $('#select-all-pengumuman').prop('checked', total === checked);
    });

    // === Smooth scroll animation untuk elemen baru ===
    $('.grid-container').addClass('fade-in');
});
JS;

$this->registerJs($script);
?>

<?php
// Register SweetAlert2 untuk notifikasi yang lebih menarik (opsional)
// $this->registerJsFile('https://cdn.jsdelivr.net/npm/sweetalert2@11', ['position' => \yii\web\View::POS_HEAD]);
// Register FontAwesome untuk ikon (opsional)  
// $this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js', ['position' => \yii\web\View::POS_HEAD]);

// Atau gunakan CDN langsung di HTML jika diperlukan:
echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">';
echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
?>