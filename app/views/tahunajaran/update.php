<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\base\Tahunajaran */

$this->title = 'Ubah Tahun ajaran: ' . ' ' . $model->kodeta;
$this->params['breadcrumbs'][] = ['label' => 'Tahun ajaran', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->kodeta, 'url' => ['view', 'id' => $model->kodeta]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tahunajaran-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
