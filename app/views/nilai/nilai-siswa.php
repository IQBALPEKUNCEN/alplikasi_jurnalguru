<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = '🎓 Sistem Nilai Siswa';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCss(<<<CSS
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    padding: 20px;
}

.main-container {
    max-width: 1400px;
    margin: 0 auto;
    animation: slideInUp 0.8s ease-out;
}

/* Header Section */
.header-section {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    text-align: center;
    position: relative;
    overflow: hidden;
}

.header-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: linear-gradient(90deg, #ff6b6b, #4ecdc4, #45b7d1, #f9ca24);
    border-radius: 20px 20px 0 0;
}

.header-section h1 {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 10px;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
}

.header-section .subtitle {
    font-size: 1.1rem;
    color: #7f8c8d;
    font-weight: 400;
}

/* Filter Card */
.filter-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    border: 1px solid rgba(255,255,255,0.2);
}

.filter-header {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 25px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.filter-header:hover {
    transform: translateY(-2px);
}

.filter-header i {
    font-size: 1.5rem;
    color: #667eea;
    padding: 10px;
    background: rgba(102, 126, 234, 0.1);
    border-radius: 12px;
}

.filter-header h4 {
    font-size: 1.3rem;
    font-weight: 600;
    color: #2c3e50;
    margin: 0;
}

.form-control {
    border: 2px solid #e1e8ed;
    border-radius: 12px;
    padding: 12px 16px;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    background: #f8f9fa;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    background: white;
}

.control-label {
    font-weight: 500;
    color: #2c3e50;
    margin-bottom: 8px;
}

/* Modern Buttons */
.btn-modern {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    padding: 12px 24px;
    border-radius: 25px;
    color: white;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
    text-decoration: none;
    display: inline-block;
    margin: 5px;
}

.btn-modern:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 30px rgba(102, 126, 234, 0.4);
    color: white;
}

