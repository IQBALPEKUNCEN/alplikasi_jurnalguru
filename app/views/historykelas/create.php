<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\base\Historykelas */

$this->title = 'Create Historykelas';
$this->params['breadcrumbs'][] = ['label' => 'Historykelas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="historykelas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
