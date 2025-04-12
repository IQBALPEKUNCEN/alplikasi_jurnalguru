<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\base\Jeniskelamin */

$this->title = 'Tambahkan Jenis kelamin';
$this->params['breadcrumbs'][] = ['label' => 'Jenis kelamin', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jeniskelamin-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
