<?php
// File: views/historykelas/_form.php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\base\Historykelas */
/* @var $form kartik\form\ActiveForm */
?>

<div class="pengumuman-form">
    <div class="card shadow-lg">
        <div class="card-header bg-gradient-telegram text-white">
            <h3 class="card-title mb-0">
                <i class="fab fa-telegram pulse-icon"></i>
                Form Pengumuman Kelas (Telegram)
            </h3>
        </div>
        <div class="card-body bg-light">
            <?php $form = ActiveForm::begin([
                'id' => 'pengumuman-form',
                'type' => ActiveForm::TYPE_HORIZONTAL,
                'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL]
            ]); ?>

            <?= $form->errorSummary($model, ['class' => 'alert alert-danger fade-in']); ?>

            <div class="form-section">
                <h5 class="section-title">
                    <i class="fas fa-edit text-primary"></i> Informasi Dasar
                </h5>

                <?= $form->field($model, 'judul_pengumuman')->textInput([
                    'placeholder' => 'Masukkan judul pengumuman yang menarik...',
                    'maxlength' => true,
                    'class' => 'form-control form-control-lg'
                ])->label('Judul Pengumuman <span class="text-danger">*</span>') ?>

                <?= $form->field($model, 'isi_pengumuman')->textarea([
                    'rows' => 6,
                    'placeholder' => 'Tulis isi pengumuman dengan jelas dan informatif...',
                    'class' => 'form-control'
                ])->label('Isi Pengumuman <span class="text-danger">*</span>') ?>
            </div>

            <div class="form-section">
                <h5 class="section-title">
                    <i class="fas fa-calendar-alt text-info"></i> Jadwal & Target
                </h5>

                <?= $form->field($model, 'tanggal_pengumuman')->widget(DatePicker::classname(), [
                    'options' => [
                        'placeholder' => 'Pilih tanggal pengumuman',
                        'class' => 'form-control'
                    ],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true,
                        'startDate' => date('Y-m-d'),
                        'orientation' => 'bottom auto'
                    ]
                ])->label('Tanggal Pengumuman') ?>

                <?= $form->field($model, 'kodeta')->widget(Select2::classname(), [
                    'data' => \yii\helpers\ArrayHelper::map(
                        \app\models\base\Tahunajaran::find()->orderBy('kodeta DESC')->asArray()->all(),
                        'kodeta',
                        'kodeta'
                    ),
                    'options' => [
                        'placeholder' => 'Pilih Tahun Ajaran...',
                        'class' => 'form-control'
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'theme' => 'bootstrap4'
                    ],
                ])->label('Tahun Ajaran') ?>

                <?= $form->field($model, 'kode_kelas')->widget(Select2::classname(), [
                    'data' => \yii\helpers\ArrayHelper::map(
                        \app\models\base\Kelas::find()->orderBy('nama')->asArray()->all(),
                        'kode_kelas',
                        'nama'
                    ),
                    'options' => [
                        'placeholder' => 'Pilih Kelas Target...',
                        'id' => 'select-kelas',
                        'class' => 'form-control'
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'theme' => 'bootstrap4'
                    ],
                ])->label('Kelas Target <span class="text-danger">*</span>') ?>
            </div>

            <div class="form-section">
                <h5 class="section-title">
                    <i class="fas fa-exclamation-triangle text-warning"></i> Prioritas
                </h5>

                <?= $form->field($model, 'tingkat_prioritas')->widget(Select2::classname(), [
                    'data' => [
                        'rendah' => '📋 Rendah - Informasi Biasa',
                        'sedang' => '📢 Sedang - Perlu Perhatian',
                        'tinggi' => '⚠️ Tinggi - Penting Segera',
                        'mendesak' => '🚨 Mendesak - Sangat Penting'
                    ],
                    'options' => [
                        'placeholder' => 'Pilih tingkat prioritas...',
                        'class' => 'form-control'
                    ],
                    'pluginOptions' => [
                        'theme' => 'bootstrap4',
                        'allowClear' => false
                    ]
                ])->label('Tingkat Prioritas') ?>
            </div>

            <div class="form-actions mt-4">
                <div class="row">
                    <div class="col-sm-offset-3 col-sm-9">
                        <div class="btn-group-custom">
                            <?= Html::submitButton(
                                $model->isNewRecord ? '<i class="fas fa-plus-circle"></i> Buat Pengumuman' : '<i class="fas fa-edit"></i> Update Pengumuman',
                                [
                                    'class' => $model->isNewRecord ? 'btn btn-success btn-lg' : 'btn btn-primary btn-lg',
                                    'id' => 'btn-submit'
                                ]
                            ) ?>

                            <?php if (!$model->isNewRecord): ?>
                                <!-- <?= Html::button(
                                            '<i class="fab fa-telegram-plane"></i> Kirim ke Telegram',
                                            [
                                                'class' => 'btn btn-telegram btn-lg',
                                                'id' => 'btn-kirim-telegram'
                                            ]
                                        ) ?>

                                <?= Html::button(
                                    '<i class="fas fa-eye"></i> Preview',
                                    [
                                        'class' => 'btn btn-info btn-lg',
                                        'id' => 'btn-preview',
                                        'data-toggle' => 'modal',
                                        'data-target' => '#preview-modal'
                                    ]
                                ) ?>

                                <?= Html::button(
                                    '<i class="fas fa-robot"></i> Test Bot',
                                    [
                                        'class' => 'btn btn-secondary btn-lg',
                                        'id' => 'btn-test-bot',
                                        'title' => 'Test koneksi Telegram Bot'
                                    ]
                                ) ?> -->
                            <?php endif; ?>

                            <?= Html::a(
                                '<i class="fas fa-times-circle"></i> Batal',
                                Yii::$app->request->referrer ?: ['index'],
                                ['class' => 'btn btn-danger btn-lg']
                            ) ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<!-- Modal Preview -->
