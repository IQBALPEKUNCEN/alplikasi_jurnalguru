<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\base\Guru */

$this->title = 'Update Guru: ' . ' ' . $model->guru_id;
$this->params['breadcrumbs'][] = ['label' => 'Guru', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->guru_id, 'url' => ['view', 'id' => $model->guru_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="guru-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
