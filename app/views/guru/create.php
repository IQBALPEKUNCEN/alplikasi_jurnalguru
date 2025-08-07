<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\base\Guru */


$this->title = 'Tambah Guru';


$this->params['breadcrumbs'][] = ['label' => 'Guru', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="guru-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
