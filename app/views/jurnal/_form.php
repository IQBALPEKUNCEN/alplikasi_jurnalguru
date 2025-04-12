<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\widgets\TimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\base\Jurnal */
/* @var $form kartik\form\ActiveForm */

\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'JurnalDetil', 
        'relID' => 'jurnal-detil', 
        'value' => \yii\helpers\Json::encode($model->jurnalDetils),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
?>

<div class="jurnal-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <!-- <?php // $form->field($model, 'jurnal_id')->textInput(['placeholder' => 'Jurnal']) ?> -->

    <?php if ($model->isNewRecord): ?>

    <?= $form->field($model, 'guru_id')->widget(\kartik\widgets\Select2::classname(), [
    'data' => \yii\helpers\ArrayHelper::map(
        \app\models\base\Guru::find()
            ->select(["guru_id", "CONCAT(guru_id, ' - ', nama) AS nama"])
            ->orderBy('guru_id')
            ->asArray()
            ->all(), 
        'guru_id', 
        'nama'
    ),
    'options' => ['placeholder' => 'Pilih Guru'],
    'pluginOptions' => [
        'allowClear' => true,
    ],
]); ?>


    <?= $form->field($model, 'kodeta')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\base\Tahunajaran::find()->orderBy('kodeta')->asArray()->all(), 'kodeta', 'namata'),
        'options' => ['placeholder' => 'Pilih Tahun ajaran'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>
        <!-- <?php 
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'sabtu'];

        $tanggal = date('w', strtotime("2024-09-24"));

        $nama_hari = $hari[$tanggal];

        echo "Hari ini adalah:" . $nama_hari;
    ?> -->


    <!-- <?php $form->field($model, 'hari_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\base\Hari::find()->orderBy('no_urut')->asArray()->all(), 'hari_id', 'nama'),
        'options' => ['placeholder' => 'pilih Hari'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?> -->

<?= $form->field($model, 'tanggal')->widget(\kartik\widgets\DatePicker::classname(), [
    'options' => ['placeholder' => 'Pilih Tanggal'],
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'yyyy-mm-dd', // Format tanggal
        'todayHighlight' => true
    ]
]); ?>
    <?= $form->field($model, 'jam_ke')->textInput(['placeholder' => 'Jam Ke']) ?>

    <?= $form->field($model, 'kode_kelas')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\base\Kelas::find()->orderBy('kode_kelas')->asArray()->all(), 'kode_kelas', 'nama'),
        'options' => ['placeholder' => 'Pilih Kelas'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'kode_mapel')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\base\Mapel::find()->orderBy('kode_mapel')->asArray()->all(), 'kode_mapel', 'kode_mapel'),
        'options' => ['placeholder' => 'Pilih Mapel'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>
    
    <?= $form->field($model, 'jam_mulai')->widget(kartik\widgets\TimePicker::class, [
                'name' => 'jam_mulai',
                'pluginOptions' => [
                    'showSeconds' => false,
                    'showMeridian' => false,
                    'minuteStep' => 1,
                    'secondStep' => 5,
                ],
                'options' => [
                    'id' => 'jam_mulai',
                    'autofocus' => true
                ]
            ]); ?>


<?= $form->field($model, 'jam_selesai')->widget(kartik\widgets\TimePicker::class, [
                'name' => 'jam_selesai',
                'pluginOptions' => [
                    'showSeconds' => false,
                    'showMeridian' => false,
                    'minuteStep' => 1,
                    'secondStep' => 5,
                ],
                'options' => [
                    'id' => 'jam_selesai',
                    'autofocus' => true
                ]
            ]); ?>

            

<!-- <?php //$form->field($model, 'jam_mulai')->widget(\kartik\datecontrol\DateControl::className(), [
    // 'type' => \kartik\datecontrol\DateControl::FORMAT_TIME,
    // 'saveFormat' => 'php:H:i:s', // Format 24 jam
    // 'ajaxConversion' => true,
    // 'options' => [
    //     'pluginOptions' => [
    //         'placeholder' => 'Pilih Jam Mulai',
    //         'autoclose' => true,
    //         'showMeridian' => false, // Menonaktifkan AM/PM
    //     ]
    // ]
//]); ?> -->

<!-- <?php //$form->field($model, 'jam_selesai')->widget(\kartik\datecontrol\DateControl::className(), [
//     'type' => \kartik\datecontrol\DateControl::FORMAT_TIME,
//     'saveFormat' => 'php:H:i:s', // Format 24 jam
//     'ajaxConversion' => true,
//     'options' => [
//         'pluginOptions' => [
//             'placeholder' => 'Pilih Jam Selesai',
//             'autoclose' => true,
//             'showMeridian' => false, // Menonaktifkan AM/PM
//         ]
//     ]
// ]); ?> -->



    <?php else: ?>
        <?= $form->field($model, 'materi')->textarea(['rows' => 6]) ?>
    <?php endif; ?>

    <!-- <?= $form->field($model, 'status')->dropDownList([ 'HADIR' => 'HADIR', '-' => '-', '' => '', ], ['prompt' => '']) ?> -->

    <!-- <?= $form->field($model, 'waktupresensi')->widget(\kartik\datecontrol\DateControl::classname(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATETIME,
        'saveFormat' => 'php:Y-m-d H:i:s',
        'ajaxConversion' => true,
        'options' => [
            'pluginOptions' => [
                'placeholder' => 'Choose Waktupresensi',
                'autoclose' => true,
            ]
        ],
    ]); ?> -->

    <!-- <?= $form->field($model, 'file_siswa')->textInput(['maxlength' => true, 'placeholder' => 'File Siswa']) ?>  -->

    <?php
    $forms = [
        [
            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Html::encode('JurnalDetil'),
            'content' => $this->render('_formJurnalDetil', [
                'row' => \yii\helpers\ArrayHelper::toArray($model->jurnalDetils),
            ]),
        ],
    ];

    if (!$model->isNewRecord){
        $forms = [
            [
                'label' => '<i class="glyphicon glyphicon-book"></i> ' . Html::encode('JurnalDetil'),
                'content' => $this->render('_formJurnalDetil2', [
                    'row' => \yii\helpers\ArrayHelper::toArray($model->jurnalDetils),
                ]),
            ],
        ];
    }

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
        <?= Html::submitButton($model->isNewRecord ? 'Tambah' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Batal'), Yii::$app->request->referrer , ['class'=> 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
