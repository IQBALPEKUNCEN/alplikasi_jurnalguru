<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var string $nama_siswa */
/** @var string $judul_tugas */
/** @var string $tanggal_kumpul */
/** @var string $kelas */

$this->title = 'Pengumpulan Tugas Siswa';
$this->params['breadcrumbs'][] = $this->title;

// CSS yang lebih modern dan menarik
$this->registerCss(<<<CSS
/* Container Utama */
.history-container {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    margin: 20px 0;
    position: relative;
    overflow: hidden;
}

.history-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    pointer-events: none;
}

.content-wrapper {
    position: relative;
    z-index: 1;
    background: rgba(255, 255, 255, 0.95);
    padding: 30px;
    border-radius: 15px;
    backdrop-filter: blur(10px);
    box-shadow: 0 8px 32px rgba(0,0,0,0.1);
}

/* Header Section */
.page-header {
    text-align: center;
    margin-bottom: 40px;
    position: relative;
}

.page-header::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background: linear-gradient(45deg, #667eea, #764ba2);
    border-radius: 2px;
}

.page-title {
    font-size: 2.5rem;
    font-weight: 700;
    background: linear-gradient(45deg, #667eea, #764ba2);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 10px;
}

.page-subtitle {
    font-size: 16px;
    color: #6c757d;
    font-weight: 400;
}

/* Statistics Cards */
.stats-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: linear-gradient(135deg, #ffffff 0%, #f8f9ff 100%);
    border: none;
    border-radius: 15px;
    padding: 25px 20px;
    text-align: center;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(45deg, #667eea, #764ba2);
    border-radius: 15px 15px 0 0;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.15);
}

.stat-number {
    font-size: 2.2rem;
    font-weight: 800;
    background: linear-gradient(45deg, #667eea, #764ba2);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 8px;
}

.stat-label {
    font-size: 14px;
    color: #6c757d;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.stat-icon {
    position: absolute;
    top: 15px;
    right: 15px;
    font-size: 24px;
    color: rgba(102, 126, 234, 0.3);
}

/* Search Section */
.search-section {
    background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
    padding: 25px;
    border-radius: 15px;
    margin-bottom: 30px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    border: 1px solid rgba(102, 126, 234, 0.1);
}

.search-header {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid rgba(102, 126, 234, 0.1);
}

.search-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: #343a40;
    margin: 0;
    margin-left: 10px;
}

.search-icon {
    color: #667eea;
    font-size: 1.3rem;
}

.form-row {
    display: flex;
    flex-wrap: wrap;
    margin: 0 -10px;
}

.form-group {
    padding: 0 10px;
}

.form-control, .select2-container--krajee .select2-selection {
    border: 2px solid #e9ecef;
    border-radius: 10px;
    padding: 12px 15px;
    font-size: 14px;
    transition: all 0.3s ease;
    background: #ffffff;
}

.form-control:focus, .select2-container--krajee.select2-container--focus .select2-selection {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    outline: none;
}

.btn {
    padding: 12px 25px;
    border-radius: 10px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
    border: none;
}

.btn-primary {
    background: linear-gradient(45deg, #667eea, #764ba2);
    color: white;
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
}

.btn-outline-secondary {
    border: 2px solid #6c757d;
    color: #6c757d;
    background: transparent;
}

.btn-outline-secondary:hover {
    background: #6c757d;
    color: white;
    transform: translateY(-2px);
}

/* Grid View */
.grid-container {
    background: #ffffff;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    overflow: hidden;
    border: 1px solid rgba(102, 126, 234, 0.1);
}

.grid-header {
    background: linear-gradient(45deg, #667eea, #764ba2);
    color: white;
    padding: 20px 25px;
    display: flex;
    align-items: center;
}

.grid-title {
    font-size: 1.3rem;
    font-weight: 600;
    margin: 0;
    margin-left: 10px;
}

.table {
    margin-bottom: 0;
    background: #ffffff;
}

.table thead th {
    background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
    border: none;
    color: #495057;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-size: 13px;
    padding: 15px;
    border-bottom: 2px solid rgba(102, 126, 234, 0.1);
}

.table tbody td {
    padding: 15px;
    vertical-align: middle;
    border-bottom: 1px solid #f8f9fa;
}

.table tbody tr:hover {
    background: linear-gradient(135deg, #f8f9ff 0%, rgba(102, 126, 234, 0.05) 100%);
}

/* Badges dan Labels */
.student-name {
    font-weight: 700;
    color: #343a40;
    font-size: 15px;
}

.task-title {
    color: #6c757d;
    font-style: italic;
    font-size: 14px;
}

.class-badge {
    background: linear-gradient(45deg, #28a745, #20c997);
    color: white;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.date-badge {
    background: linear-gradient(45deg, #ffc107, #fd7e14);
    padding: 8px 15px;
    border-radius: 20px;
    color: white;
    font-weight: 600;
    font-size: 13px;
    display: inline-block;
}

.file-badge {
    background: linear-gradient(45deg, #17a2b8, #6f42c1);
    color: white;
    padding: 6px 12px;
    border-radius: 15px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.5px;
}

.no-file-badge {
    background: #e9ecef;
    color: #6c757d;
    padding: 6px 12px;
    border-radius: 15px;
    font-size: 11px;
    font-weight: 600;
}

/* Action Buttons */
.btn-action {
    padding: 8px 12px;
    border-radius: 8px;
    color: white;
    text-decoration: none;
    margin: 0 3px;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.btn-view {
    background: linear-gradient(45deg, #28a745, #20c997);
    box-shadow: 0 3px 10px rgba(40, 167, 69, 0.3);
}

.btn-view:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(40, 167, 69, 0.5);
    color: white;
    text-decoration: none;
}

.btn-download {
    background: linear-gradient(45deg, #007bff, #6610f2);
    box-shadow: 0 3px 10px rgba(0, 123, 255, 0.3);
}

.btn-download:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 123, 255, 0.5);
    color: white;
    text-decoration: none;
}

/* Summary Section */
.summary-section {
    background: linear-gradient(135deg, #e9ecef 0%, #f8f9fa 100%);
    padding: 20px 25px;
    border-radius: 15px;
    margin-top: 30px;
    border-left: 5px solid #667eea;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
}

.summary-title {
    color: #495057;
    font-weight: 600;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
}

.summary-icon {
    color: #667eea;
    margin-right: 10px;
}

/* Loading States */
.loading-overlay {
    position: absolute;
    top: 0; left: 0;
    right: 0; bottom: 0;
    background: rgba(255, 255, 255, 0.9);
    z-index: 1000;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 15px;
}

.loading-spinner {
    width: 50px;
    height: 50px;
    border: 4px solid #f3f3f3;
    border-top: 4px solid #667eea;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Responsive Design */
@media (max-width: 768px) {
    .history-container {
        padding: 15px;
        margin: 10px 0;
    }
    
    .content-wrapper {
        padding: 20px;
    }
    
    .page-title {
        font-size: 2rem;
    }
    
    .stats-cards {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .form-row {
        flex-direction: column;
    }
    
    .form-group {
        margin-bottom: 15px;
    }
}

@media (max-width: 480px) {
    .stats-cards {
        grid-template-columns: 1fr;
    }
}

/* Animation untuk load */
.fade-in {
    animation: fadeIn 0.5s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
CSS);
?>

<div class="history-container fade-in">
    <div class="content-wrapper">
        <!-- Header Section -->
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-graduation-cap"></i>
                <?= Html::encode($this->title) ?>
            </h1>
            <p class="page-subtitle">Kelola dan pantau riwayat pengumpulan tugas siswa dengan interface yang modern dan intuitif</p>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-cards">
            <div class="stat-card">
                <i class="fas fa-file-alt stat-icon"></i>
                <div class="stat-number"><?= $dataProvider->totalCount ?></div>
                <div class="stat-label">Total Pengumpulan</div>
            </div>
            <div class="stat-card">
                <i class="fas fa-calendar-day stat-icon"></i>
                <div class="stat-number"><?= date('d') ?></div>
                <div class="stat-label">Hari ke-<?= date('d') ?></div>
            </div>
            <div class="stat-card">
                <i class="fas fa-calendar-alt stat-icon"></i>
                <div class="stat-number"><?= date('m') ?></div>
                <div class="stat-label">Bulan ke-<?= date('m') ?></div>
            </div>
            <div class="stat-card">
                <i class="fas fa-calendar stat-icon"></i>
                <div class="stat-number"><?= date('Y') ?></div>
                <div class="stat-label">Tahun <?= date('Y') ?></div>
            </div>
        </div>

        <!-- Enhanced Filter Section -->
        <div class="search-section">
            <div class="search-header">
                <i class="fas fa-search search-icon"></i>
                <h3 class="search-title">Filter & Pencarian Data</h3>
            </div>

            <?php $form = ActiveForm::begin([
                'method' => 'get',
                'action' => ['history'],
                'options' => ['data-pjax' => 1, 'class' => 'form-row'],
            ]); ?>

            <div class="form-group col-md-3 mb-3">
                <?= Html::label('Nama Siswa', 'nama_siswa', ['class' => 'form-label fw-bold']) ?>
                <?= Html::textInput('nama_siswa', $nama_siswa, [
                    'class' => 'form-control',
                    'placeholder' => 'Masukkan nama siswa...',
                    'autocomplete' => 'off'
                ]) ?>
            </div>

            <div class="form-group col-md-3 mb-3">
                <?= Html::label('Judul Tugas', 'judul_tugas', ['class' => 'form-label fw-bold']) ?>
                <?= Html::textInput('judul_tugas', $judul_tugas, [
                    'class' => 'form-control',
                    'placeholder' => 'Masukkan judul tugas...',
                    'autocomplete' => 'off'
                ]) ?>
            </div>

            <div class="form-group col-md-3 mb-3">
                <?= Html::label('Kelas', 'kelas', ['class' => 'form-label fw-bold']) ?>
                <?= Select2::widget([
                    'name' => 'kelas',
                    'value' => $kelas ?? '',
                    'data' => ArrayHelper::merge(
                        ['' => 'Semua Kelas'],
                        ArrayHelper::map(\app\models\Kelas::find()->orderBy('kode_kelas')->all(), 'kode_kelas', 'kode_kelas')
                    ),
                    'options' => [
                        'placeholder' => 'Pilih kelas...',
                        'class' => 'form-control'
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ]) ?>
            </div>

            <div class="form-group col-md-3 mb-3">
                <?= Html::label('Tanggal Kumpul', 'tanggal_kumpul', ['class' => 'form-label fw-bold']) ?>
                <?= DatePicker::widget([
                    'name' => 'tanggal_kumpul',
                    'value' => $tanggal_kumpul,
                    'type' => DatePicker::TYPE_INPUT,
                    'options' => [
                        'placeholder' => 'Pilih tanggal...',
                        'class' => 'form-control'
                    ],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true,
                        'clearBtn' => true
                    ]
                ]) ?>
            </div>

            <div class="form-group col-md-12 text-center">
                <?= Html::submitButton('<i class="fas fa-search"></i> Cari Data', [
                    'class' => 'btn btn-primary me-2'
                ]) ?>
                <?= Html::a('<i class="fas fa-refresh"></i> Reset Filter', ['history'], [
                    'class' => 'btn btn-outline-secondary'
                ]) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>

        <!-- Enhanced Data Grid -->
        <div class="grid-container">
            <div class="grid-header">
                <i class="fas fa-table"></i>
                <h3 class="grid-title">Data Pengumpulan Tugas</h3>
            </div>

            <?php Pjax::begin(['id' => 'history-pjax', 'enablePushState' => false, 'timeout' => 10000]); ?>

            <div class="table-responsive">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => null,
                    'layout' => "{items}\n{pager}",
                    'tableOptions' => ['class' => 'table table-hover'],
                    'columns' => [
                        [
                            'class' => 'yii\grid\SerialColumn',
                            'headerOptions' => ['style' => 'width: 60px; text-align: center;'],
                            'contentOptions' => ['style' => 'text-align: center; font-weight: bold; color: #667eea;'],
                        ],
                        [
                            'attribute' => 'nama_siswa',
                            'label' => 'Nama Siswa',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return Html::tag('div', Html::encode($model->siswa->nama ?? 'N/A'), [
                                    'class' => 'student-name'
                                ]);
                            },
                            'headerOptions' => ['style' => 'width: 200px;'],
                        ],
                        [
                            'attribute' => 'judul_tugas',
                            'label' => 'Judul Tugas',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return Html::tag('div', Html::encode($model->tugas->judul_tugas ?? 'N/A'), [
                                    'class' => 'task-title'
                                ]);
                            },
                        ],
                        [
                            'attribute' => 'kode_kelas',
                            'label' => 'Kelas',
                            'format' => 'raw',
                            'value' => function ($model) {
                                $kelas = $model->siswa->kelas->kode_kelas ?? '-';
                                return $kelas !== '-' ?
                                    Html::tag('span', $kelas, ['class' => 'class-badge']) :
                                    Html::tag('span', 'N/A', ['class' => 'no-file-badge']);
                            },
                            'contentOptions' => ['style' => 'text-align: center; width: 100px;'],
                        ],
                        [
                            'attribute' => 'tanggal_kumpul',
                            'label' => 'Tanggal Kumpul',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return Html::tag(
                                    'span',
                                    Yii::$app->formatter->asDate($model->tanggal_kumpul, 'dd MMM yyyy'),
                                    ['class' => 'date-badge']
                                );
                            },
                            'contentOptions' => ['style' => 'text-align: center; width: 150px;'],
                        ],
                        [
                            'attribute' => 'file_tugas',
                            'label' => 'File',
                            'format' => 'raw',
                            'value' => function ($model) {
                                if ($model->file_tugas) {
                                    $ext = strtoupper(pathinfo($model->file_tugas, PATHINFO_EXTENSION));
                                    return Html::tag('span', $ext, ['class' => 'file-badge']);
                                }
                                return Html::tag('span', 'No File', ['class' => 'no-file-badge']);
                            },
                            'contentOptions' => ['style' => 'text-align: center; width: 100px;'],
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{view-file}',
                            'buttons' => [
                                // 'view' => function ($url, $model) {
                                //     return Html::a('<i class="fas fa-eye"></i>', $url, [
                                //         'class' => 'btn-action btn-view',
                                //         'title' => 'Lihat Detail',
                                //         'data-pjax' => 0
                                //     ]);
                                // },
                                'view-file' => function ($url, $model) {
                                    return $model->file_tugas ? Html::a(
                                        '<i class="fas fa-download"></i>',
                                        ['view-file', 'id' => $model->id],
                                        [
                                            'class' => 'btn-action btn-download',
                                            'title' => 'Unduh File',
                                            'data-pjax' => 0,
                                            'target' => '_blank',
                                        ]
                                    ) : '';
                                }
                            ],
                            'contentOptions' => ['style' => 'text-align: center; width: 120px;'],
                            'headerOptions' => ['style' => 'width: 120px; text-align: center;'],
                        ],
                    ],
                ]); ?>
            </div>

            <?php Pjax::end(); ?>
        </div>

        <!-- Enhanced Summary Section -->
        <div class="summary-section">
            <h5 class="summary-title">
                <i class="fas fa-chart-bar summary-icon"></i>
                Ringkasan Data
            </h5>
            <p class="mb-0">
                Menampilkan <strong class="text-primary"><?= $dataProvider->count ?></strong> dari
                <strong class="text-primary"><?= $dataProvider->totalCount ?></strong> total pengumpulan tugas.
                <?php if ($dataProvider->count < $dataProvider->totalCount): ?>
                    <small class="text-muted">
                        (<?= number_format(($dataProvider->count / $dataProvider->totalCount) * 100, 1) ?>% dari total data)
                    </small>
                <?php endif; ?>
            </p>
        </div>
    </div>
</div>

<!-- Enhanced PJAX Loading Script -->
<script>
    $(document).ready(function() {
        // PJAX Loading States
        $(document).on('pjax:start', '#history-pjax', function() {
            $('.table-responsive').css('position', 'relative');
            $('.table-responsive').append('<div class="loading-overlay"><div class="loading-spinner"></div></div>');
        });

        $(document).on('pjax:end', '#history-pjax', function() {
            $('.loading-overlay').remove();
        });

        // Auto refresh every 5 minutes
        setInterval(function() {
            $.pjax.reload({
                container: '#history-pjax'
            });
        }, 300000);

        // Smooth scroll to top after filter
        $(document).on('pjax:success', '#history-pjax', function() {
            $('html, body').animate({
                scrollTop: $('.grid-container').offset().top - 20
            }, 500);
        });

        // Add fade-in animation to new content
        $(document).on('pjax:end', '#history-pjax', function() {
            $('.table').addClass('fade-in');
        });
    });
</script>