<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\base\Tahunajaran */

$this->title = 'Tambahkan Tahun ajaran';
$this->params['breadcrumbs'][] = ['label' => 'Tahun ajaran', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tahunajaran-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
