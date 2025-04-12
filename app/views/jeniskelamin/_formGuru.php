<div class="form-group" id="add-guru">
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
    'formName' => 'Guru',
    'checkboxColumn' => false,
    'actionColumn' => false,
    'attributeDefaults' => [
        'type' => TabularForm::INPUT_TEXT,
    ],
    'attributes' => [
        'guru_id' => ['type' => TabularForm::INPUT_TEXT],
        'nama' => ['type' => TabularForm::INPUT_TEXT],
        'nip' => ['type' => TabularForm::INPUT_TEXT],
        'nik' => ['type' => TabularForm::INPUT_TEXT],
        'tempat_lahir' => ['type' => TabularForm::INPUT_TEXT],
        'tanggal_lahir' => ['type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\datecontrol\DateControl::classname(),
            'options' => [
                'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
                'saveFormat' => 'php:Y-m-d',
                'ajaxConversion' => true,
                'options' => [
                    'pluginOptions' => [
                        'placeholder' => 'Choose Tanggal Lahir',
                        'autoclose' => true
                    ]
                ],
            ]
        ],
        'alamat' => ['type' => TabularForm::INPUT_TEXT],
        'del' => [
            'type' => 'raw',
            'label' => '',
            'value' => function($model, $key) {
                return
                    Html::hiddenInput('Children[' . $key . '][id]', (!empty($model['id'])) ? $model['id'] : "") .
                    Html::a('<i class="glyphicon glyphicon-trash"></i>', '#', ['title' =>  'Delete', 'onClick' => 'delRowGuru(' . $key . '); return false;', 'id' => 'guru-del-btn']);
            },
        ],
    ],
    'gridSettings' => [
        'panel' => [
            'heading' => false,
            'type' => GridView::TYPE_DEFAULT,
            'before' => false,
            'footer' => false,
            'after' => Html::button('<i class="glyphicon glyphicon-plus"></i>' . 'Add Guru', ['type' => 'button', 'class' => 'btn btn-success kv-batch-create', 'onClick' => 'addRowGuru()']),
        ]
    ]
]);
echo  "    </div>\n\n";
?>

