<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\base\Kelas */

<<<<<<< HEAD
$this->title = 'Ubah Kelas: ' . ' ' . $model->nama;
=======
$this->title = 'Update Kelas: ' . ' ' . $model->kode_kelas;
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
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
