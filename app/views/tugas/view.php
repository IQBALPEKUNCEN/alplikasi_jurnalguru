<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Tugas $model */

$this->title = $model->judul_tugas;
$this->params['breadcrumbs'][] = ['label' => 'Tugas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

// Custom CSS untuk tampilan yang lebih menarik
$this->registerCss("
    .tugas-view {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 20px 0;
    }
    
    .tugas-container {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(10px);
        overflow: hidden;
        margin: 0 auto;
        max-width: 1000px;
    }
    
    .tugas-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 30px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    
    .tugas-header::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: pulse 4s ease-in-out infinite;
    }
    
    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 0.5; }
        50% { transform: scale(1.1); opacity: 0.8; }
    }
    
    .tugas-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        position: relative;
        z-index: 1;
    }
    
    .tugas-id {
        font-size: 1rem;
        opacity: 0.9;
        margin-top: 5px;
        position: relative;
        z-index: 1;
    }
    
    .tugas-content {
        padding: 30px;
    }
    
    .action-buttons {
        display: flex;
        gap: 15px;
        margin-bottom: 30px;
        justify-content: center;
        flex-wrap: wrap;
    }
    
    .btn-modern {
        padding: 12px 30px;
        border-radius: 25px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        position: relative;
        overflow: hidden;
    }
    
    .btn-modern::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        transition: width 0.3s, height 0.3s;
    }
    
    .btn-modern:hover::before {
        width: 300px;
        height: 300px;
    }
    
    .btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
    }
    
    .btn-primary-modern {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
    }
    
    .btn-danger-modern {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
        color: white;
        border: none;
    }
    
    .detail-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-top: 20px;
    }
    
    .detail-view-custom {
        border: none;
        margin: 0;
    }
    
    .detail-view-custom tr:nth-child(even) {
        background: #f8f9ff;
    }
    
    .detail-view-custom th {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        font-weight: 600;
        padding: 15px 20px;
        border: none;
        width: 200px;
        position: relative;
    }
    
    .detail-view-custom th::after {
        content: '';
        position: absolute;
        top: 50%;
        right: 10px;
        width: 0;
        height: 0;
        border-left: 8px solid rgba(255, 255, 255, 0.5);
        border-top: 5px solid transparent;
        border-bottom: 5px solid transparent;
        transform: translateY(-50%);
    }
    
    .detail-view-custom td {
        padding: 15px 20px;
        border: none;
        font-size: 1rem;
        line-height: 1.6;
    }
    
    .status-badge {
        display: inline-block;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 600;
        margin-left: 10px;
    }
    
    .status-active {
        background: #4CAF50;
        color: white;
    }
    
    .status-pending {
        background: #FF9800;
        color: white;
    }
    
    .file-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #667eea;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s ease;
    }
    
    .file-link:hover {
        color: #764ba2;
    }
    
    .info-icon {
        width: 20px;
        height: 20px;
        margin-right: 8px;
        opacity: 0.7;
    }
    
    @media (max-width: 768px) {
        .tugas-title {
            font-size: 2rem;
        }
        
        .tugas-content {
            padding: 20px;
        }
        
        .action-buttons {
            flex-direction: column;
            align-items: center;
        }
        
        .btn-modern {
            width: 100%;
            max-width: 300px;
        }
        
        .detail-view-custom th {
            width: 120px;
            font-size: 0.9rem;
        }
    }
");
?>

<div class="tugas-view">
    <div class="tugas-container">
        <div class="tugas-header">
            <h1 class="tugas-title"><?= Html::encode($model->judul_tugas) ?></h1>
            <div class="tugas-id">ID: <?= Html::encode($model->id) ?></div>
        </div>

        <div class="tugas-content">
            <div class="action-buttons">
                <?= Html::a(
                    '<i class="fas fa-edit"></i> Update Tugas',
                    ['update', 'id' => $model->id],
                    ['class' => 'btn btn-modern btn-primary-modern']
                ) ?>
                <?= Html::a(
                    '<i class="fas fa-trash"></i> Hapus Tugas',
                    ['delete', 'id' => $model->id],
                    [
                        'class' => 'btn btn-modern btn-danger-modern',
                        'data' => [
                            'confirm' => 'Apakah Anda yakin ingin menghapus tugas ini?',
                            'method' => 'post',
                        ],
                    ]
                ) ?>
            </div>

            <div class="detail-card">
                <?= DetailView::widget([
                    'model' => $model,
                    'options' => ['class' => 'detail-view-custom'],
                    'attributes' => [
                        [
                            'attribute' => 'judul_tugas',
                            'label' => '📚 Judul Tugas',
                            'value' => $model->judul_tugas,
                        ],
                        [
                            'attribute' => 'deskripsi',
                            'label' => '📝 Deskripsi',
                            'value' => $model->deskripsi,
                            'format' => 'ntext',
                        ],
                        [
                            'attribute' => 'tanggal_dibuat',
                            'label' => '📅 Tanggal Dibuat',
                            'value' => function ($model) {
                                return date('d F Y, H:i', strtotime($model->tanggal_dibuat));
                            },
                        ],
                        [
                            'attribute' => 'tanggal_selesai',
                            'label' => '⏰ Deadline',
                            'value' => function ($model) {
                                $deadline = date('d F Y, H:i', strtotime($model->tanggal_selesai));
                                $now = time();
                                $deadlineTime = strtotime($model->tanggal_selesai);

                                if ($deadlineTime > $now) {
                                    $status = '<span class="status-badge status-active">Aktif</span>';
                                } else {
                                    $status = '<span class="status-badge status-pending">Berakhir</span>';
                                }

                                return $deadline . $status;
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'kode_mapel',
                            'label' => '📖 Kode Mata Pelajaran',
                            'value' => $model->kode_mapel,
                        ],
                        [
                            'attribute' => 'kode_kelas',
                            'label' => '🏫 Kode Kelas',
                            'value' => $model->kode_kelas,
                        ],
                        [
                            'attribute' => 'guru_id',
                            'label' => '👨‍🏫 ID Guru',
                            'value' => $model->guru_id,
                        ],
                        [
                            'attribute' => 'file_tugas',
                            'label' => '📎 File Tugas',
                            'value' => function ($model) {
                                if ($model->file_tugas) {
                                    return Html::a(
                                        '<i class="fas fa-download"></i> Download File',
                                        ['download', 'file' => $model->file_tugas],
                                        ['class' => 'file-link', 'target' => '_blank']
                                    );
                                } else {
                                    return '<span style="color: #999;">Tidak ada file</span>';
                                }
                            },
                            'format' => 'raw',
                        ],
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>

<?php
// Register FontAwesome for icons
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js');
?>