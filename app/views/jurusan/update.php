<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\base\Jurusan */

<<<<<<< HEAD
$this->title = 'Ubah Jurusan: ' . ' ' . $model->kode_jurusan;
=======
$this->title = 'Update Jurusan: ' . ' ' . $model->kode_jurusan;
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
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
