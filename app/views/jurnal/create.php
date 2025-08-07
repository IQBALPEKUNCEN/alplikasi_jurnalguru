<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\base\Jurnal */


$this->title = 'Tambahkan Jurnal';

// $this->title = 'Create Jurnal';

$this->params['breadcrumbs'][] = ['label' => 'Jurnal', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jurnal-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
