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
    /**
     * @inheritdoc
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
                    'delete' => ['POST'],
                    'set-active' => ['POST'],
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
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
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
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $providerJurnal = new \yii\data\ArrayDataProvider([
            'allModels' => $model->jurnal,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('view', [
            'model' => $model,
            'providerHistorykelas' => $providerHistorykelas,
            'providerJurnal' => $providerJurnal,
        ]);
    }

    /**
     * Creates a new Tahunajaran model.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tahunajaran();

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                // Logic untuk mengatur status aktif sudah ada di beforeSave() model
                // Tidak perlu duplikasi di sini

                if ($model->save()) {
                    Yii::$app->session->setFlash('success', "Data tahun ajaran berhasil ditambahkan");
                    return $this->redirect(['view', 'id' => $model->kodeta]);
                } else {
                    Yii::$app->session->setFlash('error', "Terjadi kesalahan saat menyimpan data");
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
     * Updates an existing Tahunajaran model.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                // Logic untuk mengatur status aktif sudah ada di beforeSave() model
                // Tidak perlu duplikasi di sini

                if ($model->save()) {
                    Yii::$app->session->setFlash('success', "Data tahun ajaran berhasil diupdate");
                    return $this->redirect(['view', 'id' => $model->kodeta]);
                } else {
                    Yii::$app->session->setFlash('error', "Terjadi kesalahan saat mengupdate data");
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Tahunajaran model.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $isActive = $model->isaktif;

        // Cek apakah ada data terkait
        $jurnalCount = Yii::$app->db->createCommand('SELECT COUNT(*) FROM jurnal WHERE kodeta = :kodeta')
            ->bindValue(':kodeta', $id)
            ->queryScalar();

        $historykelasCount = Yii::$app->db->createCommand('SELECT COUNT(*) FROM historykelas WHERE kodeta = :kodeta')
            ->bindValue(':kodeta', $id)
            ->queryScalar();

        if ($jurnalCount > 0 || $historykelasCount > 0) {
            $related = [];
            if ($jurnalCount > 0) $related[] = "Jurnal ({$jurnalCount} data)";
            if ($historykelasCount > 0) $related[] = "History Kelas ({$historykelasCount} data)";

            Yii::$app->session->setFlash('error', 'Tidak dapat menghapus karena ada data terkait: ' . implode(', ', $related));
            return $this->redirect(['index']);
        }

        if ($model->delete()) {
            // Jika yang dihapus adalah tahun ajaran aktif, aktifkan yang terbaru
            if ($isActive == 1) {
                $latest = Tahunajaran::find()->orderBy(['kodeta' => SORT_DESC])->one();
                if ($latest) {
                    $latest->isaktif = 1;
                    $latest->save();
                    Yii::$app->session->setFlash('success', "Tahun ajaran berhasil dihapus. Tahun ajaran {$latest->kodeta} telah diaktifkan secara otomatis.");
                } else {
                    Yii::$app->session->setFlash('success', "Data tahun ajaran berhasil dihapus.");
                }
            } else {
                Yii::$app->session->setFlash('success', "Data tahun ajaran berhasil dihapus.");
            }
        } else {
            Yii::$app->session->setFlash('error', "Gagal menghapus data tahun ajaran.");
        }

        return $this->redirect(['index']);
    }

    /**
     * Set active tahun ajaran via AJAX
     * @param string $id
     * @return mixed
     */
    public function actionSetActive($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isAjax) {
            // Nonaktifkan semua tahun ajaran
            Tahunajaran::updateAll(['isaktif' => 0]);

            // Aktifkan tahun ajaran yang dipilih
            $model->isaktif = 1;

            if ($model->save()) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return [
                    'success' => true,
                    'message' => "Tahun ajaran {$model->kodeta} berhasil diaktifkan"
                ];
            } else {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return [
                    'success' => false,
                    'message' => "Gagal mengaktifkan tahun ajaran"
                ];
            }
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Tahunajaran model based on primary key.
     * @param string $id
     * @return Tahunajaran the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tahunajaran::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Data tahun ajaran tidak ditemukan.');
    }
}
