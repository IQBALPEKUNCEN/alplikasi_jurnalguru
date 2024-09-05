<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\base\Tahunajaran */
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

<div class="tahunajaran-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'kodeta')->textInput(['maxlength' => true, 'placeholder' => 'Kodeta']) ?>

    <?= $form->field($model, 'semester')->dropDownList([ 'GASAL' => 'GASAL', 'GENAP' => 'GENAP', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'namata')->textInput(['maxlength' => true, 'placeholder' => 'Namata']) ?>

    <?= $form->field($model, 'isaktif')->checkbox() ?>

    <?php
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
    ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Cancel'), Yii::$app->request->referrer , ['class'=> 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
