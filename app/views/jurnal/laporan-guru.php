<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\Guru;

/* @var $this yii\web\View */
/* @var $model yii\base\DynamicModel */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $kelasList array */
/* @var $mapelList array */
/* @var $statusList array */
/* @var $totalHadir int */
/* @var $totalIzin int */
/* @var $totalSakit int */
/* @var $totalAlpa int */
/* @var $statistikGuru array */

$this->title = 'Laporan Kehadiran Guru';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
$this->registerCss(<<<CSS
/* Import Google Fonts */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

/* Reset dan base styles */
* {
    box-sizing: border-box;
}

body {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    font-family: 'Poppins', sans-serif;
    min-height: 100vh;
    margin: 0;
    padding: 20px;
}

/* Container utama */
.jurnal-laporan-guru {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 15px;
}

/* Header dengan efek glassmorphism */
.page-header {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 30px;
    margin-bottom: 30px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

.page-header h1 {
    color: #ffffff;
    font-weight: 700;
    font-size: 2.5rem;
    margin: 0;
    text-align: center;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    position: relative;
}

.page-header h1::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 100px;
    height: 4px;
    background: linear-gradient(90deg, #4facfe, #00f2fe);
    border-radius: 2px;
}

/* Card filter dengan animasi */
.filter-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(15px);
    border-radius: 20px;
    padding: 30px;
    margin-bottom: 30px;
    border: 1px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.filter-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 25px 45px rgba(0, 0, 0, 0.15);
}

.filter-title {
    color: #4a5568;
    font-weight: 600;
    font-size: 1.2rem;
    margin-bottom: 20px;
    text-align: center;
}

/* Form controls */
.form-control {
    border-radius: 12px;
    border: 2px solid #e2e8f0;
    padding: 12px 15px;
    font-size: 14px;
    transition: all 0.3s ease;
    background: rgba(255, 255, 255, 0.9);
}

.form-control:focus {
    border-color: #4facfe;
    box-shadow: 0 0 0 3px rgba(79, 172, 254, 0.1);
    transform: scale(1.02);
}

/* Tombol dengan gradient */
.btn-primary {
    background: linear-gradient(45deg, #4facfe, #00f2fe);
    border: none;
    border-radius: 12px;
    padding: 12px 30px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(79, 172, 254, 0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(79, 172, 254, 0.4);
    background: linear-gradient(45deg, #00f2fe, #4facfe);
}

.btn-outline-secondary {
    color: #718096;
    border-color: #e2e8f0;
    border-radius: 12px;
    padding: 12px 30px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
}

.btn-outline-secondary:hover {
    background: linear-gradient(45deg, #718096, #4a5568);
    color: white;
    transform: translateY(-2px);
}

/* Statistik cards */
.stats-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(15px);
    border-radius: 20px;
    padding: 25px;
    text-align: center;
    border: 1px solid rgba(255, 255, 255, 0.3);
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
    background: var(--gradient);
}

.stat-card:hover {
    transform: translateY(-10px) scale(1.05);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.stat-card.success {
    --gradient: linear-gradient(90deg, #48bb78, #38a169);
}

.stat-card.warning {
    --gradient: linear-gradient(90deg, #ed8936, #dd6b20);
}

.stat-card.info {
    --gradient: linear-gradient(90deg, #4299e1, #3182ce);
}

.stat-card.danger {
    --gradient: linear-gradient(90deg, #f56565, #e53e3e);
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2d3748;
    margin: 10px 0;
}

.stat-label {
    font-size: 0.9rem;
    color: #718096;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Data cards */
.data-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(15px);
    border-radius: 20px;
    padding: 30px;
    margin-bottom: 30px;
    border: 1px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
}

.data-card h4 {
    color: #2d3748;
    font-weight: 600;
    font-size: 1.4rem;
    margin-bottom: 20px;
    text-align: center;
    position: relative;
}

.data-card h4::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 50%;
    transform: translateX(-50%);
    width: 50px;
    height: 3px;
    background: linear-gradient(90deg, #4facfe, #00f2fe);
    border-radius: 2px;
}

/* Tabel styling */
.kv-grid-table {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.kv-grid-table thead {
    background: linear-gradient(45deg, #4facfe, #00f2fe);
    color: white;
}

.kv-grid-table thead th {
    padding: 15px 10px;
    font-weight: 600;
    text-align: center;
    border: none;
}

.kv-grid-table tbody tr {
    transition: all 0.3s ease;
}

.kv-grid-table tbody tr:hover {
    background: linear-gradient(90deg, rgba(79, 172, 254, 0.1), rgba(0, 242, 254, 0.1));
    transform: scale(1.02);
}

.kv-grid-table tbody td {
    padding: 12px 10px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    text-align: center;
}

/* Responsive design */
@media (max-width: 768px) {
    .page-header h1 {
        font-size: 2rem;
    }
    
    .stats-container {
        grid-template-columns: 1fr;
    }
    
    .filter-card {
        padding: 20px;
    }
    
    .stat-number {
        font-size: 2rem;
    }
}

/* Animasi untuk loading */
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

.jurnal-laporan-guru > * {
    animation: fadeInUp 0.6s ease forwards;
}

.jurnal-laporan-guru > *:nth-child(2) {
    animation-delay: 0.1s;
}

.jurnal-laporan-guru > *:nth-child(3) {
    animation-delay: 0.2s;
}

.jurnal-laporan-guru > *:nth-child(4) {
    animation-delay: 0.3s;
}

/* Icon effects */
.stat-card::after {
    content: '';
    position: absolute;
    top: 20px;
    right: 20px;
    width: 50px;
    height: 50px;
    background: var(--gradient);
    border-radius: 50%;
    opacity: 0.1;
}
CSS);
?>

<div class="jurnal-laporan-guru">
    <!-- Header dengan efek glassmorphism -->
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <!-- Filter Card -->
    <div class="filter-card">
        <div class="filter-title">🔍 Filter Data Kehadiran</div>

        <?php $form = ActiveForm::begin([
            'method' => 'get',
            'action' => ['laporan-guru'],
        ]); ?>

        <div class="row">
            <div class="col-md-3">
                <?= $form->field($model, 'kode_kelas')->dropDownList($kelasList, [
                    'prompt' => '📚 Pilih Kelas',
                    'class' => 'form-control'
                ]) ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'kode_mapel')->dropDownList($mapelList, [
                    'prompt' => '📖 Pilih Mapel',
                    'class' => 'form-control'
                ]) ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'nip')->dropDownList(
                    ArrayHelper::map(
                        Guru::find()->orderBy('nama')->all(),
                        'nip',
                        function ($guru) {
                            return $guru->nama . ' - ' . $guru->nip;
                        }
                    ),
                    [
                        'prompt' => '👨‍🏫 Pilih Guru',
                        'class' => 'form-control'
                    ]
                ) ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'status')->dropDownList($statusList, [
                    'prompt' => '📋 Semua Status',
                    'class' => 'form-control'
                ]) ?>
            </div>
        </div>

        <div class="form-group text-center mt-3">
            <?= Html::submitButton('🔍 Filter Data', ['class' => 'btn btn-primary me-2']) ?>
            <?= Html::a('🔄 Reset Filter', ['laporan-guru'], ['class' => 'btn btn-outline-secondary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

    <!-- Statistik Cards -->
    <div class="stats-container">
        <div class="stat-card success">
            <div class="stat-number"><?= $totalHadir ?></div>
            <div class="stat-label">✅ Total Hadir</div>
        </div>
        <div class="stat-card warning">
            <div class="stat-number"><?= $totalIzin ?></div>
            <div class="stat-label">📋 Total Izin</div>
        </div>
        <div class="stat-card info">
            <div class="stat-number"><?= $totalSakit ?></div>
            <div class="stat-label">🏥 Total Sakit</div>
        </div>
        <div class="stat-card danger">
            <div class="stat-number"><?= $totalAlpa ?></div>
            <div class="stat-label">❌ Total Alpa</div>
        </div>
    </div>

    <!-- Statistik Per Guru -->
    <div class="data-card">
        <h4>📊 Statistik Kehadiran Per Guru</h4>

        <?= GridView::widget([
            'dataProvider' => new \yii\data\ArrayDataProvider([
                'allModels' => $statistikGuru,
                'pagination' => false,
            ]),
            'responsive' => true,
            'hover' => true,
            'condensed' => true,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'nama',
                    'label' => '👨‍🏫 Nama Guru',
                    'headerOptions' => ['style' => 'text-align: center'],
                ],
                [
                    'attribute' => 'nip',
                    'label' => '🔢 NIP',
                    'headerOptions' => ['style' => 'text-align: center'],
                ],
                [
                    'attribute' => 'hadir',
                    'label' => '✅ Hadir',
                    'headerOptions' => ['style' => 'text-align: center'],
                    'contentOptions' => ['style' => 'text-align: center; color: #48bb78; font-weight: bold'],
                ],
                [
                    'attribute' => 'izin',
                    'label' => '📋 Izin',
                    'headerOptions' => ['style' => 'text-align: center'],
                    'contentOptions' => ['style' => 'text-align: center; color: #ed8936; font-weight: bold'],
                ],
                [
                    'attribute' => 'sakit',
                    'label' => '🏥 Sakit',
                    'headerOptions' => ['style' => 'text-align: center'],
                    'contentOptions' => ['style' => 'text-align: center; color: #4299e1; font-weight: bold'],
                ],
                [
                    'attribute' => 'alpa',
                    'label' => '❌ Alpa',
                    'headerOptions' => ['style' => 'text-align: center'],
                    'contentOptions' => ['style' => 'text-align: center; color: #f56565; font-weight: bold'],
                ],
                [
                    'attribute' => 'total',
                    'label' => '📊 Total',
                    'headerOptions' => ['style' => 'text-align: center'],
                    'contentOptions' => ['style' => 'text-align: center; color: #2d3748; font-weight: bold; font-size: 1.1em'],
                ],
            ],
        ]) ?>
    </div>

    <!-- Data Presensi Detail -->
    <div class="data-card">
        <h4>📋 Data Presensi Guru Detail</h4>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'responsive' => true,
            'hover' => true,
            'condensed' => true,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'tanggal',
                    'format' => ['date', 'php:d-m-Y'],
                    'label' => '📅 Tanggal',
                    'headerOptions' => ['style' => 'text-align: center'],
                    'contentOptions' => ['style' => 'text-align: center'],
                ],
                [
                    'attribute' => 'waktupresensi',
                    'format' => ['time', 'php:H:i'],
                    'label' => '⏰ Waktu',
                    'headerOptions' => ['style' => 'text-align: center'],
                    'contentOptions' => ['style' => 'text-align: center'],
                ],
                [
                    'attribute' => 'guru.nama',
                    'label' => '👨‍🏫 Nama Guru',
                    'headerOptions' => ['style' => 'text-align: center'],
                ],
                [
                    'attribute' => 'kodeKelas.nama',
                    'label' => '📚 Kelas',
                    'headerOptions' => ['style' => 'text-align: center'],
                    'contentOptions' => ['style' => 'text-align: center'],
                ],
                [
                    'attribute' => 'kodeMapel.nama',
                    'label' => '📖 Mata Pelajaran',
                    'headerOptions' => ['style' => 'text-align: center'],
                ],
                [
                    'attribute' => 'status',
                    'label' => '📊 Status',
                    'headerOptions' => ['style' => 'text-align: center'],
                    'contentOptions' => ['style' => 'text-align: center; font-weight: bold'],
                    'format' => 'raw',
                    'value' => function ($model) {
                        $status = $model->status;
                        $badges = [
                            'Hadir' => '<span class="badge bg-success">✅ Hadir</span>',
                            'Izin' => '<span class="badge bg-warning">📋 Izin</span>',
                            'Sakit' => '<span class="badge bg-info">🏥 Sakit</span>',
                            'Alpa' => '<span class="badge bg-danger">❌ Alpa</span>',
                        ];
                        return $badges[$status] ?? '<span class="badge bg-secondary">' . $status . '</span>';
                    }
                ],
            ],
        ]); ?>
    </div>
</div>