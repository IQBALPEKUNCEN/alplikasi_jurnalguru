<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\base\Hari */

<<<<<<< HEAD
$this->title = 'Ubah Hari: ' . ' ' . $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Hari', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nama, 'url' => ['view', 'id' => $model->nama]];
$this->params['breadcrumbs'][] = 'Ubah';
=======
$this->title = 'Update Hari: ' . ' ' . $model->hari_id;
$this->params['breadcrumbs'][] = ['label' => 'Hari', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->hari_id, 'url' => ['view', 'id' => $model->hari_id]];
$this->params['breadcrumbs'][] = 'Update';
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
?>
<div class="hari-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
