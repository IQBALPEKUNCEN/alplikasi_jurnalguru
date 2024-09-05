<div class="form-group" id="add-jurnal">
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
    'formName' => 'Jurnal',
    'checkboxColumn' => false,
    'actionColumn' => false,
    'attributeDefaults' => [
        'type' => TabularForm::INPUT_TEXT,
    ],
    'attributes' => [
        'jurnal_id' => ['type' => TabularForm::INPUT_HIDDEN],
        'guru_id' => [
            'label' => 'Guru',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\app\models\base\Guru::find()->orderBy('guru_id')->asArray()->all(), 'guru_id', 'guru_id'),
                'options' => ['placeholder' => 'Choose Guru'],
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'kodeta' => [
            'label' => 'Tahunajaran',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\app\models\base\Tahunajaran::find()->orderBy('kodeta')->asArray()->all(), 'kodeta', 'kodeta'),
                'options' => ['placeholder' => 'Choose Tahunajaran'],
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'jam_ke' => ['type' => TabularForm::INPUT_TEXT],
        'materi' => ['type' => TabularForm::INPUT_TEXTAREA],
        'kode_kelas' => [
            'label' => 'Kelas',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\app\models\base\Kelas::find()->orderBy('kode_kelas')->asArray()->all(), 'kode_kelas', 'kode_kelas'),
                'options' => ['placeholder' => 'Choose Kelas'],
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'kode_mapel' => [
            'label' => 'Mapel',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\app\models\base\Mapel::find()->orderBy('kode_mapel')->asArray()->all(), 'kode_mapel', 'kode_mapel'),
                'options' => ['placeholder' => 'Choose Mapel'],
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'jam_mulai' => ['type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\datecontrol\DateControl::classname(),
            'options' => [
                'type' => \kartik\datecontrol\DateControl::FORMAT_TIME,
                'saveFormat' => 'php:H:i:s',
                'ajaxConversion' => true,
                'options' => [
                    'pluginOptions' => [
                        'placeholder' => 'Choose Jam Mulai',
                        'autoclose' => true
                    ]
                ]
            ]
        ],
        'jam_selesai' => ['type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\datecontrol\DateControl::classname(),
            'options' => [
                'type' => \kartik\datecontrol\DateControl::FORMAT_TIME,
                'saveFormat' => 'php:H:i:s',
                'ajaxConversion' => true,
                'options' => [
                    'pluginOptions' => [
                        'placeholder' => 'Choose Jam Selesai',
                        'autoclose' => true
                    ]
                ]
            ]
        ],
        'status' => ['type' => TabularForm::INPUT_DROPDOWN_LIST,
                    'items' => [ 'HADIR' => 'HADIR', '-' => '-', '' => '', ],
                    'options' => [
                        'columnOptions' => ['width' => '185px'],
                        'options' => ['placeholder' => 'Choose Status'],
                    ]
        ],
        'waktupresensi' => ['type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\datecontrol\DateControl::classname(),
            'options' => [
                'type' => \kartik\datecontrol\DateControl::FORMAT_DATETIME,
                'saveFormat' => 'php:Y-m-d H:i:s',
                'ajaxConversion' => true,
                'options' => [
                    'pluginOptions' => [
                        'placeholder' => 'Choose Waktupresensi',
                        'autoclose' => true,
                    ]
                ],
            ]
        ],
        'file_siswa' => ['type' => TabularForm::INPUT_TEXT],
        'del' => [
            'type' => 'raw',
            'label' => '',
            'value' => function($model, $key) {
                return
                    Html::hiddenInput('Children[' . $key . '][id]', (!empty($model['id'])) ? $model['id'] : "") .
                    Html::a('<i class="glyphicon glyphicon-trash"></i>', '#', ['title' =>  'Delete', 'onClick' => 'delRowJurnal(' . $key . '); return false;', 'id' => 'jurnal-del-btn']);
            },
        ],
    ],
    'gridSettings' => [
        'panel' => [
            'heading' => false,
            'type' => GridView::TYPE_DEFAULT,
            'before' => false,
            'footer' => false,
            'after' => Html::button('<i class="glyphicon glyphicon-plus"></i>' . 'Add Jurnal', ['type' => 'button', 'class' => 'btn btn-success kv-batch-create', 'onClick' => 'addRowJurnal()']),
        ]
    ]
]);
echo  "    </div>\n\n";
?>

