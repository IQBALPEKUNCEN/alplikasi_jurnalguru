<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Tugas $model */

$this->title = 'Tambahkan Tugas';
$this->params['breadcrumbs'][] = ['label' => 'Tugas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tugas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
