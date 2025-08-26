<?php

use app\models\PengumpulanTugas;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\PengumpulanTugasSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Pengumpulan Tugas';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');

// Custom CSS
$this->registerCss("
.pengumpulan-tugas-index {
    background: linear-gradient(to right, #eef2f3, #8e9eab);
    min-height: 100vh;
    padding: 30px 0;
    font-family: 'Segoe UI', sans-serif;
}

.content-wrapper {
    background-color: #ffffff;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    padding: 30px;
    margin: 20px auto;
    max-width: 1200px;
}

.page-title {
    font-size: 2.2rem;
    font-weight: 700;
    color: #2c3e50;
    text-align: center;
    margin-bottom: 5px;
}

.page-subtitle {
    text-align: center;
    color: #7f8c8d;
    font-size: 1.1rem;
    margin-bottom: 30px;
}

.stats-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stats-card {
    background: linear-gradient(135deg, #74ebd5, #acb6e5);
    color: white;
    padding: 25px;
    border-radius: 12px;
    text-align: center;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    position: relative;
    overflow: hidden;
}

.stats-card i {
    font-size: 2rem;
    margin-bottom: 10px;
    display: block;
}

.stats-number {
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 5px;
}

.stats-label {
    font-size: 0.95rem;
}

.action-buttons {
    text-align: center;
    margin-bottom: 25px;
}

.btn-create {
    background: linear-gradient(135deg, #00c6ff, #0072ff);
    border: none;
    color: white;
    padding: 12px 25px;
    font-size: 1rem;
    border-radius: 8px;
    text-decoration: none;
    transition: transform 0.2s ease;
}

.btn-create:hover {
    transform: scale(1.05);
    color: white;
}

.grid-container {
    background-color: #ffffff;
    border-radius: 12px;
    overflow: hidden;
}

.grid-view thead {
    background-color: #3498db;
}

.grid-view thead th {
    color: white;
    text-align: center;
    padding: 12px;
}

.grid-view tbody td {
    text-align: center;
    padding: 12px;
    vertical-align: middle;
    font-size: 0.95rem;
}

.grid-view tbody tr:hover {
    background-color: #f1f1f1;
}

.task-title {
    font-weight: bold;
    color: #2980b9;
    background-color: #ecf5ff;
    padding: 5px 12px;
    border-radius: 6px;
    display: inline-block;
}

.badge-file {
    background-color: #27ae60;
    color: white;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.85rem;
}

.keterangan-text {
    max-width: 180px;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
    cursor: help;
}

.action-buttons-cell .btn {
    margin: 2px;
    border-radius: 6px;
    padding: 6px 12px;
    font-size: 0.85rem;
}

.btn-view { background-color: #17a2b8; color: white; }
.btn-update { background-color: #ffc107; color: #333; }
.btn-delete { background-color: #e74c3c; color: white; }

.empty-state {
    text-align: center;
    padding: 40px 10px;
    color: #999;
    font-size: 1rem;
}

@media (max-width: 768px) {
    .stats-cards {
        grid-template-columns: 1fr;
    }
}
");
?>

<div class="pengumpulan-tugas-index">
    <div class="content-wrapper">
        <h1 class="page-title"><i class="fas fa-tasks"></i> <?= Html::encode($this->title) ?></h1>
        <p class="page-subtitle">Kelola pengumpulan tugas siswa dengan tampilan menarik dan mudah digunakan</p>

        <!-- Stats Cards -->
        <div class="stats-cards">
            <div class="stats-card">
                <i class="fas fa-clipboard-list"></i>
                <div class="stats-number"><?= $dataProvider->totalCount ?></div>
                <div class="stats-label">Total Pengumpulan</div>
            </div>
            <div class="stats-card">
                <i class="fas fa-calendar-day"></i>
                <div class="stats-number"><?= date('d') ?></div>
                <div class="stats-label">Tanggal ini</div>
            </div>
            <div class="stats-card">
                <i class="fas fa-calendar-alt"></i>
                <div class="stats-number"><?= date('m') ?></div>
                <div class="stats-label">Bulan Ini</div>
            </div>
        </div>

        <!-- Tombol Tambah -->
        <div class="action-buttons">
            <?= Html::a('<i class="fas fa-plus-circle"></i> Tambah Pengumpulan Tugas', ['create'], [
                'class' => 'btn-create'
            ]) ?>
        </div>

        <?php Pjax::begin(['id' => 'pengumpulan-tugas-pjax']); ?>

        <div class="grid-container">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'layout' => "{items}\n{summary}\n{pager}",
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        'attribute' => 'tugas_id',
                        'label' => 'Tugas',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $judul = $model->tugas->judul_tugas ?? '(Tidak ditemukan)';
                            return '<div class="task-title"><i class="fas fa-book"></i> ' . Html::encode($judul) . '</div>';
                        },
                    ],
                    [
                        'attribute' => 'nama_siswa',
                        'label' => 'Nama Siswa',
                        'value' => function ($model) {
                            return $model->siswa->nama ?? '(Tidak ditemukan)';
                        }
                    ],
                    [
                        'attribute' => 'kode_kelas',
                        'label' => 'Kelas',
                        'value' => function ($model) {
                            return $model->siswa->kelas->kode_kelas ?? '-';
                        },
                        'filter' => \yii\helpers\ArrayHelper::map(
                            \app\models\Kelas::find()->all(),
                            'kode_kelas',
                            'kode_kelas'
                        ),
                        'filterInputOptions' => ['class' => 'form-control', 'prompt' => '-- Semua Kelas --'],
                    ],
                    [
                        'attribute' => 'file_tugas',
                        'label' => 'File',
                        'format' => 'raw',
                        'value' => function ($model) {
                            if ($model->file_tugas) {
                                return '<div class="badge-file"><i class="fas fa-file"></i> ' . Html::encode($model->file_tugas) . '</div>';
                            }
                            return '<span class="text-muted"><i class="fas fa-file-slash"></i> Tidak ada file</span>';
                        }
                    ],
                    [
                        'attribute' => 'keterangan',
                        'label' => 'Keterangan',
                        'format' => 'raw',
                        'value' => function ($model) {
                            if (!$model->keterangan) {
                                return '<span class="text-muted">-</span>';
                            }
                            $keterangan = strip_tags($model->keterangan);
                            if (strlen($keterangan) > 50) {
                                $keterangan = substr($keterangan, 0, 50) . '...';
                            }
                            return '<div class="keterangan-text" title="' . Html::encode($model->keterangan) . '">' .
                                Html::encode($keterangan) . '</div>';
                        }
                    ],
                    [
                        'class' => ActionColumn::class,
                        'template' => '{view} {update} {delete}',
                        'buttons' => [
                            'view' => fn($url, $model) =>
                            Html::a('<i class="fas fa-eye"></i>', $url, ['class' => 'btn btn-view', 'title' => 'Lihat']),
                            'update' => fn($url, $model) =>
                            Html::a('<i class="fas fa-edit"></i>', $url, ['class' => 'btn btn-update', 'title' => 'Edit']),
                            'delete' => fn($url, $model) =>
                            Html::a('<i class="fas fa-trash"></i>', $url, [
                                'class' => 'btn btn-delete',
                                'data-confirm' => 'Yakin ingin menghapus data ini?',
                                'data-method' => 'post'
                            ]),
                        ],
                        'urlCreator' => fn($action, PengumpulanTugas $model) => Url::to([$action, 'id' => $model->id]),
                        'contentOptions' => ['class' => 'action-buttons-cell'],
                    ],
                ],
                'emptyText' => '<div class="empty-state"><i class="fas fa-inbox fa-2x"></i><br><br><strong>Belum ada data pengumpulan</strong><br>Silakan tambahkan terlebih dahulu.</div>',
            ]); ?>
        </div>

        <?php Pjax::end(); ?>
    </div>
</div>