<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Tugas;
use app\models\Siswa;

/** @var yii\web\View $this */
/** @var app\models\PengumpulanTugas $model */
/** @var yii\widgets\ActiveForm $form */

// Ambil data tugas untuk dropdown
$tugasList = ArrayHelper::map(Tugas::find()->all(), 'id', 'judul_tugas');

// Ambil data siswa untuk dropdown
$siswaQuery = Siswa::find()->orderBy('nama ASC');
$siswaData = $siswaQuery->all();

// Mapping dengan NIS sebagai key dan display "NIS - Nama - Kelas"
$siswaList = ArrayHelper::map($siswaData, 'nis', function ($model) {
    $display = $model->nis . ' - ' . $model->nama;
    if ($model->kelas) {
        $display .= ' (' . $model->kelas->kode_kelas . ')';
    }
    return $display;
});

// Register FontAwesome
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');

// Register simple attractive CSS
$this->registerCss("
    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        font-family: 'Segoe UI', sans-serif;
        min-height: 100vh;
        margin: 0;
        padding: 20px 0;
    }
    
    .form-wrapper {
        max-width: 600px;
        margin: 0 auto;
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    
    .form-header {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 30px;
        text-align: center;
    }
    
    .form-header h1 {
        margin: 0;
        font-size: 1.8rem;
        font-weight: 600;
    }
    
    .form-header p {
        margin: 10px 0 0 0;
        opacity: 0.9;
        font-size: 0.95rem;
    }
    
    .form-content {
        padding: 40px;
    }
    
    .form-group {
        margin-bottom: 25px;
    }
    
    .control-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.95rem;
    }
    
    .control-label i {
        color: #667eea;
        width: 16px;
    }
    
    .required {
        color: #e74c3c;
    }
    
    .form-control {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e1e5e9;
        border-radius: 10px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #fafbfc;
        box-sizing: border-box;
    }
    
    .form-control:focus {
        border-color: #667eea;
        background: white;
        outline: none;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    
    .form-control:hover {
        border-color: #667eea;
    }
    
    select.form-control {
        cursor: pointer;
        background-image: url('data:image/svg+xml;utf8,<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"12\" height=\"12\" viewBox=\"0 0 12 12\"><path fill=\"%23667eea\" d=\"M6 9L1.5 4.5h9L6 9z\"/></svg>');
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 12px;
        padding-right: 40px;
        height: auto;
        min-height: 45px;
        line-height: 1.4;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    select.form-control option {
        padding: 8px 12px;
        white-space: normal;
        word-wrap: break-word;
        line-height: 1.4;
    }
    
    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }
    
    .file-input-container {
        position: relative;
    }
    
    .file-input-container input[type=file] {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }
    
    .file-input-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 12px 16px;
        background: #f8f9fa;
        border: 2px dashed #dee2e6;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
        color: #666;
        font-weight: 500;
    }
    
    .file-input-btn:hover {
        background: #e9ecef;
        border-color: #667eea;
        color: #667eea;
    }
    
    .file-selected {
        background: #e8f5e8 !important;
        border-color: #28a745 !important;
        color: #28a745 !important;
    }
    
    .help-text {
        font-size: 0.85rem;
        color: #6c757d;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    .help-text i {
        color: #667eea;
    }
    
    .form-actions {
        display: flex;
        gap: 12px;
        justify-content: center;
        margin-top: 30px;
        padding-top: 25px;
        border-top: 1px solid #e9ecef;
    }
    
    .btn {
        padding: 12px 30px;
        border-radius: 25px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.95rem;
    }
    
    .btn:hover {
        transform: translateY(-1px);
        text-decoration: none;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }
    
    .btn-primary:hover {
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        color: white;
    }
    
    .btn-secondary {
        background: #6c757d;
        color: white;
    }
    
    .btn-secondary:hover {
        background: #5a6268;
        color: white;
    }
    
    .validation-error {
        color: #e74c3c;
        font-size: 0.85rem;
        margin-top: 5px;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    .has-error .form-control {
        border-color: #e74c3c;
        box-shadow: 0 0 0 3px rgba(231, 76, 60, 0.1);
    }
    
    @media (max-width: 768px) {
        .form-wrapper {
            margin: 0 15px;
        }
        
        .form-content {
            padding: 25px;
        }
        
        .form-actions {
            flex-direction: column;
        }
        
        .btn {
            width: 100%;
            justify-content: center;
        }
    }
");

// Register simple JavaScript
$this->registerJs("
$(document).ready(function() {
    // File input handler
    $('input[type=\"file\"]').change(function() {
        var fileName = $(this).val().split('\\\\').pop();
        var btn = $(this).siblings('.file-input-btn');
        
        if (fileName) {
            btn.addClass('file-selected');
            btn.html('<i class=\"fas fa-check\"></i> ' + fileName);
        } else {
            btn.removeClass('file-selected');
            btn.html('<i class=\"fas fa-upload\"></i> Pilih File');
        }
    });
});
");

?>

<div class="form-wrapper">
    <!-- Header -->
    <div class="form-header">
        <h1>
            <i class="fas fa-file-upload"></i>
            <?= $model->isNewRecord ? 'Pengumpulan Tugas' : 'Edit Pengumpulan' ?>
        </h1>
        <p><?= $model->isNewRecord ? 'Tambah pengumpulan tugas baru' : 'Perbarui data pengumpulan tugas' ?></p>
    </div>

    <!-- Form Content -->
    <div class="form-content">
        <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data'],
            'fieldConfig' => [
                'template' => '<div class="form-group">{label}{input}{error}{hint}</div>',
                'labelOptions' => ['class' => 'control-label'],
                'inputOptions' => ['class' => 'form-control'],
                'errorOptions' => ['class' => 'validation-error'],
                'hintOptions' => ['class' => 'help-text'],
            ],
        ]); ?>

        <!-- Pilih Tugas -->
        <?= $form->field($model, 'tugas_id')->dropDownList(
            $tugasList,
            [
                'prompt' => '-- Pilih Tugas --',
                'class' => 'form-control',
                'style' => 'width: 100%; height: auto; min-height: 45px;'
            ]
        )->label('<i class="fas fa-tasks"></i> Tugas <span class="required">*</span>') ?>

        <!-- Pilih Siswa -->
        <?= $form->field($model, 'nis')->dropDownList(
            $siswaList,
            [
                'prompt' => '-- Pilih Siswa --',
                'class' => 'form-control',
                'style' => 'width: 100%; height: auto; min-height: 45px;'
            ]
        )->label('<i class="fas fa-user"></i> Siswa <span class="required">*</span>')
            ->hint('<i class="fas fa-info-circle"></i> Pilih siswa yang mengumpulkan tugas') ?>

        <!-- Upload File -->
        <div class="form-group">
            <label class="control-label">
                <i class="fas fa-file"></i> File Tugas <span class="required">*</span>
            </label>
            <div class="file-input-container">
                <?= Html::activeFileInput($model, 'file_tugas', [
                    'accept' => '.pdf,.doc,.docx,.txt,.jpg,.png,.zip,.rar',
                    'id' => 'file-upload'
                ]) ?>
                <div class="file-input-btn" onclick="document.getElementById('file-upload').click()">
                    <i class="fas fa-upload"></i> Pilih File
                </div>
            </div>
            <div class="help-text">
                <i class="fas fa-info-circle"></i>
                PDF, DOC, DOCX, TXT, JPG, PNG, ZIP, RAR (max 10MB)
            </div>
        </div>

        <!-- Keterangan -->
        <?= $form->field($model, 'keterangan')->textarea([
            'rows' => 4,
            'placeholder' => 'Keterangan tambahan (opsional)',
            'class' => 'form-control'
        ])->label('<i class="fas fa-comment"></i> Keterangan') ?>

        <!-- Hidden field -->
        <?= $form->field($model, 'tanggal_kumpul')->hiddenInput([
            'value' => date('Y-m-d H:i:s')
        ])->label(false) ?>

        <!-- Action Buttons -->
        <div class="form-actions">
            <?= Html::submitButton(
                $model->isNewRecord ? '<i class="fas fa-save"></i> Simpan' : '<i class="fas fa-edit"></i> Update',
                ['class' => 'btn btn-primary']
            ) ?>

            <?= Html::a('<i class="fas fa-arrow-left"></i> Kembali', ['index'], [
                'class' => 'btn btn-secondary'
            ]) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>