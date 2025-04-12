<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\base\Tahunajaran */

<<<<<<< HEAD
$this->title = 'Tambahkan Tahun ajaran';
$this->params['breadcrumbs'][] = ['label' => 'Tahun ajaran', 'url' => ['index']];
=======
$this->title = 'Create Tahunajaran';
$this->params['breadcrumbs'][] = ['label' => 'Tahunajaran', 'url' => ['index']];
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tahunajaran-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
