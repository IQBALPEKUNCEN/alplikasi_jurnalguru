<?php

use app\models\Ruangan;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use kartik\export\ExportMenu;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\RuanganSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Data Ruangan';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCss(<<<CSS
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');

body {
    font-family: 'Inter', sans-serif;
    background: linear-gradient(to right, #d9afd9, #97d9e1);
    padding: 30px;
}

.ruangan-index {
    background: rgba(255, 255, 255, 0.95);
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    max-width: 950px;
    margin: auto;
    animation: fadeInUp 0.5s ease-in-out;
}

.ruangan-index h1 {
    text-align: center;
    font-weight: 700;
    margin-bottom: 30px;
    color: #2c3e50;
}

.btn-success {
    background: linear-gradient(45deg, #28a745, #218838);
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: bold;
    color: #fff;
    transition: all 0.3s ease;
}

.btn-success:hover {
    background: linear-gradient(45deg, #218838, #28a745);
    transform: scale(1.05);
}

.table {
    border-radius: 12px;
    overflow: hidden;
}

.table thead th {
    background-color: #2c3e50;
    color: #ffffff;
    text-align: center;
}

.table td {
    text-align: center;
    background-color: #f9f9f9;
    font-weight: 500;
}

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(40px); }
    to { opacity: 1; transform: translateY(0); }
}
CSS);

// Kolom untuk Export dan Grid
$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],
    'id',
    'nama',
];
?>

<div class="ruangan-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="d-flex justify-content-between flex-wrap mb-3">
        <p>
            <?= Html::a('+ Tambah Ruangan', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
        <div>
            <?= ExportMenu::widget([
                'dataProvider' => $dataProvider,
                'columns' => $gridColumns,
                'target' => ExportMenu::TARGET_BLANK,
                'fontAwesome' => true,
                'dropdownOptions' => [
                    'label' => 'Export Data',
                    'class' => 'btn btn-outline-secondary',
                    'itemsBefore' => [
                        '<li class="dropdown-header">Pilih Format</li>',
                    ],
                ],
                'exportConfig' => [
                    ExportMenu::FORMAT_HTML => false,
                    ExportMenu::FORMAT_TEXT => false,
                    ExportMenu::FORMAT_EXCEL => false,
                    ExportMenu::FORMAT_PDF => false,
                    ExportMenu::FORMAT_CSV => [
                        'icon' => 'glyphicon glyphicon-floppy-open',
                    ],
                    ExportMenu::FORMAT_EXCEL_X => [
                        'label' => 'Excel (xlsx)',
                        'icon' => 'glyphicon glyphicon-export',
                        'iconOptions' => ['class' => 'text-success'],
                        'alertMsg' => 'File Excel akan diunduh.',
                    ],
                ],
            ]) ?>
        </div>
    </div>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-bordered table-hover'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'nama',
            [
                'class' => ActionColumn::class,
                'header' => 'Aksi',
                'urlCreator' => function ($action, Ruangan $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                },
                'headerOptions' => ['style' => 'width:100px'],
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>
</div>