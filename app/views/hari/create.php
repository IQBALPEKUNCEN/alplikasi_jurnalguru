<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\base\Hari */

$this->title = 'Create Hari';
$this->params['breadcrumbs'][] = ['label' => 'Hari', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hari-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
