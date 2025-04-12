<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\base\Jenjang */

$this->title = 'Ubah Jenjang: ' . ' ' . $model->kode_jenjang;
$this->params['breadcrumbs'][] = ['label' => 'Jenjang', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->kode_jenjang, 'url' => ['view', 'id' => $model->kode_jenjang]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="jenjang-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
