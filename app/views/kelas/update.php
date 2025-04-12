<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\base\Kelas */

$this->title = 'Ubah Kelas: ' . ' ' . $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Kelas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->kode_kelas, 'url' => ['view', 'id' => $model->kode_kelas]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="kelas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
