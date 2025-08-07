<?php

namespace app\controllers;

use Yii;
use app\models\base\Jurnal;
use app\models\base\JurnalDetil;
use app\models\base\Siswa;
use app\models\JurnalDetilSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;


/**
 * JurnalDetilController implements the CRUD actions for JurnalDetil model.
 */
class JurnalDetilController extends Controller
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

    /**
     * Lists all JurnalDetil models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new JurnalDetilSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single JurnalDetil model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        // Pastikan jurnalDetils ada dan tidak null sebelum dibuat dataprovider
        $jurnalDetils = [];
        if ($model && is_object($model) && method_exists($model, 'getJurnalDetils')) {
            // Pastikan relasi jurnalDetils bukan boolean atau kosong
            $jurnalDetils = $model->jurnalDetils ? $model->jurnalDetils : [];
        }

        $providerJurnalDetil = new \yii\data\ArrayDataProvider([
            'allModels' => $jurnalDetils,
        ]);

        return $this->render('view', [
            'model' => $model,
            'providerJurnalDetil' => $providerJurnalDetil,
        ]);
    }



    /**
     * Creates a new JurnalDetil model.
     * @param integer $jurnal_id
     * @return mixed
     */
    public function actionCreate($jurnal_id)
    {
        $model = new JurnalDetil();
        $model->jurnal_id = $jurnal_id; // set hubungan ke jurnal utama

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Detail jurnal berhasil ditambahkan.');
            return $this->redirect(['jurnal/view', 'id' => $jurnal_id]); // kembali ke view jurnal utama
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing JurnalDetil model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Detail jurnal berhasil diperbarui.');
            return $this->redirect(['jurnal/view', 'id' => $model->jurnal_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


    /**
     * Deletes an existing JurnalDetil model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $result = $this->findModel($id)->delete();

        if ($result) {
            Yii::$app->session->setFlash('success', "Berhasil menghapus data.");
        } else {
            Yii::$app->session->setFlash('error', 'Gagal menghapus data.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the JurnalDetil model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return JurnalDetil the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = JurnalDetil::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGetSiswaByKelas($kelas_id = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (!$kelas_id) {
            return [
                'success' => false,
                'message' => 'Kelas ID tidak ditemukan.',
                'data' => [],
            ];
        }

        try {
            $siswaList = Siswa::find()
                ->where(['kelas_id' => $kelas_id])
                ->orderBy('nama ASC')
                ->asArray()
                ->all();

            if (empty($siswaList)) {
                return [
                    'success' => true,
                    'data' => [],
                    'message' => 'Tidak ada siswa pada kelas ini.'
                ];
            }

            $result = [];
            foreach ($siswaList as $siswa) {
                $result[] = [
                    'id' => $siswa['id'],                       // <- penting
                    'nama' => $siswa['nama'],
                    'jurusan' => $siswa['kode_jurusan'] ?? '',
                ];
            }

            return [
                'success' => true,
                'data' => $result,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Gagal mengambil data siswa.',
                'error' => $e->getMessage(),
            ];
        }
    }
}