.btn-reset {
    background: linear-gradient(135deg, #95a5a6 0%, #7f8c8d 100%);
    box-shadow: 0 8px 20px rgba(149, 165, 166, 0.3);
}

.btn-reset:hover {
    box-shadow: 0 12px 30px rgba(149, 165, 166, 0.4);
}

.btn-success-modern {
    background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
    box-shadow: 0 8px 20px rgba(46, 204, 113, 0.3);
}

.btn-success-modern:hover {
    box-shadow: 0 12px 30px rgba(46, 204, 113, 0.4);
}

.btn-primary-modern {
    background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
    box-shadow: 0 8px 20px rgba(52, 152, 219, 0.3);
}

.btn-primary-modern:hover {
    box-shadow: 0 12px 30px rgba(52, 152, 219, 0.4);
}

/* Action Buttons Container */
.action-buttons {
    text-align: center;
    margin: 30px 0;
}

/* Table Container */
.table-container {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    overflow: hidden;
}

.table {
    border-collapse: separate;
    border-spacing: 0;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.table thead th {
    background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
    color: white;
    font-weight: 600;
    padding: 18px 12px;
    text-align: center;
    border: none;
    font-size: 0.9rem;
    position: relative;
}

.table thead th:first-child {
    border-radius: 15px 0 0 0;
}

.table thead th:last-child {
    border-radius: 0 15px 0 0;
}

.table tbody td {
    padding: 15px 12px;
    text-align: center;
    border: none;
    background: white;
    font-weight: 500;
    transition: all 0.3s ease;
}

.table tbody tr:hover td {
    background: #f8f9fa;
    transform: scale(1.01);
}

.table tbody tr:nth-child(even) td {
    background: #f8f9fa;
}

.table tbody tr:nth-child(even):hover td {
    background: #e9ecef;
}

/* Grade Badges */
.badge {
    padding: 8px 12px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    transition: all 0.3s ease;
}

.badge:hover {
    transform: scale(1.05);
}

.badge-A { 
    background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
    color: white;
}

.badge-B { 
    background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
    color: white;
}

.badge-C { 
    background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
    color: white;
}

.badge-D { 
    background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
    color: white;
}

.badge-NA { 
    background: linear-gradient(135deg, #95a5a6 0%, #7f8c8d 100%);
    color: white;
}

/* Statistics Cards */
.stats-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    padding: 25px;
    text-align: center;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    border-left: 5px solid;
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.15);
}

.stat-card.excellence { border-left-color: #2ecc71; }
.stat-card.good { border-left-color: #3498db; }
.stat-card.average { border-left-color: #f39c12; }
.stat-card.below { border-left-color: #e74c3c; }

.stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 10px;
}

.stat-label {
    font-size: 0.9rem;
    color: #7f8c8d;
    font-weight: 500;
}

/* Legend */
.legend-container {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 25px;
    margin-top: 30px;
    text-align: center;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
}

.legend-title {
    font-size: 1.4rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 20px;
}

.legend-items {
    display: flex;
    justify-content: center;
    gap: 15px;
    flex-wrap: wrap;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 15px;
    background: rgba(255, 255, 255, 0.7);
    border-radius: 12px;
    border: 1px solid rgba(0,0,0,0.1);
}

/* Alert Styles */
.alert {
    border-radius: 15px;
    padding: 20px;
    border: none;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.alert-info {
    background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
    color: white;
}

/* Animations */
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

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

/* Responsive Design */
@media (max-width: 768px) {
    .header-section h1 {
        font-size: 2rem;
    }
    
    .filter-card {
        padding: 20px;
    }
    
    .table-container {
        padding: 15px;
        overflow-x: auto;
    }
    
    .legend-items {
        flex-direction: column;
        align-items: center;
    }
    
    .btn-modern {
        width: 100%;
        margin: 5px 0;
    }
}

/* Loading Animation */
.loading-spinner {
    display: inline-block;
    width: 20px;
    height: 20px;
    border: 3px solid rgba(255,255,255,.3);
    border-radius: 50%;
    border-top-color: #fff;
    animation: spin 1s ease-in-out infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* Modern Scrollbar */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
}
CSS);
?>

<div class="main-container">
    <!-- Header Section -->
    <div class="header-section">
        <h1><?= Html::encode($this->title) ?></h1>
        <p class="subtitle">Sistem Manajemen Nilai Siswa Modern & Terintegrasi</p>
    </div>
    <!-- Filter Card -->
    <div class="filter-card">
        <div class="filter-header" data-toggle="collapse" href="#filter-form">
            <i class="fa fa-filter"></i>
            <h4>Filter & Pencarian Data Siswa</h4>
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
                            'prompt' => '🏫 Pilih Kelas...',
                            'class' => 'form-control'
                        ]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'kode_mapel', [
                            'template' => '{label}<div class="col-sm-8">{input}</div>',
                            'labelOptions' => ['class' => 'col-sm-4 control-label'],
                        ])->dropDownList($mapelList, [
                            'prompt' => '📚 Pilih Mata Pelajaran...',
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
                            'prompt' => '👤 Pilih Siswa...',
                            'class' => 'form-control'
                        ]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'kode_jurusan', [
                            'template' => '{label}<div class="col-sm-8">{input}</div>',
                            'labelOptions' => ['class' => 'col-sm-4 control-label'],
                        ])->dropDownList($jurusanList, [
                            'prompt' => '🎯 Pilih Jurusan...',
                            'class' => 'form-control'
                        ]) ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <?= Html::submitButton('<i class="fa fa-search"></i> Cari Data', [
                            'class' => 'btn-modern'
                        ]) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="action-buttons">
        <?= Html::a('<i class="fa fa-refresh"></i> Refresh Data', ['nilai-siswa'], [
            'class' => 'btn-modern btn-primary-modern'
        ]) ?>
        <!-- ?= Html::a('<i class="fa fa-file-pdf-o"></i> Download PDF', ['nilai-siswa/pdf', Yii::$app->request->queryParams], [
            'class' => 'btn-modern btn-success-modern',
            'target' => '_blank'
        ]) ?> -->
        <?= Html::a('<i class="fa fa-print"></i> Cetak Laporan', '#', [
            'class' => 'btn-modern btn-print',
            'onclick' => 'window.print(); return false;'
        ]) ?>

    </div>

    <!-- Table Container -->
    <?php if (!empty($statistikSiswa)) : ?>
        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Jurusan</th>
                            <?php foreach ($mapelList as $kode => $nama) : ?>
                                <th><?= Html::encode($nama) ?></th>
                            <?php endforeach; ?>
                            <th>Rata-rata</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($statistikSiswa as $i => $siswa) : ?>
                            <tr>
                                <td><strong><?= $i + 1 ?></strong></td>
                                <td><?= Html::encode($siswa['nis'] ?? '-') ?></td>
                                <td><strong><?= Html::encode($siswa['nama'] ?? '-') ?></strong></td>
                                <td><?= Html::encode($siswa['kelas'] ?? '-') ?></td>
                                <td><?= Html::encode($siswa['jurusan'] ?? '-') ?></td>

                                <?php foreach ($mapelList as $kode => $nama) :
                                    $nilai = $siswa['mapel'][$kode] ?? null;
                                    $angka = $nilai['nilai'] ?? '-';
                                    $predikat = $nilai['predikat'] ?? '-';

                                    $warna = 'badge-NA';
                                    if ($predikat == 'A') $warna = 'badge-A';
                                    elseif ($predikat == 'B') $warna = 'badge-B';
                                    elseif ($predikat == 'C') $warna = 'badge-C';
                                    elseif ($predikat == 'D') $warna = 'badge-D';
                                ?>
                                    <td><span class="badge <?= $warna ?>"><?= $angka ?> (<?= $predikat ?>)</span></td>
                                <?php endforeach; ?>

                                <td>
                                    <?php if (isset($siswa['rata_rata'])) {
                                        $rata = $siswa['rata_rata'];
                                        $rataWarna = 'badge-NA';
                                        if ($rata >= 86) $rataWarna = 'badge-A';
                                        elseif ($rata >= 76) $rataWarna = 'badge-B';
                                        elseif ($rata >= 66) $rataWarna = 'badge-C';
                                        elseif ($rata < 66) $rataWarna = 'badge-D';
                                        echo "<span class='badge $rataWarna'><strong>" . number_format($rata, 1) . "</strong></span>";
                                    } else {
                                        echo "<span class='badge badge-NA'>-</span>";
                                    } ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php else : ?>
        <div class="alert alert-info text-center">
            <i class="fa fa-info-circle fa-2x mb-3"></i>
            <h4>Belum Ada Data</h4>
            <p>Silakan gunakan filter di atas untuk menampilkan data nilai siswa.</p>
        </div>
    <?php endif; ?>

    <!-- Legend -->
    <div class="legend-container">
        <h5 class="legend-title">🏆 Keterangan Sistem Penilaian</h5>
        <div class="legend-items">
            <div class="legend-item">
                <span class="badge badge-A">A</span>
                <span>86–100 (Sangat Baik)</span>
            </div>
            <div class="legend-item">
                <span class="badge badge-B">B</span>
                <span>76–85 (Baik)</span>
            </div>
            <div class="legend-item">
                <span class="badge badge-C">C</span>
                <span>66–75 (Cukup)</span>
            </div>
            <div class="legend-item">
                <span class="badge badge-D">D</span>
                <span>&lt;66 (Perlu Bimbingan)</span>
            </div>
        </div>
    </div>
</div>

<script>
    // Add smooth scrolling and interactive effects
    document.addEventListener('DOMContentLoaded', function() {
        // Add loading effect to buttons
        const buttons = document.querySelectorAll('.btn-modern');
        buttons.forEach(button => {
            button.addEventListener('click', function() {
                const original = this.innerHTML;
                this.innerHTML = '<span class="loading-spinner"></span> Loading...';
                setTimeout(() => {
                    this.innerHTML = original;
                }, 1000);
            });
        });

        // Add hover effect to table rows
        const tableRows = document.querySelectorAll('tbody tr');
        tableRows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.01)';
                this.style.boxShadow = '0 5px 15px rgba(0,0,0,0.1)';
            });

            row.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
                this.style.boxShadow = 'none';
            });
        });
    });
</script>