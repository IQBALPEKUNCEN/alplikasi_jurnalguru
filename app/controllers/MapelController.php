<?php

namespace app\controllers;

use Yii;
use app\models\base\Mapel;
use app\models\MapelSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;

/**
 * MapelController implements the CRUD actions for Mapel model.
 */
class MapelController extends Controller
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
     * Lists all Mapel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MapelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Mapel model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        // pastikan relasi jurnals ada di model Mapel
        $providerJurnal = new ArrayDataProvider([
            'allModels' => $model->jurnals ?? [],
            'pagination' => false,
        ]);

        return $this->render('view', [
            'model' => $model,
            'providerJurnal' => $providerJurnal,
        ]);
    }

    /**
     * Creates a new Mapel model.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Mapel();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Data berhasil ditambahkan.');
            return $this->redirect(['view', 'id' => $model->kode_mapel]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Mapel model.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Data berhasil diperbarui.');
            return $this->redirect(['view', 'id' => $model->kode_mapel]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Mapel model.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->delete()) {
            Yii::$app->session->setFlash('success', 'Data berhasil dihapus.');
        } else {
            Yii::$app->session->setFlash('error', 'Gagal menghapus data.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Mapel model based on its primary key value.
     * @param string $id
     * @return Mapel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Mapel::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Data tidak ditemukan.');
    }

    /**
     * Action to load a tabular form grid for Jurnal.
     * @return mixed
     */
    public function actionAddJurnal()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('Jurnal');
            if (!empty($row)) {
                $row = array_values($row);
            }
            if (Yii::$app->request->post('_action') === 'add' || (Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') === 'load' && empty($row))) {
                $row[] = [];
            }
            return $this->renderAjax('_formJurnal', ['row' => $row]);
        }

        throw new NotFoundHttpException('Halaman yang diminta tidak ditemukan.');
    }
}
