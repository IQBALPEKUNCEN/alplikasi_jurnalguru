<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\base\Guru */

<<<<<<< HEAD
$this->title = $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Guru', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nama, 'url' => ['view', 'id' => $model->nama]];
$this->params['breadcrumbs'][] = 'Ubah'
=======
$this->title = 'Update Guru: ' . ' ' . $model->guru_id;
$this->params['breadcrumbs'][] = ['label' => 'Guru', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->guru_id, 'url' => ['view', 'id' => $model->guru_id]];
$this->params['breadcrumbs'][] = 'Update';
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
?>
<div class="guru-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
