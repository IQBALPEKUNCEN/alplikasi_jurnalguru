<?php

namespace app\controllers;

use app\models\PengumpulanTugas;
use app\models\PengumpulanTugasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use Yii;

/**
 * PengumpulanTugasController implements the CRUD actions for PengumpulanTugas model.
 */
class PengumpulanTugasController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all PengumpulanTugas models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PengumpulanTugasSearch();
        $currentUser = Yii::$app->user->identity;

        // Tentukan apakah user adalah admin atau bukan
        $isAdmin = $currentUser && in_array($currentUser->username, ['admin', 'superadmin']);

        if ($isAdmin) {
            // Admin melihat semua data
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        } else {
            // Non-admin hanya melihat datanya sendiri (berdasarkan nama siswa)
            $query = PengumpulanTugas::find()
                ->joinWith(['siswa', 'tugas'])
                ->andWhere(['siswa.nama' => $currentUser->username]);

            // Terapkan filter manual dari searchModel jika diperlukan
            $searchModel->load(Yii::$app->request->queryParams);

            if ($searchModel->validate()) {
                $query->andFilterWhere([
                    'pengumpulan_tugas.id' => $searchModel->id,
                    'pengumpulan_tugas.tugas_id' => $searchModel->tugas_id,
                    'pengumpulan_tugas.siswa_id' => $searchModel->siswa_id,
                    'pengumpulan_tugas.tanggal_kumpul' => $searchModel->tanggal_kumpul,
                ]);

                $query->andFilterWhere(['like', 'pengumpulan_tugas.keterangan', $searchModel->keterangan]);
            }

            $dataProvider = new \yii\data\ActiveDataProvider([
                'query' => $query,
                'pagination' => ['pageSize' => 20],
                'sort' => [
                    'defaultOrder' => [
                        'id' => SORT_DESC
                    ]
                ]
            ]);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single PengumpulanTugas model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PengumpulanTugas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new PengumpulanTugas();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                // Handle file upload
                $uploadedFile = UploadedFile::getInstance($model, 'file_tugas');
                if ($uploadedFile) {
                    $fileName = time() . '_' . $uploadedFile->baseName . '.' . $uploadedFile->extension;
                    $uploadPath = Yii::getAlias('@webroot/uploads/tugas/');

                    // Buat direktori jika belum ada
                    if (!is_dir($uploadPath)) {
                        mkdir($uploadPath, 0755, true);
                    }

                    if ($uploadedFile->saveAs($uploadPath . $fileName)) {
                        $model->file_tugas = $fileName;
                    }
                }

                // Set tanggal kumpul otomatis jika kosong
                if (empty($model->tanggal_kumpul)) {
                    $model->tanggal_kumpul = date('Y-m-d H:i:s');
                }

                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
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
     * Updates an existing PengumpulanTugas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oldFile = $model->file_tugas;

        if ($this->request->isPost && $model->load($this->request->post())) {
            // Handle file upload
            $uploadedFile = UploadedFile::getInstance($model, 'file_tugas');
            if ($uploadedFile) {
                $fileName = time() . '_' . $uploadedFile->baseName . '.' . $uploadedFile->extension;
                $uploadPath = Yii::getAlias('@webroot/uploads/tugas/');

                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                if ($uploadedFile->saveAs($uploadPath . $fileName)) {
                    // Hapus file lama jika ada
                    if ($oldFile && file_exists($uploadPath . $oldFile)) {
                        unlink($uploadPath . $oldFile);
                    }
                    $model->file_tugas = $fileName;
                } else {
                    $model->file_tugas = $oldFile; // Kembalikan nama file lama jika upload gagal
                }
            } else {
                $model->file_tugas = $oldFile; // Pertahankan file lama jika tidak ada upload baru
            }

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PengumpulanTugas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        // Hapus file jika ada
        if ($model->file_tugas) {
            $filePath = Yii::getAlias('@webroot/uploads/tugas/') . $model->file_tugas;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PengumpulanTugas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return PengumpulanTugas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PengumpulanTugas::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionViewFile($id)
    {
        $model = $this->findModel($id);
        $filePath = Yii::getAlias('@webroot/uploads/tugas/') . $model->file_tugas;

        if (file_exists($filePath)) {
            return Yii::$app->response->sendFile($filePath);
        }

        throw new \yii\web\NotFoundHttpException('File tidak ditemukan.');
    }

    /**
     * Menampilkan riwayat pengumpulan tugas.
     * Bisa difilter berdasarkan nama siswa, kelas, jurusan, atau tanggal.
     *
     * @return string
     */
    public function actionHistory()
    {
        $query = PengumpulanTugas::find()->joinWith(['siswa.kelas', 'tugas']);

        // Ambil parameter filter dari request GET
        $namaSiswa = Yii::$app->request->get('nama_siswa');
        $judulTugas = Yii::$app->request->get('judul_tugas');
        $tanggalKumpul = Yii::$app->request->get('tanggal_kumpul');
        $kelas = Yii::$app->request->get('kelas');

        // Terapkan filter jika ada input
        if (!empty($namaSiswa)) {
            $query->andFilterWhere(['like', 'siswa.nama', $namaSiswa]);
        }

        if (!empty($judulTugas)) {
            $query->andFilterWhere(['like', 'tugas.judul_tugas', $judulTugas]);
        }

        if (!empty($tanggalKumpul)) {
            $query->andFilterWhere(['tanggal_kumpul' => $tanggalKumpul]);
        }

        if (!empty($kelas)) {
            $query->andFilterWhere(['siswa.kode_kelas' => $kelas]);
        }

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 10],
            'sort' => ['defaultOrder' => ['tanggal_kumpul' => SORT_DESC]],
        ]);

        return $this->render('history', [
            'dataProvider' => $dataProvider,
            'nama_siswa' => $namaSiswa,
            'judul_tugas' => $judulTugas,
            'tanggal_kumpul' => $tanggalKumpul,
            'kelas' => $kelas,
        ]);
    }
}
