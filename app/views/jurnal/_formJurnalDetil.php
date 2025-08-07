<div class="form-group" id="add-jurnal-detil">
    <?php

    use kartik\grid\GridView;
    use kartik\builder\TabularForm;
    use yii\data\ArrayDataProvider;
    use yii\helpers\Html;

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

            'nis' => [
                'label' => 'Siswa',
                'type' => TabularForm::INPUT_WIDGET,
                'widgetClass' => \kartik\widgets\Select2::className(),
                'options' => [
                    'data' => \yii\helpers\ArrayHelper::map(
                        \app\models\base\Siswa::find()
                            ->select(["jurusan", "CONCAT(nis, ' - ', nama) AS nama"])
                            ->orderBy('jurusan')
                            ->asArray()
                            ->all(),
                        'nis',
                        'nama'
                    ),
                    'options' => ['placeholder' => 'Pilih Siswa'],
                ],
                'columnOptions' => ['width' => '220px']
            ],

            'kode_jurusan' => [
                'label' => 'Jurusan',
                'type' => TabularForm::INPUT_WIDGET,
                'widgetClass' => \kartik\widgets\Select2::className(),
                'options' => [
                    'data' => \yii\helpers\ArrayHelper::map(
                        \app\models\base\Jurusan::find()->orderBy('nama')->all(),
                        'kode_jurusan',
                        'nama'
                    ),
                    'options' => ['placeholder' => 'Pilih Jurusan'],
                ],
                'columnOptions' => ['width' => '200px']
            ],

            'status' => [
                'type' => TabularForm::INPUT_DROPDOWN_LIST,
                'items' => [
                    'SAKIT' => 'SAKIT',
                    'IZIN' => 'IZIN',
                    'HADIR' => 'HADIR',
                    'ALPA' => 'ALPA',
                ],
                'options' => [
                    'placeholder' => 'Pilih Status',
                ],
                'columnOptions' => ['width' => '150px']
            ],

            // 'waktu_presensi' => [
            //     'type' => TabularForm::INPUT_WIDGET,
            //     'widgetClass' => \kartik\datecontrol\DateControl::className(),
            //     'options' => [
            //         'type' => \kartik\datecontrol\DateControl::FORMAT_DATETIME,
            //         'saveFormat' => 'php:Y-m-d H:i:s',
            //         'ajaxConversion' => true,
            //         'options' => [
            //             'pluginOptions' => [
            //                 'placeholder' => 'Pilih Waktu Presensi',
            //                 'autoclose' => true,
            //             ]
            //         ],
            //     ],
            //     'columnOptions' => ['width' => '200px']
            // ],

            'del' => [
                'type' => 'raw',
                'label' => '',
                'value' => function ($model, $key) {
                    return
                        Html::hiddenInput('Children[' . $key . '][id]', (!empty($model['id'])) ? $model['id'] : "") .
                        Html::a('<i class="glyphicon glyphicon-trash"></i>', '#', [
                            'title' => 'Hapus',
                            'onClick' => 'delRowJurnalDetil(' . $key . '); return false;',
                            'id' => 'jurnal-detil-del-btn'
                        ]);
                },
            ],
        ],
        'gridSettings' => [
            'panel' => [
                'heading' => '<i class="fa fa-book"></i> Detail Jurnal (Opsional)',
                'type' => GridView::TYPE_PRIMARY,
                'before' => false,
                'footer' => false,
                'after' => Html::button(
                    '<i class="glyphicon glyphicon-plus"></i> Tambah Jurnal Detil',
                    [
                        'type' => 'button',
                        'class' => 'btn btn-success kv-batch-create',
                        'onClick' => 'addRowJurnalDetil()'
                    ]
                ),
            ]
        ]
    ]);
    ?>
</div>