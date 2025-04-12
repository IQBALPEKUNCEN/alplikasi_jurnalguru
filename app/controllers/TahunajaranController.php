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
$searchModel = new TahunajaranSearch();
$dataProvider = $searchModel->search($this->request->queryParams);

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
$providerJurnal = new \yii\data\ArrayDataProvider([
'allModels' => $model->jurnals,
]);

return $this->render('view', [
'model' => $model,
'providerHistorykelas' => $providerHistorykelas,
'providerJurnal' => $providerJurnal,
]);
}

public function actionCreate()
{
$model = new Tahunajaran();

if ($this->request->isPost) {
if ($model->load($this->request->post())) {
if ($model->isaktif == 1) {
Tahunajaran::updateAll(['isaktif' => 0], ['isaktif' => 1]);
}
if ($model->save()) {
Yii::$app->session->setFlash('success', "Data berhasil ditambahkan");
return $this->redirect(['view', 'id' => $model->kodeta]);
}
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
            if ($model->load($this->request->post())) {
                if ($model->isaktif == 1 && $model->getOldAttribute('isaktif') == 0) {
                    Tahunajaran::updateAll(['isaktif' => 0], ['isaktif' => 1]);
                }
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', "Data berhasil diupdate");
                    return $this->redirect(['view', 'id' => $model->kodeta]);
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


    public function actionDelete($id)
{
$result = $this->findModel($id)->delete();
if ($result) {
Yii::$app->session->setFlash('success', "Berhasil menghapus $result data.");
} else {
Yii::$app->session->setFlash('error', 'Gagal menghapus data.');
}

return $this->redirect(['index']);
}

protected function findModel($id)
{
if (($model = Tahunajaran::findOne($id)) !== null) {
return $model;
} else {
throw new NotFoundHttpException('Data tidak ditemukan.');
}
}

public function actionAddHistorykelas()
{
if ($this->request->isAjax) {
$row = $this->request->post('Historykelas');
if (!empty($row)) {
$row = array_values($row);
}
if (($this->request->post('isNewRecord') && $this->request->post('_action') == 'load' && empty($row)) || $this->request->post('_action') == 'add')
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
        if (($this->request->post('isNewRecord') && $this->request->post('_action') == 'load' && empty($row)) || $this->request->post('_action') == 'add')
        $row[] = [];
        return $this->renderAjax('_formJurnal', ['row' => $row]);
        } else {
        throw new NotFoundHttpException('The requested page does not exist.');
        }
        }
        }