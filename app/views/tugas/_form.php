<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Guru;
use app\models\Mapel;
use app\models\Kelas;

/** @var yii\web\View $this */
/** @var app\models\Tugas $model */
/** @var yii\widgets\ActiveForm $form */

// Import libraries
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css');
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');

// Custom CSS dengan desain modern
$this->registerCss("
    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    .form-container {
        max-width: 900px;
        margin: 40px auto;
        padding: 0 20px;
    }
    
    .main-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 24px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        overflow: hidden;
        animation: slideInUp 0.8s ease-out;
    }
    
    .card-header-modern {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 30px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    
    .card-header-modern::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
        background-size: 20px 20px;
        animation: float 20s linear infinite;
    }
    
    .header-title {
        font-size: 28px;
        font-weight: 700;
        margin: 0;
        position: relative;
        z-index: 1;
    }
    
    .header-subtitle {
        font-size: 16px;
        opacity: 0.9;
        margin-top: 8px;
        position: relative;
        z-index: 1;
    }
    
    .card-body-modern {
        padding: 40px;
    }
    
    .form-section {
        margin-bottom: 35px;
    }
    
    .section-title {
        font-size: 18px;
        font-weight: 600;
        color: #333;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .section-title i {
        color: #667eea;
        font-size: 20px;
    }
    
    .form-group {
        margin-bottom: 25px;
        position: relative;
    }
    
    .form-control, .form-select {
        border: 2px solid #e1e8ed;
        border-radius: 12px !important;
        padding: 12px 16px;
        font-size: 15px;
        transition: all 0.3s ease;
        background: #f8f9fa;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        background: white;
        transform: translateY(-2px);
    }
    
    .control-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .input-group {
        position: relative;
    }
    
    .input-icon {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #667eea;
        z-index: 3;
    }
    
    .file-upload-area {
        border: 2px dashed #667eea;
        border-radius: 12px;
        padding: 30px;
        text-align: center;
        background: linear-gradient(45deg, #f8f9fa, #e9ecef);
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
    }
    
    .file-upload-area:hover {
        border-color: #764ba2;
        background: linear-gradient(45deg, #e9ecef, #f8f9fa);
        transform: scale(1.02);
    }
    
    .file-upload-icon {
        font-size: 48px;
        color: #667eea;
        margin-bottom: 15px;
    }
    
    .file-upload-text {
        font-size: 16px;
        color: #666;
        margin-bottom: 5px;
    }
    
    .file-upload-subtext {
        font-size: 14px;
        color: #999;
    }
    
    .current-file {
        background: linear-gradient(135deg, #e3f2fd, #bbdefb);
        border-radius: 12px;
        padding: 15px;
        margin-top: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .submit-area {
        text-align: center;
        margin-top: 40px;
        padding-top: 30px;
        border-top: 1px solid #e1e8ed;
    }
    
    .btn-modern {
        padding: 15px 40px;
        font-size: 16px;
        font-weight: 600;
        border-radius: 50px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .btn-primary-modern {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .btn-success-modern {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white;
    }
    
    .btn-modern:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }
    
    .btn-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }
    
    .btn-modern:hover::before {
        left: 100%;
    }
    
    .floating-icons {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 1;
    }
    
    .floating-icon {
        position: absolute;
        color: rgba(255, 255, 255, 0.1);
        font-size: 24px;
        animation: float-around 15s infinite linear;
    }
    
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes float {
        0% { transform: translateX(-50px); }
        100% { transform: translateX(50px); }
    }
    
    @keyframes float-around {
        0% {
            transform: translateY(100vh) rotate(0deg);
            opacity: 0;
        }
        10% {
            opacity: 1;
        }
        90% {
            opacity: 1;
        }
        100% {
            transform: translateY(-100px) rotate(360deg);
            opacity: 0;
        }
    }
    
    .row {
        margin-left: -10px;
        margin-right: -10px;
    }
    
    .row > div {
        padding-left: 10px;
        padding-right: 10px;
    }
    
    @media (max-width: 768px) {
        .form-container {
            padding: 0 15px;
        }
        
        .card-body-modern {
            padding: 25px;
        }
        
        .header-title {
            font-size: 24px;
        }
    }
");

?>

<!-- Floating background icons -->
<div class="floating-icons">
    <i class="fas fa-book floating-icon" style="left: 10%; animation-delay: 0s;"></i>
    <i class="fas fa-graduation-cap floating-icon" style="left: 20%; animation-delay: 3s;"></i>
    <i class="fas fa-pencil-alt floating-icon" style="left: 30%; animation-delay: 6s;"></i>
    <i class="fas fa-tasks floating-icon" style="left: 40%; animation-delay: 9s;"></i>
    <i class="fas fa-clipboard-list floating-icon" style="left: 50%; animation-delay: 12s;"></i>
    <i class="fas fa-calendar-alt floating-icon" style="left: 60%; animation-delay: 15s;"></i>
    <i class="fas fa-upload floating-icon" style="left: 70%; animation-delay: 18s;"></i>
    <i class="fas fa-file-alt floating-icon" style="left: 80%; animation-delay: 21s;"></i>
</div>

<div class="form-container">
    <div class="main-card animate__animated animate__fadeInUp">
        <div class="card-header-modern">
            <h1 class="header-title">
                <i class="fas fa-clipboard-list"></i>
                Form Input Tugas
            </h1>
            <p class="header-subtitle">Kelola tugas siswa dengan mudah dan efisien</p>
        </div>

        <div class="card-body-modern">
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

            <!-- Section: Informasi Dasar -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-info-circle"></i>
                    Informasi Dasar
                </h3>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <?= $form->field($model, 'judul_tugas')->textInput([
                                'maxlength' => true,
                                'placeholder' => 'Masukkan judul tugas...',
                                'class' => 'form-control'
                            ])->label('<i class="fas fa-heading"></i> Judul Tugas') ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <?= $form->field($model, 'kode_mapel')->dropDownList(
                                ArrayHelper::map(Mapel::find()->all(), 'kode_mapel', 'nama'),
                                [
                                    'prompt' => 'Pilih Mata Pelajaran',
                                    'class' => 'form-select'
                                ]
                            )->label('<i class="fas fa-book"></i> Mata Pelajaran') ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <?= $form->field($model, 'kode_kelas')->dropDownList(
                                ArrayHelper::map(Kelas::find()->all(), 'kode_kelas', 'nama'),
                                [
                                    'prompt' => 'Pilih Kelas',
                                    'class' => 'form-select'
                                ]
                            )->label('<i class="fas fa-users"></i> Kelas') ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <?= $form->field($model, 'guru_id')->dropDownList(
                                ArrayHelper::map(
                                    Guru::find()->all(),
                                    'guru_id',
                                    function ($guru) {
                                        return $guru->nama . ' (' . $guru->jabatan . ')';
                                    }
                                ),
                                [
                                    'prompt' => 'Pilih Guru',
                                    'class' => 'form-select'
                                ]
                            )->label('<i class="fas fa-chalkboard-teacher"></i> Guru Pengajar') ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section: Deskripsi -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-align-left"></i>
                    Deskripsi Tugas
                </h3>

                <div class="form-group">
                    <?= $form->field($model, 'deskripsi')->textarea([
                        'rows' => 5,
                        'placeholder' => 'Jelaskan detail tugas, instruksi, dan kriteria penilaian...',
                        'class' => 'form-control'
                    ])->label('<i class="fas fa-file-alt"></i> Deskripsi Detail') ?>
                </div>
            </div>

            <!-- Section: Jadwal -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-calendar-alt"></i>
                    Jadwal Tugas
                </h3>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <?= $form->field($model, 'tanggal_dibuat')->input('date', [
                                'class' => 'form-control'
                            ])->label('<i class="fas fa-calendar-plus"></i> Tanggal Dibuat') ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <?= $form->field($model, 'tanggal_selesai')->input('date', [
                                'class' => 'form-control'
                            ])->label('<i class="fas fa-calendar-check"></i> Deadline') ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section: File Upload -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-cloud-upload-alt"></i>
                    File Tugas
                </h3>

                <div class="form-group">
                    <label class="control-label">
                        <i class="fas fa-paperclip"></i> Upload File Tugas
                    </label>
                    <div class="file-upload-area" onclick="document.getElementById('tugas-file_tugas').click()">
                        <div class="file-upload-icon">
                            <i class="fas fa-cloud-upload-alt"></i>
                        </div>
                        <div class="file-upload-text">
                            Klik untuk upload file atau drag & drop
                        </div>
                        <div class="file-upload-subtext">
                            Mendukung: PDF, DOC, XLS, PPT, IMG (Max 10MB)
                        </div>
                    </div>
                    <?= $form->field($model, 'file_tugas')->fileInput([
                        'accept' => '.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.jpg,.jpeg,.png',
                        'style' => 'display: none;',
                        'onchange' => 'updateFileName(this)'
                    ])->label(false) ?>
                </div>

                <?php if (!$model->isNewRecord && !empty($model->file_tugas)): ?>
                    <div class="current-file">
                        <i class="fas fa-file-alt" style="color: #1976d2; font-size: 24px;"></i>
                        <div>
                            <strong>File Saat Ini:</strong><br>
                            <?= Html::a(
                                '<i class="fas fa-download"></i> ' . Html::encode($model->file_tugas),
                                ['download-file', 'id' => $model->id],
                                [
                                    'class' => 'btn btn-outline-primary btn-sm',
                                    'target' => '_blank'
                                ]
                            ) ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Submit Button -->
            <div class="submit-area">
                <?= Html::submitButton(
                    $model->isNewRecord ?
                        '<i class="fas fa-save"></i> Simpan Tugas' :
                        '<i class="fas fa-edit"></i> Update Tugas',
                    [
                        'class' => $model->isNewRecord ?
                            'btn btn-modern btn-success-modern' :
                            'btn btn-modern btn-primary-modern'
                    ]
                ) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<script>
    function updateFileName(input) {
        const fileUploadArea = document.querySelector('.file-upload-area');
        if (input.files && input.files[0]) {
            const fileName = input.files[0].name;
            const fileSize = (input.files[0].size / 1024 / 1024).toFixed(2);

            fileUploadArea.innerHTML = `
            <div class="file-upload-icon" style="color: #4caf50;">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="file-upload-text" style="color: #4caf50;">
                File berhasil dipilih!
            </div>
            <div class="file-upload-subtext">
                ${fileName} (${fileSize} MB)
            </div>
        `;
        }
    }

    // Add smooth scrolling effect on form submission
    document.querySelector('form').addEventListener('submit', function() {
        const submitBtn = document.querySelector('.btn-modern');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
        submitBtn.disabled = true;
    });
</script>