<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\base\Jurnal */

$this->title = 'Ubah Jurnal: ' . ' ' . $model->jurnal_id;
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
