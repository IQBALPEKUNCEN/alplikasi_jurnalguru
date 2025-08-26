<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\base\Historykelas */

$this->title = 'Buat Pengumuman Baru';
$this->params['breadcrumbs'][] = ['label' => 'Pengumuman', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="historykelas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
