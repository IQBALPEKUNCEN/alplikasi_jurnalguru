<?php

namespace app\controllers;

use app\models\base\Jurusan;
use app\models\base\Kelas;
use app\models\base\Mapel;
use app\models\base\Siswa;
use app\models\Nilai;
use app\models\NilaiSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\mpdf\Pdf;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;



class NilaiController extends Controller
{
    public function behaviors()
    {
        return [
            'ghost-access' => [
                'class' => 'app\modules\UserManagement\components\GhostAccessControl',
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }
    
    public function actionIndex()
    {
        $searchModel = new NilaiSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Nilai();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }


// Perbaikan untuk actionNilaiSiswa()

public function actionNilaiSiswa()
{
    $model = new \yii\base\DynamicModel([
        'kode_kelas',
        'kode_mapel',
        'nis',
        'semester',
        'tahun_ajaran',
        'kode_jurusan'
    ]);

    $model->addRule([
        'kode_kelas',
        'kode_mapel',
        'nis',
        'semester',
        'tahun_ajaran',
        'kode_jurusan'
    ], 'safe');

    // DEBUG: Tambahkan logging untuk melihat query yang dijalankan
    \Yii::$app->db->enableLogging = true;
    
    // Perbaikan 1: Gunakan LEFT JOIN untuk menghindari data hilang
    $query = \app\models\Nilai::find()
        ->leftJoin('siswa', 'nilai.nis = siswa.nis')
        ->leftJoin('kelas', 'siswa.kode_kelas = kelas.kode_kelas')
        ->leftJoin('jurusan', 'kelas.kode_jurusan = jurusan.kode_jurusan')
        ->leftJoin('mapel', 'nilai.kode_mapel = mapel.kode_mapel')
        ->with(['siswa', 'mapel', 'siswa.kodeKelas', 'siswa.kodeKelas.kodeJurusan'])
        ->orderBy(['nilai.tahun_ajaran' => SORT_DESC, 'nilai.semester' => SORT_DESC]);

    if ($model->load(Yii::$app->request->get()) && $model->validate()) {
        if (!empty($model->kode_kelas)) {
            $query->andWhere(['siswa.kode_kelas' => $model->kode_kelas]);
        }
        if (!empty($model->kode_mapel)) {
            $query->andWhere(['nilai.kode_mapel' => $model->kode_mapel]);
        }
        if (!empty($model->nis)) {
            $query->andWhere(['nilai.nis' => $model->nis]);
        }
        if (!empty($model->semester)) {
            $query->andWhere(['nilai.semester' => $model->semester]);
        }
        if (!empty($model->tahun_ajaran)) {
            $query->andWhere(['nilai.tahun_ajaran' => $model->tahun_ajaran]);
        }
        if (!empty($model->kode_jurusan)) {
            $query->andWhere(['kelas.kode_jurusan' => $model->kode_jurusan]);
        }
    }

    // DEBUG: Log query yang dijalankan
    $rawSql = $query->createCommand()->getRawSql();
    Yii::info("Query SQL: " . $rawSql, __METHOD__);

    $dataProvider = new \yii\data\ActiveDataProvider([
        'query' => $query,
        'pagination' => ['pageSize' => 50],
    ]);

    // Perbaikan 2: Tambahkan validasi data sebelum memproses
    $models = $dataProvider->getModels();
    Yii::info("Jumlah data ditemukan: " . count($models), __METHOD__);

    // Statistik dan nilai per mapel per siswa
    $statistikSiswa = [];

    foreach ($models as $nilai) {
        // Perbaikan 3: Validasi relasi sebelum mengakses
        if (!$nilai->siswa) {
            Yii::warning("Siswa tidak ditemukan untuk NIS: " . $nilai->nis, __METHOD__);
            continue;
        }

        $siswa = $nilai->siswa;
        $nis = $siswa->nis;
        $kodeMapel = $nilai->kode_mapel;
        $angka = $nilai->nilai_angka;

        if (!isset($statistikSiswa[$nis])) {
            $statistikSiswa[$nis] = [
                'nama' => $siswa->nama ?? 'Tidak Diketahui',
                'nis' => $nis,
                'kelas' => ($siswa->kodeKelas) ? $siswa->kodeKelas->nama : '-',
                'jurusan' => ($siswa->kodeKelas && $siswa->kodeKelas->kodeJurusan) ? $siswa->kodeKelas->kodeJurusan->nama : '-',
                'jumlah_mapel' => 0,
                'total_nilai' => 0,
                'rata_rata' => 0,
                'mapel' => []
            ];
        }

        $predikat = '-';
        if ($angka !== null && is_numeric($angka)) {
            if ($angka >= 86) $predikat = 'A';
            elseif ($angka >= 76) $predikat = 'B';
            elseif ($angka >= 66) $predikat = 'C';
            else $predikat = 'D';

            $statistikSiswa[$nis]['mapel'][$kodeMapel] = [
                'nilai' => $angka,
                'predikat' => $predikat
            ];

            $statistikSiswa[$nis]['jumlah_mapel']++;
            $statistikSiswa[$nis]['total_nilai'] += $angka;
            $statistikSiswa[$nis]['rata_rata'] = $statistikSiswa[$nis]['total_nilai'] / $statistikSiswa[$nis]['jumlah_mapel'];
        }
    }

    // Urutkan berdasarkan nama siswa
    uasort($statistikSiswa, function ($a, $b) {
        return strcmp($a['nama'], $b['nama']);
    });

    // Perbaikan 4: Load data referensi dengan error handling yang lebih baik
    $kelasList = [];
    $mapelList = [];
    $siswaList = [];
    $jurusanList = [];

    try {
        $kelasList = \yii\helpers\ArrayHelper::map(
            \app\models\Kelas::find()->orderBy('nama')->all(), 
            'kode_kelas', 
            'nama'
        );
        Yii::info("Berhasil memuat " . count($kelasList) . " kelas", __METHOD__);
    } catch (\Exception $e) {
        Yii::error("Gagal memuat data kelas: " . $e->getMessage(), __METHOD__);
    }

    try {
        $mapelList = \yii\helpers\ArrayHelper::map(
            \app\models\Mapel::find()->orderBy('nama')->all(), 
            'kode_mapel', 
            'nama'
        );
        Yii::info("Berhasil memuat " . count($mapelList) . " mapel", __METHOD__);
    } catch (\Exception $e) {
        Yii::error("Gagal memuat data mapel: " . $e->getMessage(), __METHOD__);
    }

    try {
        $siswaList = \yii\helpers\ArrayHelper::map(
            \app\models\Siswa::find()->orderBy('nama')->all(),
            'nis',
            function ($siswa) {
                return $siswa->nama . ' (' . $siswa->nis . ')';
            }
        );
        Yii::info("Berhasil memuat " . count($siswaList) . " siswa", __METHOD__);
    } catch (\Exception $e) {
        Yii::error("Gagal memuat data siswa: " . $e->getMessage(), __METHOD__);
    }

    try {
        $jurusanList = \yii\helpers\ArrayHelper::map(
            \app\models\Jurusan::find()->orderBy('nama')->all(), 
            'kode_jurusan', 
            'nama'
        );
        Yii::info("Berhasil memuat " . count($jurusanList) . " jurusan", __METHOD__);
    } catch (\Exception $e) {
        Yii::error("Gagal memuat data jurusan: " . $e->getMessage(), __METHOD__);
    }

    // DEBUG: Log statistik yang dihasilkan
    Yii::info("Statistik siswa dihasilkan: " . count($statistikSiswa), __METHOD__);

    return $this->render('nilai-siswa', [
        'model' => $model,
        'dataProvider' => $dataProvider,
        'kelasList' => $kelasList,
        'mapelList' => $mapelList,
        'siswaList' => $siswaList,
        'jurusanList' => $jurusanList,
        'statistikSiswa' => $statistikSiswa,
    ]);
}

    public function actionPdf()
    {
        $searchModel = new NilaiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $statistikSiswa = $searchModel->getStatistikSiswa(Yii::$app->request->queryParams);

        $kelasList = ArrayHelper::map(Kelas::find()->all(), 'kode_kelas', 'nama_kelas');
        $mapelList = ArrayHelper::map(Mapel::find()->all(), 'kode_mapel', 'nama_mapel');
        $siswaList = ArrayHelper::map(Siswa::find()->all(), 'nis', 'nama');
        $jurusanList = ArrayHelper::map(Jurusan::find()->all(), 'kode_jurusan', 'nama_jurusan');

        $content = $this->renderPartial('_pdfNilaiSiswa', [
            'model' => $searchModel,
            'statistikSiswa' => $statistikSiswa,
            'kelasList' => $kelasList,
            'mapelList' => $mapelList,
            'siswaList' => $siswaList,
            'jurusanList' => $jurusanList,
        ]);

        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8,
            'format' => Pdf::FORMAT_A4, // <-- perbaiki di sini
            'orientation' => Pdf::ORIENT_LANDSCAPE, // tambahkan orientasi landscape
            'destination' => Pdf::DEST_BROWSER,
            'content' => $content,
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            'cssInline' => 'body { font-family: sans-serif; font-size: 12px; }',
            'options' => ['title' => 'Laporan Nilai Siswa'],
            'methods' => [
                'SetHeader' => ['Sistem Nilai Siswa'],
                'SetFooter' => ['{PAGENO}'],
            ]
        ]);

        return $pdf->render();
    }

    protected function findModel($id)
    {
        if (($model = Nilai::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
