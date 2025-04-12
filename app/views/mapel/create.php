<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\base\Mapel */

<<<<<<< HEAD
$this->title = 'Tambahkan Mapel';
=======
$this->title = 'Create Mapel';
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
$this->params['breadcrumbs'][] = ['label' => 'Mapel', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mapel-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
