<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\base\JurnalDetil */

$this->title = 'Update Jurnal Detil: ' . ' ' . $model->detil_id;
$this->params['breadcrumbs'][] = ['label' => 'Jurnal Detil', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->detil_id, 'url' => ['view', 'id' => $model->detil_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="jurnal-detil-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
