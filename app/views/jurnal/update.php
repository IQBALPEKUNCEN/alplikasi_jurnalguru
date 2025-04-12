<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\base\Jurnal */

<<<<<<< HEAD
$this->title = 'Ubah Jurnal: ' . ' ' . $model->jurnal_id;
=======
$this->title = 'Update Jurnal: ' . ' ' . $model->jurnal_id;
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
$this->params['breadcrumbs'][] = ['label' => 'Jurnal', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->jurnal_id, 'url' => ['view', 'id' => $model->jurnal_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="jurnal-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
