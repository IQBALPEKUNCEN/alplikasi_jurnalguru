<?php

namespace app\controllers;

use Yii;
use app\models\base\Tahunajaran;
use app\models\TahunajaranSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TahunajaranController implements the CRUD actions for Tahunajaran model.
 */
class TahunajaranController extends Controller
{
    public function behaviors()
    {
        return [
            'ghost-access'=> [
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
     * Lists all Tahunajaran models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TahunajaranSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tahunajaran model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $providerHistorykelas = new \yii\data\ArrayDataProvider([
            'allModels' => $model->historykelas,
        ]);
        $providerJurnal = new \yii\data\ArrayDataProvider([
            'allModels' => $model->jurnals,
        ]);
        return $this->render('view', [
            'model' => $model,
            'providerHistorykelas' => $providerHistorykelas,
            'providerJurnal' => $providerJurnal,
        ]);
    }

    /**
     * Creates a new Tahunajaran model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tahunajaran();

        if ($this->request->isPost) {
            if ($model->loadAll($this->request->post()) && $model->saveAll()) {
                Yii::$app->session->setFlash('success', "Data berhasil ditambahkan");
                return $this->redirect(['view', 'id' => $model->kodeta]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Tahunajaran model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            if ($model->loadAll($this->request->post()) && $model->saveAll()) {
                Yii::$app->session->setFlash('success', "Data berhasil diupdate");
                return $this->redirect(['view', 'id' => $model->kodeta]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Tahunajaran model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        // $this->findModel($id)->deleteWithRelated();
        $result = $this->findModel($id)->delete();

        if ($result) {
            Yii::$app->session->setFlash('success', "Berhasil menghapus $result data.");
        } else {
            Yii::$app->session->setFlash('error', 'Gagal menghapus data.');
        }

        return $this->redirect(['index']);
    }

    
    /**
     * Finds the Tahunajaran model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Tahunajaran the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tahunajaran::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Data tidak ditemukan.');
        }
    }
    
    /**
    * Action to load a tabular form grid
    * for Historykelas
    * @author Yohanes Candrajaya <moo.tensai@gmail.com>
    * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
    *
    * @return mixed
    */
    public function actionAddHistorykelas()
    {
        if ($this->request->isAjax) {
            $row = $this->request->post('Historykelas');
            if (!empty($row)) {
                $row = array_values($row);
            }
            if(($this->request->post('isNewRecord') && $this->request->post('_action') == 'load' && empty($row)) || $this->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formHistorykelas', ['row' => $row]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
    * Action to load a tabular form grid
    * for Jurnal
    * @author Yohanes Candrajaya <moo.tensai@gmail.com>
    * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
    *
    * @return mixed
    */
    public function actionAddJurnal()
    {
        if ($this->request->isAjax) {
            $row = $this->request->post('Jurnal');
            if (!empty($row)) {
                $row = array_values($row);
            }
            if(($this->request->post('isNewRecord') && $this->request->post('_action') == 'load' && empty($row)) || $this->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formJurnal', ['row' => $row]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
