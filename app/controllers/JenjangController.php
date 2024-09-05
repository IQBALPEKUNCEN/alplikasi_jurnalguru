<?php

namespace app\controllers;

use Yii;
use app\models\base\Jenjang;
use app\models\JenjangSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * JenjangController implements the CRUD actions for Jenjang model.
 */
class JenjangController extends Controller
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
     * Lists all Jenjang models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new JenjangSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Jenjang model.
     * 
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $providerKelas = new \yii\data\ArrayDataProvider([
            'allModels' => $model->kelas,
        ]);
        return $this->render('view', [
            'model' => $model,
            'providerKelas' => $providerKelas,
        ]);
    }

    /**
     * Creates a new Jenjang model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Jenjang();

        if ($this->request->isPost) {
            if ($model->loadAll($this->request->post()) && $model->saveAll()) {
                Yii::$app->session->setFlash('success', "Data berhasil ditambahkan");
                return $this->redirect(['view', ]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Jenjang model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * 
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            if ($model->loadAll($this->request->post()) && $model->saveAll()) {
                Yii::$app->session->setFlash('success', "Data berhasil diupdate");
                return $this->redirect(['view', ]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Jenjang model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * 
     * @return mixed
     */
    public function actionDelete($id)
    {
        // $this->findModel($)->deleteWithRelated();
        $result = $this->findModel($id)->delete();

        if ($result) {
            Yii::$app->session->setFlash('success', "Berhasil menghapus $result data.");
        } else {
            Yii::$app->session->setFlash('error', 'Gagal menghapus data.');
        }

        return $this->redirect(['index']);
    }

    
    /**
     * Finds the Jenjang model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * 
     * @return Jenjang the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Jenjang::findOne([])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Data tidak ditemukan.');
        }
    }
    
    /**
    * Action to load a tabular form grid
    * for Kelas
    * @author Yohanes Candrajaya <moo.tensai@gmail.com>
    * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
    *
    * @return mixed
    */
    public function actionAddKelas()
    {
        if ($this->request->isAjax) {
            $row = $this->request->post('Kelas');
            if (!empty($row)) {
                $row = array_values($row);
            }
            if(($this->request->post('isNewRecord') && $this->request->post('_action') == 'load' && empty($row)) || $this->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formKelas', ['row' => $row]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
