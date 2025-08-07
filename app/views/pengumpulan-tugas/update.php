<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\PengumpulanTugas $model */

$this->title = 'Update Pengumpulan Tugas: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pengumpulan Tugas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pengumpulan-tugas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
