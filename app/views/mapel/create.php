<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\base\Mapel */


$this->title = 'Tambahkan Mapel';

// $this->title = 'Create Mapel';

$this->params['breadcrumbs'][] = ['label' => 'Mapel', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mapel-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
