<?php

namespace app\controllers;

<<<<<<< HEAD
use app\models\base\Jurnal;
=======
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
use Yii;
use app\models\base\JurnalDetil;
use app\models\JurnalDetilSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * JurnalDetilController implements the CRUD actions for JurnalDetil model.
 */
class JurnalDetilController extends Controller
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
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new JurnalDetil model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
<<<<<<< HEAD
    // public function actionCreate()
    // {
    //     $model = new JurnalDetil();

    //     if ($this->request->isPost) {
    //         if ($model->loadAll($this->request->post()) && $model->saveAll()) {
    //             Yii::$app->session->setFlash('success', "Data berhasil ditambahkan");
    //             return $this->redirect(['view', 'id' => $model->detil_id]);
    //         }
    //     } else {
    //         $model->loadDefaultValues();
    //     }

    //     return $this->render('create', [
    //         'model' => $model,
    //     ]);
    // }
    public function actionCreate($jurnal_id)
    {
        $model = new JurnalDetil();

        if ($model->load(Yii::$app->request->post())) {
            // Ambil waktu_presensi dari jurnal
            $jurnal = Jurnal::findOne($jurnal_id);
            if ($jurnal) {
                $model->waktu_presensi = $jurnal->waktupresensi; // Isi waktu presensi dari jurnal
            }
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->detil_id]);
            }
=======
    public function actionCreate()
    {
        $model = new JurnalDetil();

        if ($this->request->isPost) {
            if ($model->loadAll($this->request->post()) && $model->saveAll()) {
                Yii::$app->session->setFlash('success', "Data berhasil ditambahkan");
                return $this->redirect(['view', 'id' => $model->detil_id]);
            }
        } else {
            $model->loadDefaultValues();
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
        }

        return $this->render('create', [
            'model' => $model,
<<<<<<< HEAD
            'jurnal_id' => $jurnal_id,
=======
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
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

        if ($this->request->isPost) {
            if ($model->loadAll($this->request->post()) && $model->saveAll()) {
                Yii::$app->session->setFlash('success', "Data berhasil diupdate");
                return $this->redirect(['view', 'id' => $model->detil_id]);
            }
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
        } else {
            throw new NotFoundHttpException('Data tidak ditemukan.');
        }
    }
}
