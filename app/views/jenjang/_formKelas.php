<div class="form-group" id="add-kelas">
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
    'formName' => 'Kelas',
    'checkboxColumn' => false,
    'actionColumn' => false,
    'attributeDefaults' => [
        'type' => TabularForm::INPUT_TEXT,
    ],
    'attributes' => [
        'kode_kelas' => ['type' => TabularForm::INPUT_TEXT],
        'kode_jurusan' => [
            'label' => 'Jurusan',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\app\models\base\Jurusan::find()->orderBy('kode_jurusan')->asArray()->all(), 'kode_jurusan', 'kode_jurusan'),
                'options' => ['placeholder' => 'Choose Jurusan'],
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'nama' => ['type' => TabularForm::INPUT_TEXT],
        'del' => [
            'type' => 'raw',
            'label' => '',
            'value' => function($model, $key) {
                return
                    Html::hiddenInput('Children[' . $key . '][id]', (!empty($model['id'])) ? $model['id'] : "") .
                    Html::a('<i class="glyphicon glyphicon-trash"></i>', '#', ['title' =>  'Delete', 'onClick' => 'delRowKelas(' . $key . '); return false;', 'id' => 'kelas-del-btn']);
            },
        ],
    ],
    'gridSettings' => [
        'panel' => [
            'heading' => false,
            'type' => GridView::TYPE_DEFAULT,
            'before' => false,
            'footer' => false,
            'after' => Html::button('<i class="glyphicon glyphicon-plus"></i>' . 'Add Kelas', ['type' => 'button', 'class' => 'btn btn-success kv-batch-create', 'onClick' => 'addRowKelas()']),
        ]
    ]
]);
echo  "    </div>\n\n";
?>

