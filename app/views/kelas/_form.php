<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\base\Kelas */
/* @var $form kartik\form\ActiveForm */

\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'Historykelas', 
        'relID' => 'historykelas', 
        'value' => \yii\helpers\Json::encode($model->historykelas),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'Jurnal', 
        'relID' => 'jurnal', 
        'value' => \yii\helpers\Json::encode($model->jurnals),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
?>

<div class="kelas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'kode_kelas')->textInput(['maxlength' => true, 'placeholder' => 'Kode Kelas']) ?>

    <?= $form->field($model, 'kode_jenjang')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\base\Jenjang::find()->orderBy('kode_jenjang')->asArray()->all(), 'kode_jenjang', 'kode_jenjang'),
        'options' => ['placeholder' => 'Tambah Jenjang'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <!-- <?= $form->field($model, 'kode_jurusan')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\base\Jurusan::find()->orderBy('kode_jurusan')->asArray()->all(), 'kode_jurusan', 'kode_jurusan'),
        'options' => ['placeholder' => 'Tambah Jurusan'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?> -->

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true, 'placeholder' => 'Nama']) ?>

    <!-- <?php
    $forms = [
        [
            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Html::encode('Historykelas'),
            'content' => $this->render('_formHistorykelas', [
                'row' => \yii\helpers\ArrayHelper::toArray($model->historykelas),
            ]),
        ],
        [
            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Html::encode('Jurnal'),
            'content' => $this->render('_formJurnal', [
                'row' => \yii\helpers\ArrayHelper::toArray($model->jurnals),
            ]),
        ],
    ];
    echo kartik\tabs\TabsX::widget([
        'items' => $forms,
        'position' => kartik\tabs\TabsX::POS_ABOVE,
        'encodeLabels' => false,
        'pluginOptions' => [
            'bordered' => true,
            'sideways' => true,
            'enableCache' => false,
        ],
    ]);
    ?> -->
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Tambah' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Batal'), Yii::$app->request->referrer , ['class'=> 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
