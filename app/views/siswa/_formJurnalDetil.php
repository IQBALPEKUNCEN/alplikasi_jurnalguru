<div class="form-group" id="add-jurnal-detil">
<?php
use kartik\grid\GridView;
use kartik\builder\TabularForm;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\widgets\Pjax;

$dataProvider = new ArrayDataProvider([
    'allModels' => $row,
    'pagination' => [
        'pageSize' => -1
    ]
]);
echo TabularForm::widget([
    'dataProvider' => $dataProvider,
    'formName' => 'JurnalDetil',
    'checkboxColumn' => false,
    'actionColumn' => false,
    'attributeDefaults' => [
        'type' => TabularForm::INPUT_TEXT,
    ],
    'attributes' => [
        'detil_id' => ['type' => TabularForm::INPUT_HIDDEN],
        'jurnal_id' => [
            'label' => 'Jurnal',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\app\models\base\Jurnal::find()->orderBy('jurnal_id')->asArray()->all(), 'jurnal_id', 'jurnal_id'),
                'options' => ['placeholder' => 'Choose Jurnal'],
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'nama' => ['type' => TabularForm::INPUT_TEXT],
        'status' => ['type' => TabularForm::INPUT_DROPDOWN_LIST,
                    'items' => [ 'SAKIT' => 'SAKIT', 'IZIN' => 'IZIN', 'HADIR' => 'HADIR', 'ALPA' => 'ALPA', '-' => '-', '' => '', ],
                    'options' => [
                        'columnOptions' => ['width' => '185px'],
                        'options' => ['placeholder' => 'Choose Status'],
                    ]
        ],
        'waktu_presensi' => ['type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\datecontrol\DateControl::classname(),
            'options' => [
                'type' => \kartik\datecontrol\DateControl::FORMAT_DATETIME,
                'saveFormat' => 'php:Y-m-d H:i:s',
                'ajaxConversion' => true,
                'options' => [
                    'pluginOptions' => [
                        'placeholder' => 'Choose Waktu Presensi',
                        'autoclose' => true,
                    ]
                ],
            ]
        ],
        'del' => [
            'type' => 'raw',
            'label' => '',
            'value' => function($model, $key) {
                return
                    Html::hiddenInput('Children[' . $key . '][id]', (!empty($model['id'])) ? $model['id'] : "") .
                    Html::a('<i class="glyphicon glyphicon-trash"></i>', '#', ['title' =>  'Delete', 'onClick' => 'delRowJurnalDetil(' . $key . '); return false;', 'id' => 'jurnal-detil-del-btn']);
            },
        ],
    ],
    'gridSettings' => [
        'panel' => [
            'heading' => false,
            'type' => GridView::TYPE_DEFAULT,
            'before' => false,
            'footer' => false,
            'after' => Html::button('<i class="glyphicon glyphicon-plus"></i>' . 'Add Jurnal Detil', ['type' => 'button', 'class' => 'btn btn-success kv-batch-create', 'onClick' => 'addRowJurnalDetil()']),
        ]
    ]
]);
echo  "    </div>\n\n";
?>

