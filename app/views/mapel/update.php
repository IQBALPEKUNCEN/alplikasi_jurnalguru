<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\base\Mapel */

<<<<<<< HEAD
$this->title = 'Ubah Mapel: ' . ' ' . $model->kode_mapel;
=======
$this->title = 'Update Mapel: ' . ' ' . $model->kode_mapel;
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
$this->params['breadcrumbs'][] = ['label' => 'Mapel', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->kode_mapel, 'url' => ['view', 'id' => $model->kode_mapel]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mapel-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
