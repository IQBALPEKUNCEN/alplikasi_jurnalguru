<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\base\Jurnal */

<<<<<<< HEAD
$this->title = 'Tambahkan Jurnal';
=======
$this->title = 'Create Jurnal';
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
$this->params['breadcrumbs'][] = ['label' => 'Jurnal', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jurnal-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
