<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use app\modules\UserManagement\components\GhostHtml;
use yii\grid\ActionColumn;

$this->title = 'Daftar Guru';
$this->params['breadcrumbs'][] = $this->title;

// Toggle search
$this->registerJs("$('.search-button').click(function(){
    $('.search-form').toggle(1000);
    return false;
});");

// Modern clean CSS
$this->registerCss(<<<CSS
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');

body {
    font-family: 'Inter', sans-serif;
    background: linear-gradient(to right, #c9d6ff, #e2e2e2);
    padding: 30px;
}

.guru-index {
    background: #fff;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    max-width: 1200px;
    margin: auto;
    animation: fadeInUp 0.5s ease-in-out;
}

.guru-index h1 {
    text-align: center;
    font-weight: 700;
    color: #1e3a8a;
    margin-bottom: 30px;
}

.btn {
    border-radius: 8px !important;
    font-weight: 600;
}

.btn-success {
    background: linear-gradient(135deg, #00c853, #43a047) !important;
    color: #fff !important;
    border: none;
}

.btn-warning {
    background: linear-gradient(135deg, #fbc02d, #f57f17) !important;
    color: #fff !important;
    border: none;
}

.btn-danger {
    background: linear-gradient(135deg, #e53935, #b71c1c) !important;
    color: #fff !important;
    border: none;
}

.btn-primary {
    background: linear-gradient(135deg, #3b82f6, #1e40af) !important;
    color: #fff !important;
    border: none;
}

.kv-grid-table thead th {
    background-color: #2c3e50;
    color: white;
    text-align: center;
}

.kv-grid-table td {
    text-align: center;
    background-color: #f9f9f9;
}

.grid-action-buttons .btn {
    font-size: 12px;
    margin: 2px;
    padding: 6px 10px;
}

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
CSS);
?>

<div class="guru-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="search-form" style="display:none">
        <?= $this->render('_search', ['model' => $searchModel]); ?>
    </div>

    <?php
    $gridColumn = [
        ['class' => 'yii\grid\SerialColumn'],
        'guru_id',
        'nama',
        [
            'attribute' => 'kode_jk',
            'label' => 'Jenis Kelamin',
            'value' => function ($model) {
                return $model->kodeJk->nama ?? $model->kode_jk;
            },
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => \yii\helpers\ArrayHelper::map(
                \app\models\base\Jeniskelamin::find()->asArray()->all(),
                'kode_jk',
                'nama'
            ),
            'filterWidgetOptions' => ['pluginOptions' => ['allowClear' => true]],
            'filterInputOptions' => ['placeholder' => 'Pilih Jenis Kelamin'],
        ],
        'nip',
        'nik',
        'tempat_lahir',
        [
            'attribute' => 'tanggal_lahir',
            'value' => function ($model) {
                return Yii::$app->formatter->asDate($model->tanggal_lahir);
            },
            'filterType' => GridView::FILTER_DATE,
            'filterWidgetOptions' => [
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd',
                ],
            ],
            'filterInputOptions' => ['placeholder' => 'Pilih Tanggal'],
        ],
        'alamat',
        'jabatan',
        [
            'class' => ActionColumn::className(),
            'template' => '{view} {update} {delete}',
            'contentOptions' => ['class' => 'grid-action-buttons text-center'],
            'buttons' => [
                'view' => fn($url, $model) => Html::a('<i class="fa fa-eye"></i>', ['view', 'id' => $model['guru_id']], ['class' => 'btn btn-primary btn-sm', 'title' => 'Lihat']),
                'update' => fn($url, $model) => Html::a('<i class="fa fa-edit"></i>', ['update', 'id' => $model['guru_id']], ['class' => 'btn btn-warning btn-sm', 'title' => 'Edit']),
                'delete' => fn($url, $model) => Html::a('<i class="fa fa-trash"></i>', ['delete', 'id' => $model['guru_id']], [
                    'class' => 'btn btn-danger btn-sm',
                    'data' => [
                        'confirm' => 'Apakah Anda yakin ingin menghapus data ini?',
                        'method' => 'post',
                    ],
                    'title' => 'Hapus',
                ]),
            ],
        ],
    ];
    ?>

    <div class="d-flex justify-content-between mb-4">
        <div>
            <?= GhostHtml::a('<i class="fa fa-plus-circle"></i> Tambah Guru', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
        <div>
            <?= ExportMenu::widget([
                'dataProvider' => $dataProvider,
                'columns' => $gridColumn,
                'target' => ExportMenu::TARGET_BLANK,
                'fontAwesome' => true,
                'dropdownOptions' => [
                    'label' => 'Export',
                    'class' => 'btn btn-default',
                    'itemsBefore' => [
                        '<li class="dropdown-header">Pilih format export</li>',
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

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumn,
        'pjax' => true,
        'responsiveWrap' => false,
        'hover' => true,
        'condensed' => true,
        'tableOptions' => ['class' => 'table table-bordered table-hover'],
        'summary' => false,
    ]); ?>

</div>