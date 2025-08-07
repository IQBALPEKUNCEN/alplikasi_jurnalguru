<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\base\Historykelas */
/* @var $form kartik\form\ActiveForm */
?>

<div class="pengumuman-form">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">
                <i class="fa fa-bullhorn"></i> Form Pengumuman Kelas
            </h3>
        </div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin([
                'id' => 'pengumuman-form',
                'type' => ActiveForm::TYPE_HORIZONTAL,
                'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL]
            ]); ?>

            <?= $form->errorSummary($model); ?>

            <?= $form->field($model, 'judul_pengumuman')->textInput([
                'placeholder' => 'Masukkan judul pengumuman...',
                'maxlength' => true
            ])->label('Judul Pengumuman') ?>

            <?= $form->field($model, 'isi_pengumuman')->textarea([
                'rows' => 6,
                'placeholder' => 'Tulis isi pengumuman di sini...'
            ])->label('Isi Pengumuman') ?>

            <?= $form->field($model, 'tanggal_pengumuman')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Pilih tanggal pengumuman'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true
                ]
            ])->label('Tanggal Pengumuman') ?>

            <?= $form->field($model, 'kodeta')->widget(Select2::classname(), [
                'data' => \yii\helpers\ArrayHelper::map(
                    \app\models\base\Tahunajaran::find()->orderBy('kodeta')->asArray()->all(),
                    'kodeta',
                    'kodeta'
                ),
                'options' => ['placeholder' => 'Pilih Tahun Ajaran'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Tahun Ajaran') ?>

            <?= $form->field($model, 'kode_kelas')->widget(Select2::classname(), [
                'data' => \yii\helpers\ArrayHelper::map(
                    \app\models\base\Kelas::find()->orderBy('kode_kelas')->asArray()->all(),
                    'kode_kelas',
                    'kode_kelas'
                ),
                'options' => ['placeholder' => 'Pilih Kelas Target'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Kelas Target') ?>

            <?= $form->field($model, 'tingkat_prioritas')->widget(Select2::classname(), [
                'data' => [
                    'rendah' => 'Rendah',
                    'sedang' => 'Sedang',
                    'tinggi' => 'Tinggi',
                    'mendesak' => 'Mendesak'
                ],
                'options' => ['placeholder' => 'Pilih tingkat prioritas'],
            ])->label('Tingkat Prioritas') ?>

            <?= $form->field($model, 'status_kirim')->widget(Select2::classname(), [
                'data' => [
                    'draft' => 'Draft',
                    'siap_kirim' => 'Siap Kirim',
                    'terkirim' => 'Sudah Terkirim'
                ],
                'options' => ['placeholder' => 'Status pengumuman'],
            ])->label('Status') ?>

            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <?= Html::submitButton(
                        $model->isNewRecord ? '<i class="fa fa-plus"></i> Buat Pengumuman' : '<i class="fa fa-edit"></i> Update Pengumuman',
                        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
                    ) ?>

                    <?php if (!$model->isNewRecord): ?>
                        <?= Html::button(
                            '<i class="fa fa-whatsapp"></i> Kirim ke WhatsApp',
                            [
                                'class' => 'btn btn-success',
                                'id' => 'btn-kirim-wa',
                                'data-token' => 'xkhUEThsZp3sGW2UE4Fi'
                            ]
                        ) ?>

                        <?= Html::button(
                            '<i class="fa fa-eye"></i> Preview',
                            [
                                'class' => 'btn btn-info',
                                'id' => 'btn-preview',
                                'data-toggle' => 'modal',
                                'data-target' => '#preview-modal'
                            ]
                        ) ?>
                    <?php endif; ?>

                    <?= Html::a(
                        '<i class="fa fa-times"></i> Batal',
                        Yii::$app->request->referrer,
                        ['class' => 'btn btn-danger']
                    ) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<!-- Modal Preview -->
<div class="modal fade" id="preview-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">
                    <i class="fa fa-eye"></i> Preview Pengumuman
                </h4>
            </div>
            <div class="modal-body" id="preview-content">
                <!-- Preview content akan dimuat di sini -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Kirim WhatsApp -->
<div class="modal fade" id="wa-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">
                    <i class="fa fa-whatsapp"></i> Kirim ke WhatsApp
                </h4>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin mengirim pengumuman ini ke seluruh siswa di kelas yang dipilih melalui WhatsApp?</p>
                <div class="alert alert-info">
                    <i class="fa fa-info-circle"></i>
                    Token WhatsApp: <strong>xkhUEThsZp3sGW2UE4Fi</strong>
                </div>
                <div id="siswa-list">
                    <!-- Daftar siswa akan dimuat di sini -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="confirm-kirim-wa">
                    <i class="fa fa-paper-plane"></i> Ya, Kirim Sekarang
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Preview pengumuman
        $('#btn-preview').click(function() {
            var judul = $('#historykelas-judul_pengumuman').val();
            var isi = $('#historykelas-isi_pengumuman').val();
            var tanggal = $('#historykelas-tanggal_pengumuman').val();
            var kelas = $('#historykelas-kode_kelas').val();
            var prioritas = $('#historykelas-tingkat_prioritas').val();

            var previewHtml = `
            <div class="pengumuman-preview">
                <div class="alert alert-${getPriorityClass(prioritas)}">
                    <h4><i class="fa fa-bullhorn"></i> ${judul}</h4>
                    <hr>
                    <p>${isi.replace(/\n/g, '<br>')}</p>
                    <hr>
                    <small>
                        <i class="fa fa-calendar"></i> ${tanggal} | 
                        <i class="fa fa-users"></i> Kelas: ${kelas} | 
                        <i class="fa fa-flag"></i> Prioritas: ${prioritas}
                    </small>
                </div>
            </div>
        `;

            $('#preview-content').html(previewHtml);
        });

        // Kirim WhatsApp
        $('#btn-kirim-wa').click(function() {
            var kelas = $('#historykelas-kode_kelas').val();
            if (!kelas) {
                alert('Pilih kelas terlebih dahulu!');
                return;
            }

            // Load daftar siswa
            $.ajax({
                url: '<?= \yii\helpers\Url::to(['get-siswa-by-kelas']) ?>',
                data: {
                    kelas: kelas
                },
                success: function(data) {
                    $('#siswa-list').html(data);
                    $('#wa-modal').modal('show');
                }
            });
        });

        // Konfirmasi kirim WhatsApp
        $('#confirm-kirim-wa').click(function() {
            var token = $(this).data('token');
            var formData = $('#pengumuman-form').serialize();

            $.ajax({
                url: '<?= \yii\helpers\Url::to(['kirim-wa']) ?>',
                method: 'POST',
                data: formData + '&token=' + token,
                beforeSend: function() {
                    $('#confirm-kirim-wa').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Mengirim...');
                },
                success: function(response) {
                    if (response.success) {
                        alert('Pengumuman berhasil dikirim ke WhatsApp!');
                        $('#wa-modal').modal('hide');
                        location.reload();
                    } else {
                        alert('Gagal mengirim: ' + response.message);
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan saat mengirim pengumuman');
                },
                complete: function() {
                    $('#confirm-kirim-wa').prop('disabled', false).html('<i class="fa fa-paper-plane"></i> Ya, Kirim Sekarang');
                }
            });
        });

        function getPriorityClass(priority) {
            switch (priority) {
                case 'mendesak':
                    return 'danger';
                case 'tinggi':
                    return 'warning';
                case 'sedang':
                    return 'info';
                default:
                    return 'success';
            }
        }
    });
</script>

<style>
    .pengumuman-preview {
        margin: 15px 0;
    }

    .panel-primary>.panel-heading {
        background-color: #337ab7;
        border-color: #337ab7;
    }

    .btn {
        margin-right: 5px;
    }

    #siswa-list {
        max-height: 200px;
        overflow-y: auto;
        border: 1px solid #ddd;
        padding: 10px;
        border-radius: 4px;
    }

    .alert {
        margin-bottom: 15px;
    }
</style>