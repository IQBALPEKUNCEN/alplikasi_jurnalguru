<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\TugasSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Daftar Tugas';
$this->params['breadcrumbs'][] = $this->title;

// Custom CSS untuk tampilan yang lebih menarik

$this->registerCss("
.tugas-siswa-index {
    background: linear-gradient(135deg, #667eea, #764ba2);
    min-height: 100vh;
    padding: 30px 0;
    color: #333;
}

.main-container {
    background: #fff;
    border-radius: 15px;
    padding: 25px;
    max-width: 1100px;
    margin: auto;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

.page-header {
    text-align: center;
    color: white;
    padding: 40px 20px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 15px 15px 0 0;
}

.page-title {
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 5px;
}

.page-subtitle {
    font-size: 1rem;
    opacity: 0.85;
}

.stats-container {
    display: flex;
    gap: 20px;
    margin: 25px 0;
    flex-wrap: wrap;
}

.stat-card {
    flex: 1;
    min-width: 150px;
    padding: 15px;
    background: #f3f4f6;
    border-radius: 10px;
    text-align: center;
}

.stat-number {
    font-size: 1.5rem;
    font-weight: bold;
    color: #4f46e5;
}

.stat-label {
    font-size: 0.9rem;
    color: #666;
}

.grid-view table {
    background: #fff;
    border-collapse: collapse;
    width: 100%;
    margin-top: 15px;
}

.grid-view th {
    background: #4f46e5;
    color: white;
    padding: 12px;
    text-align: left;
}

.grid-view td {
    padding: 10px;
    border-bottom: 1px solid #eee;
}

.grid-view tr:nth-child(even) {
    background: #f9f9f9;
}

.grid-view tr:hover {
    background: #eef2ff;
}

.date-badge {
    display: inline-block;
    padding: 5px 10px;
    border-radius: 15px;
    background: #e0f2fe;
    color: #0284c7;
    font-size: 0.8rem;
    font-weight: 600;
}

.file-actions a {
    display: inline-block;
    padding: 6px 10px;
    font-size: 0.8rem;
    border-radius: 6px;
    color: white;
    text-decoration: none;
    margin-right: 5px;
}

.download-btn {
    background: #22c55e;
}

.preview-btn {
    background: #3b82f6;
}

.no-file {
    color: #999;
    font-style: italic;
}

.filter-container {
    background: #f8f9ff;
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 20px;
}

.filter-container input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 25px;
}

@media (max-width: 768px) {
    .stats-container {
        flex-direction: column;
    }

    .grid-view th,
    .grid-view td {
        font-size: 0.85rem;
    }
}
");


// JavaScript untuk interaktivitas dan handling download
$this->registerJs("
    // Animasi loading
    $('.grid-view').on('pjax:start', function() {
        $(this).addClass('loading');
    });
    
    $('.grid-view').on('pjax:end', function() {
        $(this).removeClass('loading');
    });
    
    // Tooltip untuk deskripsi panjang
    $('[data-toggle=\"tooltip\"]').tooltip();
    
    // Statistik dinamis
    function updateStats() {
        var totalTasks = $('.grid-view tbody tr').length;
        var urgentTasks = $('.date-deadline.urgent').length;
        var completedTasks = $('.task-completed').length;
        
        $('.stat-total').text(totalTasks);
        $('.stat-urgent').text(urgentTasks);
        $('.stat-completed').text(completedTasks);
    }
    
    // Update stats saat halaman dimuat
    updateStats();
    
    // Update stats saat filter berubah
    $(document).on('pjax:end', function() {
        updateStats();
    });
    
    // Handle download dengan loading state
    $(document).on('click', '.download-btn', function(e) {
        e.preventDefault();
        var btn = $(this);
        var originalText = btn.html();
        
        // Tampilkan loading
        btn.html('<span class=\"loading-spinner\"></span> Downloading...');
        btn.prop('disabled', true);
        
        // Buat link download tersembunyi
        var downloadUrl = btn.attr('href');
        var link = document.createElement('a');
        link.href = downloadUrl;
        link.download = '';
        link.target = '_blank';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        
        // Kembalikan button ke kondisi semula setelah delay
        setTimeout(function() {
            btn.html(originalText);
            btn.prop('disabled', false);
        }, 2000);
    });
    
    // Preview file dalam modal atau tab baru
    $(document).on('click', '.preview-btn', function(e) {
        e.preventDefault();
        var previewUrl = $(this).attr('href');
        window.open(previewUrl, '_blank');
    });
    
    // Check file existence before showing download button
    function checkFileExistence() {
        $('.download-btn').each(function() {
            var btn = $(this);
            var tugasId = btn.data('tugas-id');
            
            if (tugasId) {
                $.get('/tugas/check-file', { id: tugasId }, function(data) {
                    if (data.exists) {
                        btn.siblings('.file-info').text(data.size + ' - ' + data.extension.toUpperCase());
                    } else {
                        btn.parent().html('<span class=\"no-file\"><i class=\"fas fa-exclamation-triangle\"></i> ' + data.message + '</span>');
                    }
                });
            }
        });
    }
    
    // Jalankan check file setelah halaman dimuat
    checkFileExistence();
");
?>

<div class="tugas-siswa-index">
    <div class="main-container">
        <div class="page-header">
            <h1 class="page-title">📚 <?= Html::encode($this->title) ?></h1>
            <p class="page-subtitle">Kelola dan pantau semua tugas Anda dengan mudah</p>
        </div>

        <div class="content-wrapper">

            <!-- Widget Ringkasan -->
            <div class="summary-widget">
                <div class="summary-title">🎯 Tetap Semangat!</div>
                <div class="summary-text">Jangan lupa untuk mengerjakan tugas tepat waktu dan selalu periksa deadline.</div>
            </div>

            <!-- Grid View Container -->
            <div class="grid-container">
                <?php Pjax::begin(); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'options' => ['class' => 'grid-view'],
                    'tableOptions' => ['class' => 'table table-hover'],
                    'emptyText' => '<div class="empty-state">
                        <div class="empty-state-icon">📝</div>
                        <div class="empty-state-message">Belum ada tugas</div>
                        <div class="empty-state-subtitle">Tugas baru akan muncul di sini</div>
                    </div>',
                    'columns' => [
                        [
                            'attribute' => 'judul_tugas',
                            'label' => '📋 Judul Tugas',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return '<div class="task-title">' . Html::encode($model->judul_tugas) . '</div>';
                            },
                        ],
                        [
                            'attribute' => 'nama_kelas',
                            'label' => '🏫 Kelas',
                            'format' => 'raw',
                            'value' => function ($model) {
                                $namaKelas = $model->kelas->kode_kelas ?? '-';
                                return '<span class="kelas-badge">' . Html::encode($namaKelas) . '</span>';
                            },
                            // 'filter' => \yii\helpers\ArrayHelper::map(\app\models\base\Kelas::find()->all(), 'nama_kelas', 'kode_kelas'),
                        ],

                        [
                            'attribute' => 'deskripsi',
                            'label' => '📝 Deskripsi',
                            'format' => 'raw',
                            'value' => function ($model) {
                                $description = Html::encode($model->deskripsi);
                                $shortDesc = mb_strlen($description) > 100 ? mb_substr($description, 0, 100) . '...' : $description;
                                return '<div class="task-description" title="' . $description . '">' . $shortDesc . '</div>';
                            },
                        ],
                        [
                            'attribute' => 'tanggal_dibuat',
                            'label' => '📅 Tanggal Dibuat',
                            'format' => 'raw',
                            'value' => function ($model) {
                                $date = date('d/m/Y', strtotime($model->tanggal_dibuat));
                                return '<span class="date-badge date-created">' . $date . '</span>';
                            },
                        ],
                        [
                            'attribute' => 'tanggal_selesai',
                            'label' => '⏰ Deadline',
                            'format' => 'raw',
                            'value' => function ($model) {
                                $deadline = strtotime($model->tanggal_selesai);
                                $now = time();
                                $diff = $deadline - $now;
                                $days = floor($diff / (60 * 60 * 24));

                                $date = date('d/m/Y', $deadline);
                                $class = 'date-deadline';

                                if ($days < 0) {
                                    $class .= ' urgent';
                                    $status = '(Terlambat)';
                                } elseif ($days <= 2) {
                                    $class .= ' urgent';
                                    $status = '(Mendesak)';
                                } else {
                                    $status = '(' . $days . ' hari lagi)';
                                }

                                return '<span class="date-badge ' . $class . '">' . $date . '</span><br><small>' . $status . '</small>';
                            },
                        ],
                        [
                            'attribute' => 'file_tugas',
                            'label' => '📎 File Tugas',
                            'format' => 'raw',
                            'value' => function ($model) {
                                if ($model->file_tugas) {
                                    $extension = strtolower(pathinfo($model->file_tugas, PATHINFO_EXTENSION));
                                    $previewableTypes = ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'txt'];

                                    $html = '<div class="file-actions">';

                                    // Tombol Download
                                    $html .= Html::a(
                                        '<i class="fas fa-download"></i> Download',
                                        ['download-file', 'id' => $model->id],
                                        [
                                            'class' => 'download-btn',
                                            'data-tugas-id' => $model->id,
                                            'title' => 'Download file ' . $model->file_tugas
                                        ]
                                    );

                                    // Tombol Preview (diaktifkan kembali)
                                    // if (in_array($extension, $previewableTypes)) {
                                    //     $html .= Html::a(
                                    //         '<i class="fas fa-eye"></i> Preview',
                                    //         ['preview-file', 'id' => $model->id],
                                    //         [
                                    //             'class' => 'preview-btn',
                                    //             'title' => 'Preview file ' . $model->file_tugas
                                    //         ]
                                    //     );
                                    // }

                                    $html .= '</div>';
                                    $html .= '<div class="file-info"></div>';

                                    return $html;
                                } else {
                                    return '<span class="no-file"><i class="fas fa-minus-circle"></i> Tidak ada file</span>';
                                }
                            },
                        ],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>

<?php
// Register FontAwesome for icons
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js');
?>