<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\date\DatePicker;
use yii\helpers\Url;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model yii\base\DynamicModel */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $kelasList array */
/* @var $mapelList array */
/* @var $siswaList array */
/* @var $statusList array */
/* @var $totalHadir int */
/* @var $totalIzin int */
/* @var $totalSakit int */
/* @var $totalAlpa int */
/* @var $statistikSiswa array */

$this->title = 'Laporan Presensi Siswa';
$this->params['breadcrumbs'][] = ['label' => 'Jurnal', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    /* Import Google Fonts */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

    /* Reset dan Base Styles */
    * {
        box-sizing: border-box;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        margin: 0;
        padding: 20px;
    }

    .jurnal-laporan-siswa {
        background: transparent;
        min-height: 100vh;
    }

    /* Header Card */
    .header-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        position: relative;
        overflow: hidden;
    }

    .header-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: linear-gradient(90deg, #ff6b6b, #4ecdc4, #45b7d1, #96ceb4, #ffeaa7);
        background-size: 300% 100%;
        animation: gradientMove 3s ease infinite;
    }

    @keyframes gradientMove {
        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    }

    .header-title {
        font-size: 2.5rem;
        font-weight: 700;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin: 0;
        text-align: center;
        margin-bottom: 10px;
    }

    .header-subtitle {
        text-align: center;
        color: #6c757d;
        font-size: 1.1rem;
        margin-bottom: 30px;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 15px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-modern {
        padding: 12px 30px;
        border: none;
        border-radius: 50px;
        font-weight: 600;
        text-decoration: none;
        color: white;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        position: relative;
        overflow: hidden;
    }

    .btn-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .btn-modern:hover::before {
        left: 100%;
    }

    .btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        text-decoration: none;
        color: white;
    }

    .btn-print {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .btn-back {
        background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
    }

    /* Filter Card */
    .filter-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        margin-bottom: 30px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        overflow: hidden;
    }

    .filter-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px 30px;
        margin: 0;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .filter-header:hover {
        background: linear-gradient(135deg, #5a67d8 0%, #6b4b9a 100%);
    }

    .filter-header h4 {
        margin: 0;
        font-weight: 600;
        font-size: 1.2rem;
    }

    .filter-body {
        padding: 30px;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-control {
        border-radius: 10px;
        border: 2px solid #e9ecef;
        padding: 12px 20px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .control-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 8px;
    }

    /* Statistics Cards */
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        padding: 30px;
        text-align: center;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
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
        background: var(--card-color);
    }

    .stat-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.2);
    }

    .stat-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 2rem;
        color: white;
        background: var(--card-color);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .stat-number {
        font-size: 3rem;
        font-weight: 700;
        color: var(--card-color);
        margin-bottom: 10px;
        line-height: 1;
    }

    .stat-label {
        font-size: 1.1rem;
        color: #6c757d;
        font-weight: 500;
    }

    .stat-card.hadir {
        --card-color: #4ecdc4;
    }

    .stat-card.izin {
        --card-color: #ffeaa7;
    }

    .stat-card.sakit {
        --card-color: #74b9ff;
    }

    .stat-card.alpa {
        --card-color: #fd79a8;
    }

    /* Data Tables */
    .data-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        margin-bottom: 30px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        overflow: hidden;
    }

    .data-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px 30px;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .data-header h4 {
        margin: 0;
        font-weight: 600;
        font-size: 1.2rem;
    }

    .data-body {
        padding: 30px;
    }

    .table {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        border: none;
        background: white;
    }

    .table thead {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .table thead th {
        color: white;
        font-weight: 600;
        border: none;
        padding: 20px 15px;
        text-align: center;
    }

    .table tbody td {
        padding: 15px;
        border-color: #f8f9fa;
        vertical-align: middle;
    }

    .table tbody tr {
        transition: all 0.3s ease;
    }

    .table tbody tr:hover {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
        transform: scale(1.02);
    }

    /* Badges */
    .badge {
        padding: 8px 15px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.9rem;
        border: none;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .badge.bg-success {
        background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
    }

    .badge.bg-warning {
        background: linear-gradient(135deg, #ffeaa7 0%, #fab1a0 100%);
        color: #2d3436;
    }

    .badge.bg-info {
        background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
    }

    .badge.bg-danger {
        background: linear-gradient(135deg, #fd79a8 0%, #e84393 100%);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .header-title {
            font-size: 2rem;
        }

        .stats-container {
            grid-template-columns: 1fr;
        }

        .action-buttons {
            flex-direction: column;
            align-items: center;
        }

        .btn-modern {
            width: 100%;
            max-width: 300px;
            justify-content: center;
        }

        .data-body {
            padding: 20px;
        }

        .table-responsive {
            border-radius: 15px;
        }
    }

    /* Print Styles */
    @media print {
        body {
            background: white !important;
            color: black !important;
        }

        .action-buttons,
        .filter-card,
        .btn-modern {
            display: none !important;
        }

        .header-card,
        .data-card,
        .stat-card {
            background: white !important;
            box-shadow: none !important;
            border: 1px solid #ddd !important;
        }

        .header-title {
            color: black !important;
        }

        .data-header,
        .filter-header {
            background: #f8f9fa !important;
            color: black !important;
        }

        .table thead {
            background: #f8f9fa !important;
        }

        .table thead th {
            color: black !important;
        }
    }

    /* Animation */
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

    .jurnal-laporan-siswa>* {
        animation: fadeInUp 0.6s ease forwards;
    }

    .stat-card:nth-child(1) {
        animation-delay: 0.1s;
    }

    .stat-card:nth-child(2) {
        animation-delay: 0.2s;
    }

    .stat-card:nth-child(3) {
        animation-delay: 0.3s;
    }

    .stat-card:nth-child(4) {
        animation-delay: 0.4s;
    }
</style>

<div class="jurnal-laporan-siswa">
    <!-- Header Card -->
    <div class="header-card">
        <h1 class="header-title"><?= Html::encode($this->title) ?></h1>
        <p class="header-subtitle">Sistem Monitoring Kehadiran Siswa Terintegrasi</p>

        <div class="action-buttons">
            <?= Html::a('<i class="fa fa-print"></i> Cetak Laporan', '#', [
                'class' => 'btn-modern btn-print',
                'onclick' => 'window.print(); return false;'
            ]) ?>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="filter-card">
        <div class="filter-header" data-toggle="collapse" href="#filter-form">
            <i class="fa fa-filter"></i>
            <h4>Filter & Pencarian Data</h4>
        </div>
        <div id="filter-form" class="panel-collapse collapse in">
            <div class="filter-body">
                <?php $form = ActiveForm::begin([
                    'method' => 'get',
                    'options' => ['class' => 'form-horizontal'],
                ]); ?>

                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'kode_kelas', [
                            'template' => '{label}<div class="col-sm-8">{input}</div>',
                            'labelOptions' => ['class' => 'col-sm-4 control-label'],
                        ])->dropDownList($kelasList, [
                            'prompt' => 'Pilih Kelas...',
                            'class' => 'form-control'
                        ]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'kode_mapel', [
                            'template' => '{label}<div class="col-sm-8">{input}</div>',
                            'labelOptions' => ['class' => 'col-sm-4 control-label'],
                        ])->dropDownList($mapelList, [
                            'prompt' => 'Pilih Mata Pelajaran...',
                            'class' => 'form-control'
                        ]) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'nis', [
                            'template' => '{label}<div class="col-sm-8">{input}</div>',
                            'labelOptions' => ['class' => 'col-sm-4 control-label'],
                        ])->dropDownList($siswaList, [
                            'prompt' => 'Pilih Siswa...',
                            'class' => 'form-control'
                        ]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'kode_jurusan', [
                            'template' => '{label}<div class="col-sm-8">{input}</div>',
                            'labelOptions' => ['class' => 'col-sm-4 control-label'],
                        ])->dropDownList($jurusanList, [
                            'prompt' => 'Pilih Jurusan...',
                            'class' => 'form-control'
                        ]) ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <?= Html::submitButton('<i class="fa fa-search"></i> Cari Data', [
                            'class' => 'btn-modern btn-print'
                        ]) ?>
                        <?= Html::a('<i class="fa fa-refresh"></i> Reset Filter', ['laporan-siswa'], [
                            'class' => 'btn-modern btn-back'
                        ]) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-container">
        <div class="stat-card hadir">
            <div class="stat-icon">
                <i class="fa fa-check"></i>
            </div>
            <div class="stat-number"><?= number_format($totalHadir) ?></div>
            <div class="stat-label">Total Hadir</div>
        </div>
        <div class="stat-card izin">
            <div class="stat-icon">
                <i class="fa fa-clock-o"></i>
            </div>
            <div class="stat-number"><?= number_format($totalIzin) ?></div>
            <div class="stat-label">Total Izin</div>
        </div>
        <div class="stat-card sakit">
            <div class="stat-icon">
                <i class="fa fa-medkit"></i>
            </div>
            <div class="stat-number"><?= number_format($totalSakit) ?></div>
            <div class="stat-label">Total Sakit</div>
        </div>
        <div class="stat-card alpa">
            <div class="stat-icon">
                <i class="fa fa-times"></i>
            </div>
            <div class="stat-number"><?= number_format($totalAlpa) ?></div>
            <div class="stat-label">Total Alpa</div>
        </div>
    </div>

    <!-- Statistik Per Siswa -->
    <?php if (!empty($statistikSiswa)): ?>
        <div class="data-card">
            <div class="data-header" data-toggle="collapse" href="#statistik-siswa">
                <i class="fa fa-bar-chart"></i>
                <h4>Statistik Kehadiran Per Siswa</h4>
            </div>
            <div id="statistik-siswa" class="panel-collapse collapse">
                <div class="data-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIS</th>
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    <th>Jurusan</th>
                                    <th>Hadir</th>
                                    <th>Izin</th>
                                    <th>Sakit</th>
                                    <th>Alpa</th>
                                    <th>Total</th>
                                    <th>Persentase</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($statistikSiswa as $siswa): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= Html::encode($siswa['nis']) ?></td>
                                        <td><?= Html::encode($siswa['nama']) ?></td>
                                        <td><?= Html::encode($siswa['kelas']) ?></td>
                                        <td><?= Html::encode($siswa['jurusan']) ?></td>
                                        <td><span class="badge bg-success"><?= $siswa['hadir'] ?></span></td>
                                        <td><span class="badge bg-warning"><?= $siswa['izin'] ?></span></td>
                                        <td><span class="badge bg-info"><?= $siswa['sakit'] ?></span></td>
                                        <td><span class="badge bg-danger"><?= $siswa['alpa'] ?></span></td>
                                        <td><strong><?= $siswa['total'] ?></strong></td>
                                        <td>
                                            <?php
                                            $persentase = $siswa['total'] > 0 ?
                                                round(($siswa['hadir'] / $siswa['total']) * 100, 2) : 0;
                                            $badgeClass = $persentase >= 80 ? 'success' : ($persentase >= 60 ? 'warning' : 'danger');
                                            ?>
                                            <span class="badge bg-<?= $badgeClass ?>"><?= $persentase ?>%</span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Detail Data Presensi -->
    <div class="data-card">
        <div class="data-header">
            <i class="fa fa-list"></i>
            <h4>Detail Data Presensi Siswa</h4>
        </div>
        <div class="data-body">
            <?php Pjax::begin(); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'tableOptions' => ['class' => 'table table-striped'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'jurnal.tanggal',
                        'label' => 'Tanggal',
                        'format' => 'date',
                    ],
                    [
                        'attribute' => 'jurnal.waktupresensi',
                        'label' => 'Waktu',
                        'format' => 'datetime',
                    ],
                    [
                        'attribute' => 'nis',
                        'label' => 'NIS',
                    ],
                    [
                        'attribute' => 'nis0.nama',
                        'label' => 'Nama Siswa',
                        'value' => function ($model) {
                            return $model->nis0 ? $model->nis0->nama : '-';
                        },
                    ],
                    [
                        'attribute' => 'nis0.kodeKelas.nama',
                        'label' => 'Kelas',
                        'value' => function ($model) {
                            return ($model->nis0 && $model->nis0->kodeKelas) ?
                                $model->nis0->kodeKelas->nama : '-';
                        },
                    ],
                    [
                        'attribute' => 'nis0.kodeKelas.kodeJurusan.nama',
                        'label' => 'Jurusan',
                        'value' => function ($model) {
                            return ($model->nis0 && $model->nis0->kodeKelas && $model->nis0->kodeKelas->kodeJurusan) ?
                                $model->nis0->kodeKelas->kodeJurusan->nama : '-';
                        },
                    ],
                    [
                        'attribute' => 'jurnal.kodeMapel.nama',
                        'label' => 'Mata Pelajaran',
                        'value' => function ($model) {
                            return ($model->jurnal && $model->jurnal->kodeMapel) ?
                                $model->jurnal->kodeMapel->nama : '-';
                        },
                    ],
                    [
                        'attribute' => 'jurnal.guru.nama',
                        'label' => 'Guru',
                        'value' => function ($model) {
                            return ($model->jurnal && $model->jurnal->guru) ?
                                $model->jurnal->guru->nama : '-';
                        },
                    ],
                    [
                        'attribute' => 'status',
                        'label' => 'Status',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $status = strtoupper($model->status);
                            $badgeClass = 'default';

                            switch ($status) {
                                case 'HADIR':
                                    $badgeClass = 'success';
                                    break;
                                case 'IZIN':
                                    $badgeClass = 'warning';
                                    break;
                                case 'SAKIT':
                                    $badgeClass = 'info';
                                    break;
                                case 'ALPA':
                                    $badgeClass = 'danger';
                                    break;
                            }

                            return "<span class='badge bg-{$badgeClass}'>{$status}</span>";
                        },
                    ],
                ],
                'summary' => 'Menampilkan {begin}-{end} dari {totalCount} data',
                'emptyText' => 'Tidak ada data yang ditemukan',
            ]); ?>

            <?php Pjax::end(); ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Auto collapse filter form if there are results
        <?php if ($dataProvider->getCount() > 0): ?>
            $('#filter-form').removeClass('in');
        <?php endif; ?>

        // Smooth scrolling for collapsible elements
        $('[data-toggle="collapse"]').on('click', function(e) {
            e.preventDefault();
            const target = $($(this).attr('href'));
            const isVisible = target.hasClass('in');

            if (!isVisible) {
                target.collapse('show');
                setTimeout(() => {
                    $('html, body').animate({
                        scrollTop: target.offset().top - 100
                    }, 500);
                }, 300);
            } else {
                target.collapse('hide');
            }
        });

        // Add loading animation to buttons
        $('.btn-modern').on('click', function() {
            if ($(this).attr('onclick')) return;

            const $btn = $(this);
            const originalText = $btn.html();

            $btn.html('<i class="fa fa-spinner fa-spin"></i> Loading...');
            $btn.prop('disabled', true);

            setTimeout(() => {
                $btn.html(originalText);
                $btn.prop('disabled', false);
            }, 1000);
        });

        // Add hover effect to table rows
        $('.table tbody tr').hover(
            function() {
                $(this).addClass('table-hover-effect');
            },
            function() {
                $(this).removeClass('table-hover-effect');
            }
        );
    });
</script>