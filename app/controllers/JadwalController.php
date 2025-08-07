<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use app\models\Jadwal;
use app\models\JadwalSearch;
use app\models\Kelas;
use app\models\Mapel;
use app\models\Guru;
use app\models\Jurusan;
use app\models\Ruangan;
use yii\filters\AccessControl;

class JadwalController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'ghost-access' => [
                'class' => 'app\modules\UserManagement\components\GhostAccessControl',
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                    'force-delete' => ['post'],
                    'soft-delete' => ['post'],
                ],
            ],
        ];
    }
    /**
     * Lists all Jadwal models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new JadwalSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Jadwal model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Jadwal model.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Jadwal();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                // Validasi waktu
                if (empty($model->jam_mulai)) {
                    $model->jam_mulai = '00:00:00';
                }
                if (empty($model->jam_selesai)) {
                    $model->jam_selesai = '00:00:00';
                }

                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Jadwal berhasil ditambahkan.');
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    Yii::$app->session->setFlash('error', 'Gagal menyimpan jadwal.');
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Jadwal model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post())) {
            // Validasi waktu
            if (empty($model->jam_mulai)) {
                $model->jam_mulai = '00:00:00';
            }
            if (empty($model->jam_selesai)) {
                $model->jam_selesai = '00:00:00';
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Jadwal berhasil diperbarui.');
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', 'Gagal memperbarui jadwal.');
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Jadwal model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Jadwal berhasil dihapus.');
        return $this->redirect(['index']);
    }

    /**
     * Displays jadwal for students with filtering options.
     * @return mixed
     */
    public function actionJadwalSiswa()
    {
        // Get filter parameters
        $kodeKelas = Yii::$app->request->get('kode_kelas');
        $hari = Yii::$app->request->get('hari');

        // Build query with eager loading
        $query = Jadwal::find()
            ->with(['kodeMapel', 'guru', 'ruangan', 'kodeKelas', 'kodeJurusan'])
            ->orderBy(['jam_mulai' => SORT_ASC]);

        // Apply filters
        if ($kodeKelas) {
            $query->andWhere(['kode_kelas' => $kodeKelas]);
        }
        if ($hari) {
            $query->andWhere(['hari' => $hari]);
        }

        // Create data provider
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
            'sort' => [
                'defaultOrder' => ['jam_mulai' => SORT_ASC]
            ]
        ]);

        // Get dropdown data
        $kelasList = ArrayHelper::map(Kelas::find()->all(), 'kode_kelas', 'nama');
        $mapelList = ArrayHelper::map(Mapel::find()->all(), 'kode_mapel', 'nama');
        $guruList = ArrayHelper::map(Guru::find()->all(), 'guru_id', 'nama');
        $jurusanList = ArrayHelper::map(Jurusan::find()->all(), 'kode_jurusan', 'nama');
        $ruanganList = ArrayHelper::map(Ruangan::find()->all(), 'id', 'nama');

        $hariList = [
            'Senin' => 'Senin',
            'Selasa' => 'Selasa',
            'Rabu' => 'Rabu',
            'Kamis' => 'Kamis',
            'Jumat' => 'Jumat',
            'Sabtu' => 'Sabtu',
        ];

        // Create dynamic model for form
        $model = new \yii\base\DynamicModel(['hari', 'kode_kelas']);
        $model->addRule(['hari', 'kode_kelas'], 'string');

        return $this->render('jadwal-siswa', [
            'dataProvider' => $dataProvider,
            'model' => $model,
            'kelasList' => $kelasList,
            'mapelList' => $mapelList,
            'guruList' => $guruList,
            'jurusanList' => $jurusanList,
            'ruanganList' => $ruanganList,
            'hariList' => $hariList,
            'totalJadwal' => $query->count(),
        ]);
    }

    /**
     * API endpoint to get jadwal data as JSON
     * @return \yii\web\Response
     */
    public function actionGetJadwal()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $kodeKelas = Yii::$app->request->get('kode_kelas');
        $hari = Yii::$app->request->get('hari');

        $query = Jadwal::find()
            ->with(['kodeMapel', 'guru', 'ruangan'])
            ->orderBy(['jam_mulai' => SORT_ASC]);

        if ($kodeKelas) {
            $query->andWhere(['kode_kelas' => $kodeKelas]);
        }
        if ($hari) {
            $query->andWhere(['hari' => $hari]);
        }

        $jadwals = $query->all();
        $result = [];

        foreach ($jadwals as $jadwal) {
            $result[] = [
                'id' => $jadwal->id,
                'hari' => $jadwal->hari,
                'jam_mulai' => $jadwal->jam_mulai,
                'jam_selesai' => $jadwal->jam_selesai,
                'jam_formatted' => $jadwal->jamFormatted,
                'mapel' => $jadwal->mapelNama,
                'guru' => $jadwal->guruNama,
                'ruangan' => $jadwal->ruanganNama,
                'kelas' => $jadwal->kodeKelas->nama ?? '-',
            ];
        }

        return $result;
    }

    /**
     * Check room availability for scheduling
     * @return \yii\web\Response
     */
    public function actionCheckRuangan()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $ruanganId = Yii::$app->request->post('ruangan_id');
        $hari = Yii::$app->request->post('hari');
        $jamMulai = Yii::$app->request->post('jam_mulai');
        $jamSelesai = Yii::$app->request->post('jam_selesai');
        $excludeId = Yii::$app->request->post('exclude_id'); // For update

        $query = Jadwal::find()
            ->where(['ruangan_id' => $ruanganId, 'hari' => $hari])
            ->andWhere([
                'or',
                ['and', ['<=', 'jam_mulai', $jamMulai], ['>', 'jam_selesai', $jamMulai]],
                ['and', ['<', 'jam_mulai', $jamSelesai], ['>=', 'jam_selesai', $jamSelesai]],
                ['and', ['>=', 'jam_mulai', $jamMulai], ['<=', 'jam_selesai', $jamSelesai]],
            ]);

        if ($excludeId) {
            $query->andWhere(['!=', 'id', $excludeId]);
        }

        $conflictCount = $query->count();
        
        return [
            'available' => $conflictCount == 0,
            'message' => $conflictCount > 0 ? 'Ruangan tidak tersedia pada waktu tersebut' : 'Ruangan tersedia'
        ];
    }

    /**
     * Finds the Jadwal model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Jadwal the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Jadwal::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Halaman tidak ditemukan.');
    }
}