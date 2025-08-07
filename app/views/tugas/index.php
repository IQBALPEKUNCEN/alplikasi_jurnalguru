<?php

use app\models\Tugas;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\TugasSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Manajemen Tugas';
$this->params['breadcrumbs'][] = $this->title;

// Register CSS untuk styling tambahan
$this->registerCss("
    .tugas-index {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 20px 0;
    }
    
    .main-container {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        padding: 30px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.2);
    }
    
    .page-header {
        text-align: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 3px solid #667eea;
    }
    
    .page-header h1 {
        color: #2c3e50;
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
    }
    
    .page-header .subtitle {
        color: #7f8c8d;
        font-size: 1.1rem;
        margin-top: 10px;
        font-weight: 300;
    }
    
    .action-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        padding: 15px;
        background: linear-gradient(90deg, #f8f9fa, #e9ecef);
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }
    
    .btn-create {
        background: linear-gradient(135deg, #28a745, #20c997);
        border: none;
        color: white;
        padding: 12px 25px;
        font-size: 1rem;
        font-weight: 600;
        border-radius: 25px;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
    }
    
    .btn-create:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(40, 167, 69, 0.4);
        color: white;
        text-decoration: none;
    }
    
    .btn-create::before {
        content: '✨';
        font-size: 1.2rem;
    }
    
    .grid-container {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        border: 1px solid rgba(0,0,0,0.05);
    }
    
    .grid-view table {
        margin: 0;
    }
    
    .grid-view th {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        font-weight: 600;
        padding: 15px 12px;
        border: none;
        text-align: center;
        position: relative;
    }
    
    .grid-view th::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #28a745, #20c997);
    }
    
    .grid-view td {
        padding: 15px 12px;
        border-bottom: 1px solid #f1f3f4;
        vertical-align: middle;
    }
    
    .grid-view tr:hover {
        background: linear-gradient(90deg, #f8f9ff, #fff);
        transform: scale(1.001);
        transition: all 0.2s ease;
    }
    
    .grid-view .btn {
        margin: 2px;
        padding: 5px 10px;
        font-size: 0.85rem;
        border-radius: 15px;
        transition: all 0.3s ease;
    }
    
    .grid-view .btn-primary {
        background: linear-gradient(135deg, #007bff, #0056b3);
        border: none;
        box-shadow: 0 2px 10px rgba(0, 123, 255, 0.3);
    }
    
    .grid-view .btn-info {
        background: linear-gradient(135deg, #17a2b8, #138496);
        border: none;
        box-shadow: 0 2px 10px rgba(23, 162, 184, 0.3);
    }
    
    .grid-view .btn-danger {
        background: linear-gradient(135deg, #dc3545, #c82333);
        border: none;
        box-shadow: 0 2px 10px rgba(220, 53, 69, 0.3);
    }
    
    .grid-view .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #6c757d;
    }
    
    .empty-state .icon {
        font-size: 4rem;
        margin-bottom: 20px;
        opacity: 0.5;
    }
    
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255,255,255,0.9);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }
    
    .loading-spinner {
        width: 50px;
        height: 50px;
        border: 5px solid #f3f3f3;
        border-top: 5px solid #667eea;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    .overdue {
        color: #dc3545 !important;
    }
    
    .upcoming {
        color: #ffc107 !important;
    }
    
    .normal {
        color: #28a745 !important;
    }
    
    @media (max-width: 768px) {
        .action-bar {
            flex-direction: column;
            gap: 15px;
        }
        
        .main-container {
            margin: 10px;
            padding: 20px;
        }
        
        .page-header h1 {
            font-size: 2rem;
        }
        
        .grid-view table {
            font-size: 0.9rem;
        }
    }
");

// Register JavaScript untuk interaktivitas
$this->registerJs("
    // Loading effect untuk Pjax
    $(document).on('pjax:start', function() {
        $('body').append('<div class=\"loading-overlay\"><div class=\"loading-spinner\"></div></div>');
    });
    
    $(document).on('pjax:end', function() {
        $('.loading-overlay').remove();
    });
    
    // Auto refresh setiap 5 menit
    setInterval(function() {
        $.pjax.reload({
            container: '#tugas-pjax',
            timeout: 10000
        });
    }, 300000);
");
?>

<div class="tugas-index">
    <div class="container">
        <div class="main-container">
            <div class="page-header">
                <h1><?= Html::encode($this->title) ?></h1>
                <p class="subtitle">Kelola semua tugas dengan mudah dan efisien</p>
            </div>

            <!-- Action Bar -->
            <div class="action-bar">
                <div>
                    <?= Html::a('Tambah Tugas Baru', ['create'], ['class' => 'btn-create']) ?>
                </div>
            </div>

            <!-- Pjax Container for Grid View -->
            <?php Pjax::begin([
                'id' => 'tugas-pjax',
                'enablePushState' => false,
                'timeout' => 10000,
            ]); ?>

            <!-- Grid View -->
            <div class="grid-container">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'layout' => "{summary}\n{items}\n<div class='text-center mt-3'>{pager}</div>",
                    'tableOptions' => ['class' => 'table table-hover'],
                    'summary' => '<div class="alert alert-info text-center">📊 Menampilkan <b>{begin}-{end}</b> dari <b>{totalCount}</b> tugas</div>',
                    'emptyText' => '<div class="empty-state">
                        <div class="icon">📚</div>
                        <h4>Belum ada tugas</h4>
                        <p>Mulai dengan membuat tugas pertama Anda!</p>
                        ' . Html::a('Buat Tugas Baru', ['create'], ['class' => 'btn btn-primary btn-lg']) . '
                    </div>',
                    'columns' => [
                        // [
                        //     'class' => 'yii\grid\SerialColumn',
                        //     'header' => '#',
                        //     'headerOptions' => ['style' => 'width: 60px; text-align: center;'],
                        //     'contentOptions' => ['style' => 'text-align: center; font-weight: bold;'],
                        // ],
                        [
                            'attribute' => 'id',
                            'headerOptions' => ['style' => 'width: 80px; text-align: center;'],
                            'contentOptions' => ['style' => 'text-align: center; font-weight: bold; color: #667eea;'],
                            'label' => 'No',
                        ],
                        [
                            'attribute' => 'judul_tugas',
                            'format' => 'raw',
                            'label' => '📝 Judul Tugas',
                            'value' => function ($model) {
                                return '<strong style="color: #2c3e50;">' . Html::encode($model->judul_tugas) . '</strong>';
                            },
                        ],
                        [
                            'attribute' => 'deskripsi',
                            'format' => 'raw',
                            'label' => '📄 Deskripsi',
                            'value' => function ($model) {
                                $deskripsi = $model->deskripsi ? Html::encode($model->deskripsi) : '<em style="color: #6c757d;">Tidak ada deskripsi</em>';
                                return '<div style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">' . $deskripsi . '</div>';
                            },
                        ],
                        [
                            'attribute' => 'tanggal_dibuat',
                            'format' => 'raw',
                            'label' => '📅 Tanggal Dibuat',
                            'value' => function ($model) {
                                if (!$model->tanggal_dibuat) {
                                    return '<span style="color: #6c757d;">-</span>';
                                }

                                $date = date('d/m/Y', strtotime($model->tanggal_dibuat));

                                return '<span style="color: #28a745; font-weight: 500;">' . $date . '</span>';
                            },
                            'headerOptions' => ['style' => 'width: 120px; text-align: center;'],
                            'contentOptions' => ['style' => 'text-align: center;'],
                        ],
                        [
                            'attribute' => 'tanggal_selesai',
                            'format' => 'raw',
                            'label' => '⏰ Deadline',
                            'value' => function ($model) {
                                if (!$model->tanggal_selesai) {
                                    return '<span style="color: #6c757d;">-</span>';
                                }

                                $deadline = strtotime($model->tanggal_selesai);
                                $now = time();
                                $diffDays = floor(($deadline - $now) / (24 * 60 * 60));

                                // Tentukan status berdasarkan selisih hari
                                if ($diffDays < 0) {
                                    $status = 'overdue';
                                    $icon = '🚨';
                                    $color = '#dc3545';
                                } elseif ($diffDays <= 3) {
                                    $status = 'upcoming';
                                    $icon = '⚠️';
                                    $color = '#ffc107';
                                } else {
                                    $status = 'normal';
                                    $icon = '⏳';
                                    $color = '#17a2b8';
                                }

                                $date = date('d/m/Y', $deadline);

                                return '<span style="color: ' . $color . '; font-weight: 500;">' . $icon . ' ' . $date . '</span>';
                            },
                            'headerOptions' => ['style' => 'width: 120px; text-align: center;'],
                            'contentOptions' => ['style' => 'text-align: center;'],
                        ],
                        [
                            'class' => ActionColumn::className(),
                            'header' => '⚙️ Aksi',
                            'headerOptions' => ['style' => 'width: 150px; text-align: center;'],
                            'contentOptions' => ['style' => 'text-align: center;'],
                            'template' => '{view} {update} {delete}',
                            'buttons' => [
                                'view' => function ($url, $model, $key) {
                                    return Html::a('👁️', $url, [
                                        'title' => 'Lihat Detail',
                                        'class' => 'btn btn-info btn-sm',
                                        'data-pjax' => '0',
                                    ]);
                                },
                                'update' => function ($url, $model, $key) {
                                    return Html::a('✏️', $url, [
                                        'title' => 'Edit Tugas',
                                        'class' => 'btn btn-primary btn-sm',
                                        'data-pjax' => '0',
                                    ]);
                                },
                                'delete' => function ($url, $model, $key) {
                                    return Html::a('🗑️', $url, [
                                        'title' => 'Hapus Tugas',
                                        'class' => 'btn btn-danger btn-sm',
                                        'data-confirm' => 'Apakah Anda yakin ingin menghapus tugas ini?',
                                        'data-method' => 'post',
                                        'data-pjax' => '1',
                                    ]);
                                },
                            ],
                            'urlCreator' => function ($action, Tugas $model, $key, $index, $column) {
                                return Url::toRoute([$action, 'id' => $model->id]);
                            }
                        ],
                    ],
                ]); ?>
            </div>

            <?php Pjax::end(); ?>
        </div>
    </div>
</div>