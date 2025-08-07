<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\PengumpulanTugas $model */

$this->title = 'Pengumpulan Tugas';
$this->params['breadcrumbs'][] = ['label' => 'Pengumpulan Tugas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pengumpulan-tugas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
