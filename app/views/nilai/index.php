<?php

use app\models\Nilai;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use yii\widgets\Pjax;

$this->title = '📚 Daftar Nilai Siswa';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCss(<<<CSS
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #83a4d4, #b6fbff);
    padding: 30px;
}

.nilai-index {
    max-width: 1200px;
    margin: auto;
    background: rgba(255,255,255,0.95);
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    animation: fadeInUp 0.6s ease-out;
}

.nilai-index h1 {
    text-align: center;
    color: #2c3e50;
    font-weight: 600;
    margin-bottom: 30px;
    position: relative;
}

.nilai-index h1::after {
    content: '';
    width: 80px;
    height: 4px;
    background: #3498db;
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    border-radius: 2px;
}

.btn-success {
    background: linear-gradient(45deg, #00c6ff, #0072ff);
    border: none;
    padding: 10px 25px;
    font-weight: 600;
    border-radius: 12px;
    color: white;
    transition: 0.3s ease;
    box-shadow: 0 5px 15px rgba(0, 114, 255, 0.4);
}

.btn-success:hover {
    background: linear-gradient(45deg, #0072ff, #00c6ff);
    transform: translateY(-2px);
}

.kv-grid-table th, .kv-grid-table td {
    text-align: center;
    padding: 12px;
}

.kv-grid-table tbody tr:hover {
    background: #f0f9ff;
    transition: 0.2s ease-in-out;
}

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
CSS);

// Ambil semua kode_mapel unik
$mapelList = Nilai::find()
    ->select(['kode_mapel'])
    ->distinct()
    ->where(['IS NOT', 'kode_mapel', null])
    ->orderBy('kode_mapel')
    ->asArray()
    ->all();

if (!is_array($mapelList)) {
    $mapelList = [];
}
?>

<div class="nilai-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="d-flex justify-content-between flex-wrap mb-3 text-center">
        <p><?= Html::a('➕ Tambah Nilai Baru', ['create'], ['class' => 'btn btn-success']) ?></p>
    </div>

    <?php Pjax::begin(); ?>

    <?php foreach ($mapelList as $mapel): ?>
        <h4 class="mt-5 mb-3 text-primary">📖 Nilai Mapel: <strong><?= Html::encode($mapel['kode_mapel']) ?></strong></h4>

        <?php
        $dataProviderMapel = new \yii\data\ActiveDataProvider([
            'query' => Nilai::find()->where(['kode_mapel' => $mapel['kode_mapel']])->orderBy(['semester' => SORT_ASC]),
            'pagination' => ['pageSize' => 10],
        ]);

        $gridColumns = [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'nis',
                'value' => function ($model) {
                    return $model->nis . ' - ' . ($model->siswa->nama ?? '(Nama tidak ditemukan)');
                },
                'label' => '👨‍🎓 Siswa',
            ],
            [
                'attribute' => 'nilai_angka',
                'label' => '📊 Nilai',
            ],
            [
                'attribute' => 'semester',
                'label' => '📅 Semester',
            ],
            [
                'class' => 'kartik\grid\ActionColumn',
                'header' => '⚙️ Aksi',
                'urlCreator' => function ($action, $model, $key, $index) {
                    return Url::to([$action, 'id' => $model->id]);
                },
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => fn($url) => Html::a('👁️', $url, ['title' => 'Lihat']),
                    'update' => fn($url) => Html::a('✏️', $url, ['title' => 'Ubah']),
                    'delete' => fn($url) => Html::a('🗑️', $url, [
                        'title' => 'Hapus',
                        'data-confirm' => 'Yakin ingin menghapus data ini?',
                        'data-method' => 'post',
                    ]),
                ],
            ]
        ];
        ?>

        <?= ExportMenu::widget([
            'dataProvider' => $dataProviderMapel,
            'columns' => $gridColumns,
            'target' => ExportMenu::TARGET_BLANK,
            'fontAwesome' => true,
            'dropdownOptions' => [
                'label' => 'Export Nilai ' . Html::encode($mapel['kode_mapel']),
                'class' => 'btn btn-outline-secondary mb-2',
            ],
        ]); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProviderMapel,
            'columns' => $gridColumns,
            'responsiveWrap' => false,
            'hover' => true,
            'condensed' => true,
            'bordered' => true,
            'striped' => true,
            'summary' => false,
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '📋 Daftar Nilai Mapel ' . Html::encode($mapel['kode_mapel']),
                'before' => false,
                'after' => false,
                'footer' => false,
            ],
        ]); ?>

        <hr>
    <?php endforeach; ?>

    <?php Pjax::end(); ?>
</div>