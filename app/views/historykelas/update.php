<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\base\Historykelas */

$this->title = 'Update Historykelas: ' . ' ' . $model->history_id;
$this->params['breadcrumbs'][] = ['label' => 'Historykelas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->history_id, 'url' => ['view', 'id' => $model->history_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="historykelas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
