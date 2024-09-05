<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\base\JurnalDetil */

$this->title = 'Create Jurnal Detil';
$this->params['breadcrumbs'][] = ['label' => 'Jurnal Detil', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jurnal-detil-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
