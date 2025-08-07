<?php

namespace app\controllers;

use Yii;
use app\models\base\Siswa;
use app\models\SiswaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SiswaController implements the CRUD actions for Siswa model.
 */
class SiswaController extends Controller
{
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
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new SiswaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        $providerHistorykelas = new \yii\data\ArrayDataProvider([
            'allModels' => $model->historykelas,
        ]);
        $providerJurnalDetil = new \yii\data\ArrayDataProvider([
            'allModels' => $model->jurnalDetils,
        ]);

        return $this->render('view', [
            'model' => $model,
            'providerHistorykelas' => $providerHistorykelas,
            'providerJurnalDetil' => $providerJurnalDetil,
        ]);
    }

    public function actionCreate()
    {
        $model = new Siswa();

        if ($this->request->isPost) {
            if ($model->loadAll($this->request->post()) && $model->saveAll()) {
                Yii::$app->session->setFlash('success', "Data berhasil ditambahkan");
                return $this->redirect(['view', 'id' => $model->nis]);
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

        if ($this->request->isPost) {
            if ($model->loadAll($this->request->post()) && $model->saveAll()) {
                Yii::$app->session->setFlash('success', "Data berhasil diupdate");
                return $this->redirect(['view', 'id' => $model->nis]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        try {
            $model = $this->findModel($id);

            // Hapus relasi jika ada (manual jika tidak pakai ON DELETE CASCADE)
            foreach ($model->jurnalDetils as $detil) {
                $detil->delete();
            }
            foreach ($model->historykelas as $history) {
                $history->delete();
            }

            if ($model->delete()) {
                Yii::$app->session->setFlash('success', "Data berhasil dihapus.");
            } else {
                Yii::$app->session->setFlash('error', "Gagal menghapus data.");
            }
        } catch (\Throwable $e) {
            Yii::error($e->getMessage(), __METHOD__);
            Yii::$app->session->setFlash('error', 'Terjadi kesalahan saat menghapus: ' . $e->getMessage());
        }

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Siswa::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Data tidak ditemukan.');
    }

    /**
     * Action untuk menambah baris pada form Historykelas
     */
    public function actionAddHistorykelas()
    {
        if ($this->request->isAjax) {
            $row = Yii::$app->request->post('Historykelas');
            if ((!empty($row)) && is_array($row)) {
                $row[] = [];
            } else {
                $row = [[]];
            }
            return $this->renderAjax('_formHistorykelas', ['row' => $row]);
        }
        throw new NotFoundHttpException('Halaman tidak ditemukan.');
    }

    /**
     * Action untuk menambah baris pada form JurnalDetil
     */
    public function actionAddJurnalDetil()
    {
        if ($this->request->isAjax) {
            $row = Yii::$app->request->post('JurnalDetil');
            if ((!empty($row)) && is_array($row)) {
                $row[] = [];
            } else {
                $row = [[]];
            }
            return $this->renderAjax('_formJurnalDetil', ['row' => $row]);
        }
        throw new NotFoundHttpException('Halaman tidak ditemukan.');
    }
}
