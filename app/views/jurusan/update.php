<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\base\Jurusan */

$this->title = 'Update Jurusan: ' . ' ' . $model->kode_jurusan;
$this->params['breadcrumbs'][] = ['label' => 'Jurusan', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->kode_jurusan, 'url' => ['view', 'id' => $model->kode_jurusan]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="jurusan-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