<div class="modal fade" id="preview-modal" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h4 class="modal-title" id="previewModalLabel">
                    <i class="fab fa-telegram"></i> Preview Pengumuman Telegram
                </h4>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="preview-content">
                <div class="text-center text-muted">
                    <i class="fas fa-file-alt fa-3x mb-3"></i>
                    <p>Preview akan muncul di sini setelah data diisi lengkap</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Kirim Telegram -->
<div class="modal fade" id="telegram-modal" tabindex="-1" role="dialog" aria-labelledby="telegramModalLabel">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-telegram text-white">
                <h4 class="modal-title" id="telegramModalLabel">
                    <i class="fab fa-telegram"></i> Kirim ke Telegram
                </h4>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info border-left-primary">
                    <div class="row">
                        <div class="col-md-1">
                            <i class="fab fa-telegram fa-2x"></i>
                        </div>
                        <div class="col-md-11">
                            <strong>Pengiriman via Telegram Bot</strong><br>
                            <small>Sistem akan mengirim pengumuman melalui Telegram Bot ke siswa yang dipilih. Pastikan siswa sudah terdaftar di bot.</small>
                        </div>
                    </div>
                </div>

                <div id="siswa-telegram-list">
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-users fa-2x mb-2"></i>
                        <p>Daftar siswa akan muncul di sini</p>
                    </div>
                </div>

                <div class="progress mt-3" id="progress-bar" style="display: none;">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-telegram"
                        role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                        <span class="progress-text">0%</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success btn-lg" id="confirm-kirim-telegram">
                    <i class="fas fa-paper-plane"></i> Ya, Kirim Sekarang
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Batal
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Test Bot -->
<div class="modal fade" id="test-bot-modal" tabindex="-1" role="dialog" aria-labelledby="testBotModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h4 class="modal-title" id="testBotModalLabel">
                    <i class="fas fa-robot"></i> Test Telegram Bot
                </h4>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="test-result" class="mb-4">
                    <div class="text-center text-muted">
                        <i class="fas fa-cog fa-2x mb-2"></i>
                        <p>Hasil test akan ditampilkan di sini</p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-paper-plane"></i> Test Kirim Pesan</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="test-telegram-id">Telegram ID untuk Test:</label>
                            <input type="text" class="form-control" id="test-telegram-id"
                                placeholder="Contoh: 123456789" pattern="[0-9]+">
                            <small class="form-text text-muted">
                                Masukkan Telegram ID (angka) untuk mengirim pesan test
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-test-connection">
                    <i class="fas fa-plug"></i> Test Koneksi
                </button>
                <button type="button" class="btn btn-success" id="btn-test-send">
                    <i class="fas fa-paper-plane"></i> Test Kirim
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        'use strict';

        // Form validation
        $('#pengumuman-form').on('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
                return false;
            }
        });

        function validateForm() {
            let isValid = true;
            const required = ['#historykelas-judul_pengumuman', '#historykelas-isi_pengumuman'];

            required.forEach(function(selector) {
                const $field = $(selector);
                if (!$field.val().trim()) {
                    $field.addClass('is-invalid');
                    isValid = false;
                } else {
                    $field.removeClass('is-invalid');
                }
            });

            if (!isValid) {
                showAlert('danger', 'Mohon isi semua field yang wajib diisi!');
            }

            return isValid;
        }

        // Real-time validation
        $('input, textarea, select').on('blur', function() {
            if ($(this).val().trim()) {
                $(this).removeClass('is-invalid').addClass('is-valid');
            }
        });

        // Preview pengumuman
        $('#btn-preview').click(function() {
            const data = getFormData();

            if (!data.judul || !data.isi) {
                showAlert('warning', 'Judul dan isi pengumuman harus diisi untuk preview!');
                return;
            }

            const prioritasInfo = getPriorityInfo(data.prioritas);
            const previewHtml = `
            <div class="telegram-preview">
                <div class="alert alert-${prioritasInfo.class} telegram-message">
                    <div class="telegram-content">
                        <div class="priority-badge mb-2">
                            <span class="badge badge-${prioritasInfo.class} badge-lg">
                                ${prioritasInfo.icon} ${prioritasInfo.text}
                            </span>
                        </div>
                        
                        <h5 class="telegram-title">${prioritasInfo.icon} PENGUMUMAN KELAS</h5>
                        
                        <div class="telegram-body">
                            <h6><strong>${data.judul}</strong></h6>
                            <p class="telegram-text">${data.isi.replace(/\n/g, '<br>')}</p>
                        </div>
                        
                        <div class="telegram-footer">
                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <small><i class="fas fa-calendar"></i> <strong>Tanggal:</strong> ${formatDate(data.tanggal)}</small>
                                </div>
                                <div class="col-6">
                                    <small><i class="fas fa-users"></i> <strong>Kelas:</strong> ${data.kelas}</small>
                                </div>
                            </div>
                            <div class="mt-2">
                                <em><i class="fas fa-robot"></i> Pesan ini dikirim secara otomatis dari Sistem Sekolah</em>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

            $('#preview-content').html(previewHtml);
        });

        // Kirim Telegram
        $('#btn-kirim-telegram').click(function() {
            const kelas = $('#historykelas-kode_kelas').val();
            if (!kelas) {
                showAlert('warning', 'Pilih kelas terlebih dahulu!');
                return;
            }

            loadSiswaData(kelas);
        });

        function loadSiswaData(kelas) {
            $.ajax({
                url: '<?= \yii\helpers\Url::to(['get-siswa-by-kelas']) ?>',
                data: {
                    kelas: kelas
                },
                beforeSend: function() {
                    $('#siswa-telegram-list').html(getLoadingHtml('Memuat daftar siswa...'));
                },
                success: function(data) {
                    if (typeof data === 'object' && !data.success) {
                        $('#siswa-telegram-list').html(`
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle"></i> ${data.message}
                        </div>
                    `);
                    } else {
                        $('#siswa-telegram-list').html(data);
                    }
                    $('#telegram-modal').modal('show');
                },
                error: function(xhr, status, error) {
                    $('#siswa-telegram-list').html(`
                    <div class="alert alert-danger">
                        <i class="fas fa-times-circle"></i> Gagal memuat daftar siswa: ${error}
                    </div>
                `);
                    $('#telegram-modal').modal('show');
                }
            });
        }

        // Konfirmasi kirim Telegram
        $('#confirm-kirim-telegram').click(function() {
            const selectedSiswa = $('input[name="siswa_terpilih[]"]:checked');
            if (selectedSiswa.length === 0) {
                showAlert('warning', 'Pilih minimal satu siswa untuk mengirim pengumuman!');
                return;
            }

            const siswaData = selectedSiswa.map(function() {
                return $(this).val();
            }).get();

            sendTelegramMessage(siswaData);
        });

        function sendTelegramMessage(siswaData) {
            const $btn = $('#confirm-kirim-telegram');
            const $progressBar = $('#progress-bar');

            $.ajax({
                url: '<?= \yii\helpers\Url::to(['kirim-telegram']) ?>',
                method: 'POST',
                data: {
                    history_id: <?= $model->history_id ?? 0 ?>,
                    siswa_terpilih: siswaData,
                    _csrf: $('meta[name=csrf-token]').attr('content')
                },
                beforeSend: function() {
                    $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Mengirim...');
                    $progressBar.show().find('.progress-bar').css('width', '0%');

                    // Simulate progress
                    let progress = 0;
                    const progressInterval = setInterval(function() {
                        progress += Math.random() * 30;
                        if (progress > 90) {
                            progress = 90;
                            clearInterval(progressInterval);
                        }
                        $progressBar.find('.progress-bar').css('width', progress + '%')
                            .find('.progress-text').text(Math.round(progress) + '%');
                    }, 300);
                },
                success: function(response) {
                    if (response.success) {
                        $('#progress-bar').find('.progress-bar').css('width', '100%')
                            .find('.progress-text').text('100%');

                        setTimeout(function() {
                            showAlert('success', `Pengumuman berhasil dikirim ke Telegram!\n\n${response.message}`);
                            $('#telegram-modal').modal('hide');
                            if (response.redirect) {
                                window.location.reload();
                            }
                        }, 500);
                    } else {
                        showAlert('danger', 'Gagal mengirim: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    showAlert('danger', 'Terjadi kesalahan saat mengirim pengumuman: ' + error);
                },
                complete: function() {
                    $btn.prop('disabled', false).html('<i class="fas fa-paper-plane"></i> Ya, Kirim Sekarang');
                    setTimeout(function() {
                        $('#progress-bar').hide();
                    }, 1000);
                }
            });
        }

        // Test Bot
        $('#btn-test-bot').click(function() {
            $('#test-bot-modal').modal('show');
            setTimeout(function() {
                $('#btn-test-connection').click();
            }, 300);
        });

        // Test koneksi bot
        $('#btn-test-connection').click(function() {
            const $btn = $(this);
            $.ajax({
                url: '<?= \yii\helpers\Url::to(['test-telegram']) ?>',
                beforeSend: function() {
                    $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Testing...');
                    $('#test-result').html(getLoadingHtml('Testing koneksi bot...'));
                },
                success: function(response) {
                    const alertClass = response.success ? 'success' : 'danger';
                    const icon = response.success ? 'check-circle' : 'times-circle';
                    const message = response.success ?
                        'Koneksi berhasil! Bot aktif dan siap digunakan.' :
                        'Koneksi gagal: ' + response.message;

                    $('#test-result').html(`
                    <div class="alert alert-${alertClass}">
                        <i class="fas fa-${icon}"></i> ${message}
                    </div>
                `);
                },
                error: function(xhr, status, error) {
                    $('#test-result').html(`
                    <div class="alert alert-danger">
                        <i class="fas fa-times-circle"></i> Error: ${error}
                    </div>
                `);
                },
                complete: function() {
                    $btn.prop('disabled', false).html('<i class="fas fa-plug"></i> Test Koneksi');
                }
            });
        });

        // Test kirim pesan
        $('#btn-test-send').click(function() {
            const telegramId = $('#test-telegram-id').val().trim();
            if (!telegramId) {
                showAlert('warning', 'Masukkan Telegram ID untuk test!');
                $('#test-telegram-id').focus();
                return;
            }

            if (!/^\d+$/.test(telegramId)) {
                showAlert('warning', 'Telegram ID harus berupa angka!');
                $('#test-telegram-id').focus();
                return;
            }

            const $btn = $(this);
            $.ajax({
                url: '<?= \yii\helpers\Url::to(['test-kirim-telegram']) ?>',
                method: 'POST',
                data: {
                    telegram_id: telegramId,
                    pesan: `🧪 Test pesan dari sistem pengumuman sekolah\n\nWaktu: ${new Date().toLocaleString('id-ID')}\n\n✅ Jika Anda menerima pesan ini, berarti bot berfungsi dengan baik!`,
                    _csrf: $('meta[name=csrf-token]').attr('content')
                },
                beforeSend: function() {
                    $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Mengirim...');
                },
                success: function(response) {
                    const alertClass = response.success ? 'success' : 'danger';
                    const message = response.success ?
                        'Test pesan berhasil dikirim!' :
                        'Gagal mengirim test pesan: ' + response.message;
                    showAlert(alertClass, message);
                },
                error: function(xhr, status, error) {
                    showAlert('danger', 'Error mengirim test pesan: ' + error);
                },
                complete: function() {
                    $btn.prop('disabled', false).html('<i class="fas fa-paper-plane"></i> Test Kirim');
                }
            });
        });

        // Helper functions
        function getFormData() {
            return {
                judul: $('#historykelas-judul_pengumuman').val().trim(),
                isi: $('#historykelas-isi_pengumuman').val().trim(),
                tanggal: $('#historykelas-tanggal_pengumuman').val(),
                kelas: $('#select-kelas option:selected').text(),
                prioritas: $('#historykelas-tingkat_prioritas').val()
            };
        }

        function getPriorityInfo(priority) {
            const priorities = {
                'mendesak': {
                    class: 'danger',
                    icon: '🚨',
                    text: 'MENDESAK'
                },
                'tinggi': {
                    class: 'warning',
                    icon: '⚠️',
                    text: 'TINGGI'
                },
                'sedang': {
                    class: 'info',
                    icon: '📢',
                    text: 'SEDANG'
                },
                'rendah': {
                    class: 'success',
                    icon: '📋',
                    text: 'RENDAH'
                }
            };
            return priorities[priority] || priorities['rendah'];
        }

        function formatDate(dateString) {
            if (!dateString) return new Date().toLocaleDateString('id-ID');
            return new Date(dateString).toLocaleDateString('id-ID', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        }

        function getLoadingHtml(message) {
            return `
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <p class="mt-2 text-muted">${message}</p>
            </div>
        `;
        }

        function showAlert(type, message) {
            const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'warning' ? 'exclamation-triangle' : 'times-circle'}"></i>
                ${message}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        `;

            // Remove existing alerts
            $('.alert').remove();

            // Add new alert at top of form
            $('.pengumuman-form').prepend(alertHtml);

            // Auto dismiss after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut();
            }, 5000);
        }

        // Character counter for textarea
        $('#historykelas-isi_pengumuman').on('input', function() {
            const maxLength = 1000;
            const currentLength = $(this).val().length;
            const remaining = maxLength - currentLength;

            let $counter = $(this).siblings('.char-counter');
            if ($counter.length === 0) {
                $counter = $('<small class="form-text text-muted char-counter"></small>');
                $(this).after($counter);
            }

            $counter.html(`
            <i class="fas fa-keyboard"></i> 
            ${currentLength} karakter 
            <span class="${remaining < 100 ? 'text-warning' : 'text-muted'}">
                (sisa: ${remaining})
            </span>
        `);
        });
    });
