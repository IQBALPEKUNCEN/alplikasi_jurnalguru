<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Ruangan $model */

$this->title = 'Tambahkan Ruangan';
$this->params['breadcrumbs'][] = ['label' => 'Ruangan', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ruangan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
