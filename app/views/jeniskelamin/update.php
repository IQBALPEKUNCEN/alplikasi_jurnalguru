<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\base\Jeniskelamin */

$this->title = 'Ubah Jenis kelamin: ' . ' ' . $model->kode_jk;
$this->params['breadcrumbs'][] = ['label' => 'Jenis kelamin', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->kode_jk, 'url' => ['view', 'id' => $model->kode_jk]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="jeniskelamin-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