</script>

<style>
    /* Main Styles */
    .pengumuman-form {
        margin: 20px 0;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    .card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
    }

    .card.shadow-lg {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
    }

    /* Header Styles */
    .bg-gradient-telegram {
        background: linear-gradient(135deg, #0088cc 0%, #0077b6 50%, #005f8a 100%);
        position: relative;
        overflow: hidden;
    }

    .bg-gradient-telegram::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(255, 255, 255, 0.1) 25%, transparent 25%),
            linear-gradient(-45deg, rgba(255, 255, 255, 0.1) 25%, transparent 25%),
            linear-gradient(45deg, transparent 75%, rgba(255, 255, 255, 0.1) 75%),
            linear-gradient(-45deg, transparent 75%, rgba(255, 255, 255, 0.1) 75%);
        background-size: 20px 20px;
        background-position: 0 0, 0 10px, 10px -10px, -10px 0px;
        opacity: 0.3;
    }

    .card-header h3 {
        position: relative;
        z-index: 2;
        font-weight: 600;
    }

    .pulse-icon {
        animation: pulse 2s infinite;
        display: inline-block;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.1);
        }

        100% {
            transform: scale(1);
        }
    }

    /* Form Section Styles */
    .form-section {
        margin-bottom: 2rem;
        padding: 1.5rem;
        background: white;
        border-radius: 10px;
        border: 1px solid #e9ecef;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .section-title {
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #f8f9fa;
        font-weight: 600;
        color: #495057;
    }

    .section-title i {
        margin-right: 8px;
    }

    /* Form Controls */
    .form-control {
        border-radius: 8px;
        border: 2px solid #e9ecef;
        padding: 12px 16px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #0088cc;
        box-shadow: 0 0 0 0.2rem rgba(0, 136, 204, 0.25);
        transform: translateY(-1px);
    }

    .form-control.is-valid {
        border-color: #28a745;
    }

    .form-control.is-invalid {
        border-color: #dc3545;
    }

    .form-control-lg {
        font-size: 16px;
        font-weight: 500;
    }

    /* Select2 Customization */
    .select2-container--bootstrap4 .select2-selection {
        border: 2px solid #e9ecef !important;
        border-radius: 8px !important;
        min-height: 48px !important;
    }

    .select2-container--bootstrap4.select2-container--focus .select2-selection {
        border-color: #0088cc !important;
        box-shadow: 0 0 0 0.2rem rgba(0, 136, 204, 0.25) !important;
    }

    /* Button Styles */
    .btn-group-custom {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .btn {
        border-radius: 8px;
        font-weight: 500;
        padding: 12px 24px;
        transition: all 0.3s ease;
        border: none;
        position: relative;
        overflow: hidden;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .btn:hover::before {
        width: 300px;
        height: 300px;
    }

    .btn i {
        margin-right: 8px;
    }

    .btn-telegram {
        background: linear-gradient(135deg, #0088cc, #0066aa);
        color: white;
    }

    .btn-telegram:hover {
        background: linear-gradient(135deg, #0077bb, #005599);
        color: white;
    }

    .bg-telegram {
        background: linear-gradient(135deg, #0088cc, #0066aa) !important;
    }

    /* Modal Enhancements */
    .modal-content {
        border-radius: 15px;
        border: none;
        overflow: hidden;
    }

    .modal-header {
        border-bottom: none;
        padding: 1.5rem 2rem;
    }

    .modal-body {
        padding: 2rem;
    }

    .modal-footer {
        border-top: 1px solid #e9ecef;
        padding: 1.5rem 2rem;
    }

    /* Telegram Preview */
    .telegram-preview {
        margin: 15px 0;
    }

    .telegram-message {
        border-radius: 15px;
        border: none;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
    }

    .telegram-message::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: currentColor;
    }

    .telegram-content {
        padding: 20px 25px;
        position: relative;
    }

    .telegram-title {
        font-weight: 700;
        margin-bottom: 15px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .telegram-body h6 {
        color: #2c3e50;
        margin-bottom: 10px;
    }

    .telegram-text {
        line-height: 1.6;
        margin-bottom: 15px;
    }

    .telegram-footer {
        border-top: 1px solid rgba(255, 255, 255, 0.3);
        margin-top: 15px;
        padding-top: 15px;
    }

    .priority-badge .badge {
        font-size: 12px;
        padding: 8px 12px;
        border-radius: 20px;
        font-weight: 600;
    }

    .badge-lg {
        font-size: 14px !important;
        padding: 10px 16px !important;
    }

    /* Progress Bar */
    .progress {
        height: 30px;
        border-radius: 15px;
        background-color: #e9ecef;
        overflow: hidden;
    }

    .progress-bar {
        border-radius: 15px;
        position: relative;
        transition: width 0.6s ease;
    }

    .progress-text {
        position: absolute;
        width: 100%;
        text-align: center;
        line-height: 30px;
        font-weight: 600;
        color: white;
        text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.3);
    }

    .bg-telegram.progress-bar {
        background: linear-gradient(135deg, #0088cc, #0066aa);
    }

    /* Alert Enhancements */
    .alert {
        border-radius: 10px;
        border: none;
        padding: 15px 20px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .alert i {
        margin-right: 10px;
        font-size: 16px;
    }

    .border-left-primary {
        border-left: 4px solid #007bff !important;
    }

    .fade-in {
        animation: fadeIn 0.5s ease-in;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Loading Spinner */
    .spinner-border {
        width: 3rem;
        height: 3rem;
        border-width: 0.3em;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .pengumuman-form {
            margin: 10px;
        }

        .form-section {
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .btn-group-custom {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            margin-bottom: 10px;
        }

        .modal-dialog {
            margin: 10px;
        }

        .modal-body {
            padding: 1rem;
        }

        .telegram-content {
            padding: 15px;
        }
    }

    @media (max-width: 576px) {
        .card-header h3 {
            font-size: 18px;
        }

        .section-title {
            font-size: 16px;
        }

        .modal-header h4 {
            font-size: 18px;
        }
    }

    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }

    /* Siswa List Styles */
    #siswa-telegram-list {
        max-height: 400px;
        overflow-y: auto;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 20px;
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    }

    .siswa-item {
        padding: 12px;
        margin: 8px 0;
        background: white;
        border-radius: 8px;
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .siswa-item:hover {
        border-color: #0088cc;
        box-shadow: 0 2px 8px rgba(0, 136, 204, 0.15);
        transform: translateX(5px);
    }

    .siswa-item .checkbox {
        margin: 0;
    }

    .siswa-item label {
        font-weight: 500;
        color: #495057;
        cursor: pointer;
        display: flex;
        align-items: center;
        width: 100%;
    }

    .siswa-item input[type="checkbox"] {
        margin-right: 12px;
        transform: scale(1.2);
    }

    /* Character Counter */
    .char-counter {
        margin-top: 5px;
        font-size: 12px;
    }

    /* Form Animation */
    .form-group {
        animation: slideIn 0.6s ease-out forwards;
        opacity: 0;
    }

    .form-group:nth-child(1) {
        animation-delay: 0.1s;
    }

    .form-group:nth-child(2) {
        animation-delay: 0.2s;
    }

    .form-group:nth-child(3) {
        animation-delay: 0.3s;
    }

    .form-group:nth-child(4) {
        animation-delay: 0.4s;
    }

    .form-group:nth-child(5) {
        animation-delay: 0.5s;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Success States */
    .is-valid {
        border-color: #28a745 !important;
    }

    .is-valid:focus {
        border-color: #28a745 !important;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25) !important;
    }

    .invalid-feedback {
        display: block;
        font-size: 12px;
        margin-top: 5px;
        color: #dc3545;
    }

    .valid-feedback {
        display: block;
        font-size: 12px;
        margin-top: 5px;
        color: #28a745;
    }

    /* Enhanced Focus States */
    .form-control:focus,
    .select2-container--focus .select2-selection {
        outline: none;
        transform: translateY(-1px);
    }

    /* Button Loading State */
    .btn:disabled {
        opacity: 0.7;
        transform: none !important;
        box-shadow: none !important;
    }

    /* Modal Animation */
    .modal.fade .modal-dialog {
        transform: translateY(-50px);
        transition: transform 0.3s ease-out;
    }

    .modal.show .modal-dialog {
        transform: translateY(0);
    }
</style>