<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\base\Guru */

<<<<<<< HEAD
$this->title = 'Tambah Guru';
=======
$this->title = 'Create Guru';
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
$this->params['breadcrumbs'][] = ['label' => 'Guru', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="guru-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
