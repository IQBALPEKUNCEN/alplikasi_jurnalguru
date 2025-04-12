<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\base\Tahunajaran */

<<<<<<< HEAD
$this->title = 'Ubah Tahun ajaran: ' . ' ' . $model->kodeta;
$this->params['breadcrumbs'][] = ['label' => 'Tahun ajaran', 'url' => ['index']];
=======
$this->title = 'Update Tahunajaran: ' . ' ' . $model->kodeta;
$this->params['breadcrumbs'][] = ['label' => 'Tahunajaran', 'url' => ['index']];
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
$this->params['breadcrumbs'][] = ['label' => $model->kodeta, 'url' => ['view', 'id' => $model->kodeta]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tahunajaran-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
