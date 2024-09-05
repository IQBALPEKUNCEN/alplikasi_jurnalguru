<?php

namespace app\controllers;

use Yii;
use app\models\base\Jurnal;
use app\models\JurnalSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * JurnalController implements the CRUD actions for Jurnal model.
 */
class JurnalController extends Controller
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
     * Lists all Jurnal models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new JurnalSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Jurnal model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $providerJurnalDetil = new \yii\data\ArrayDataProvider([
            'allModels' => $model->jurnalDetils,
        ]);
        return $this->render('view', [
            'model' => $model,
            'providerJurnalDetil' => $providerJurnalDetil,
        ]);
    }

    /**
     * Creates a new Jurnal model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Jurnal();

        if ($this->request->isPost) {
            if ($model->loadAll($this->request->post()) && $model->saveAll()) {
                Yii::$app->session->setFlash('success', "Data berhasil ditambahkan");
                return $this->redirect(['view', 'id' => $model->jurnal_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Jurnal model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            if ($model->loadAll($this->request->post()) && $model->saveAll()) {
                Yii::$app->session->setFlash('success', "Data berhasil diupdate");
                return $this->redirect(['view', 'id' => $model->jurnal_id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Jurnal model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
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
     * Finds the Jurnal model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Jurnal the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Jurnal::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Data tidak ditemukan.');
        }
    }
    
    /**
    * Action to load a tabular form grid
    * for JurnalDetil
    * @author Yohanes Candrajaya <moo.tensai@gmail.com>
    * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
    *
    * @return mixed
    */
    public function actionAddJurnalDetil()
    {
        if ($this->request->isAjax) {
            $row = $this->request->post('JurnalDetil');
            if (!empty($row)) {
                $row = array_values($row);
            }
            if(($this->request->post('isNewRecord') && $this->request->post('_action') == 'load' && empty($row)) || $this->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formJurnalDetil', ['row' => $row]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
