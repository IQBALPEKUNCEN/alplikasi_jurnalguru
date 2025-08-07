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
            'ghost-access' => [
                'class' => 'app\modules\UserManagement\components\GhostAccessControl',
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                    'force-delete' => ['post'],
                    'soft-delete' => ['post'],
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
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $providerKelas = new \yii\data\ArrayDataProvider([
            'allModels' => $model->kelas ?? [],
        ]);
        return $this->render('view', [
            'model' => $model,
            'providerKelas' => $providerKelas,
        ]);
    }

    /**
     * Creates a new Jenjang model.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Jenjang();

        if ($this->request->isPost) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                // Coba gunakan method loadAll/saveAll jika ada
                if (method_exists($model, 'loadAll') && method_exists($model, 'saveAll')) {
                    if ($model->loadAll($this->request->post()) && $model->saveAll()) {
                        $transaction->commit();
                        Yii::$app->session->setFlash('success', "Data berhasil ditambahkan");
                        return $this->redirect(['view', 'id' => $model->kode_jenjang]);
                    }
                } else {
                    // Fallback ke method standar
                    if ($model->load($this->request->post()) && $model->save()) {
                        $transaction->commit();
                        Yii::$app->session->setFlash('success', "Data berhasil ditambahkan");
                        return $this->redirect(['view', 'id' => $model->kode_jenjang]);
                    }
                }

                $transaction->rollBack();
                Yii::error('Failed to save Jenjang model: ' . json_encode($model->errors));
                Yii::$app->session->setFlash('error', "Gagal menyimpan data: " . $this->formatErrors($model->errors));
            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::error('Exception in actionCreate: ' . $e->getMessage());
                Yii::$app->session->setFlash('error', "Terjadi kesalahan: " . $e->getMessage());
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
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $postData = $this->request->post();
                Yii::info('Update data received: ' . json_encode($postData));

                // Coba gunakan method loadAll/saveAll jika ada
                if (method_exists($model, 'loadAll') && method_exists($model, 'saveAll')) {
                    if ($model->loadAll($postData)) {
                        if ($model->validate()) {
                            if ($model->saveAll()) {
                                $transaction->commit();
                                Yii::$app->session->setFlash('success', "Data berhasil diupdate");
                                return $this->redirect(['view', 'id' => $model->kode_jenjang]);
                            } else {
                                Yii::error('Failed to saveAll: ' . json_encode($model->errors));
                                Yii::$app->session->setFlash('error', "Gagal menyimpan: " . $this->formatErrors($model->errors));
                            }
                        } else {
                            Yii::error('Validation failed: ' . json_encode($model->errors));
                            Yii::$app->session->setFlash('error', "Validasi gagal: " . $this->formatErrors($model->errors));
                        }
                    } else {
                        Yii::error('Failed to loadAll data');
                        Yii::$app->session->setFlash('error', "Gagal memuat data ke model");
                    }
                } else {
                    // Fallback ke method standar
                    if ($model->load($postData)) {
                        if ($model->save()) {
                            $transaction->commit();
                            Yii::$app->session->setFlash('success', "Data berhasil diupdate");
                            return $this->redirect(['view', 'id' => $model->kode_jenjang]);
                        } else {
                            Yii::error('Failed to save: ' . json_encode($model->errors));
                            Yii::$app->session->setFlash('error', "Gagal menyimpan: " . $this->formatErrors($model->errors));
                        }
                    } else {
                        Yii::error('Failed to load data');
                        Yii::$app->session->setFlash('error', "Gagal memuat data");
                    }
                }

                $transaction->rollBack();
            } catch (\yii\db\IntegrityException $e) {
                $transaction->rollBack();
                Yii::error('Database integrity error: ' . $e->getMessage());
                Yii::$app->session->setFlash('error', "Error integritas database: " . $e->getMessage());
            } catch (\yii\db\Exception $e) {
                $transaction->rollBack();
                Yii::error('Database error: ' . $e->getMessage());
                Yii::$app->session->setFlash('error', "Error database: " . $e->getMessage());
            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::error('Exception in actionUpdate: ' . $e->getMessage());
                Yii::$app->session->setFlash('error', "Terjadi kesalahan: " . $e->getMessage());
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Jenjang model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        try {
            $model = $this->findModel($id);

            // Cek apakah ada data yang masih terkait sebelum menghapus
            $relatedData = $this->checkRelatedData($model);

            if (!empty($relatedData)) {
                // Jika ada data terkait, tampilkan pesan error
                $message = "Tidak dapat menghapus data karena masih terdapat data terkait:\n";
                foreach ($relatedData as $relation => $count) {
                    $message .= "- {$relation}: {$count} data\n";
                }
                $message .= "\nHapus terlebih dahulu data terkait atau gunakan 'Force Delete' jika yakin.";
                Yii::$app->session->setFlash('error', $message);
                return $this->redirect(['index']);
            }

            // Jika tidak ada data terkait, lakukan penghapusan
            $result = $model->delete();

            if ($result) {
                Yii::$app->session->setFlash('success', "Berhasil menghapus data.");
            } else {
                Yii::$app->session->setFlash('error', 'Gagal menghapus data.');
            }
        } catch (\yii\db\IntegrityException $e) {
            // Handle foreign key constraint violation
            Yii::error('Integrity constraint violation: ' . $e->getMessage());
            Yii::$app->session->setFlash(
                'error',
                "Tidak dapat menghapus data karena masih terdapat data terkait di tabel lain. " .
                    "Hapus terlebih dahulu data yang terkait sebelum menghapus jenjang ini."
            );
        } catch (\Exception $e) {
            Yii::error('Exception in actionDelete: ' . $e->getMessage());
            Yii::$app->session->setFlash('error', "Terjadi kesalahan: " . $e->getMessage());
        }

        return $this->redirect(['index']);
    }

    /**
     * Force delete dengan menghapus semua data terkait
     * @param string $id
     * @return mixed
     */
    public function actionForceDelete($id)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model = $this->findModel($id);

            // Hapus data terkait terlebih dahulu
            // Pastikan nama class Kelas sesuai dengan yang ada di project
            if (class_exists('\app\models\Kelas')) {
                \app\models\Kelas::deleteAll(['kode_jenjang' => $model->kode_jenjang]);
            }

            // Tambahkan penghapusan data terkait lainnya jika ada
            /*
            if (class_exists('\app\models\Siswa')) {
                // Contoh jika ada relasi tidak langsung
                \app\models\Siswa::deleteAll(['kode_jenjang' => $model->kode_jenjang]);
            }
            */

            // Setelah data terkait dihapus, hapus jenjang
            $result = $model->delete();

            if ($result) {
                $transaction->commit();
                Yii::$app->session->setFlash('success', "Berhasil menghapus data beserta semua data terkait.");
            } else {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', 'Gagal menghapus data.');
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::error('Exception in actionForceDelete: ' . $e->getMessage());
            Yii::$app->session->setFlash('error', "Terjadi kesalahan: " . $e->getMessage());
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Jenjang model based on its primary key value.
     * @param string $id
     * @return Jenjang the loaded model
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        try {
            if (($model = Jenjang::findOne($id)) !== null) {
                return $model;
            }
        } catch (\Exception $e) {
            Yii::error('Exception in findModel: ' . $e->getMessage());
            throw new NotFoundHttpException('Error mencari data: ' . $e->getMessage());
        }

        throw new NotFoundHttpException('Data tidak ditemukan.');
    }

    /**
     * Cek data terkait sebelum menghapus
     * @param Jenjang $model
     * @return array
     */
    protected function checkRelatedData($model)
    {
        $relatedData = [];

        try {
            // Cek relasi dengan tabel Kelas
            if (class_exists('\app\models\Kelas')) {
                $kelasCount = \app\models\Kelas::find()
                    ->where(['kode_jenjang' => $model->kode_jenjang])
                    ->count();
                if ($kelasCount > 0) {
                    $relatedData['Kelas'] = $kelasCount;
                }
            }

            // Tambahkan pengecekan tabel lain jika perlu
            /*
            if (class_exists('\app\models\Siswa')) {
                $siswaCount = \app\models\Siswa::find()
                    ->joinWith('kelas')
                    ->where(['kelas.kode_jenjang' => $model->kode_jenjang])
                    ->count();
                if ($siswaCount > 0) {
                    $relatedData['Siswa'] = $siswaCount;
                }
            }
            */
        } catch (\Exception $e) {
            Yii::error('Error checking related data: ' . $e->getMessage());
        }

        return $relatedData;
    }

    /**
     * Format error messages untuk display
     * @param array $errors
     * @return string
     */
    protected function formatErrors($errors)
    {
        $messages = [];
        foreach ($errors as $field => $fieldErrors) {
            $messages[] = $field . ': ' . implode(', ', $fieldErrors);
        }
        return implode('; ', $messages);
    }

    /**
     * Action to load a tabular form grid for Kelas (AJAX).
     * @return mixed
     */
    public function actionAddKelas()
    {
        if ($this->request->isAjax) {
            try {
                $row = $this->request->post('Kelas');
                if (!empty($row)) {
                    $row = array_values($row);
                }
                if (($this->request->post('isNewRecord') && $this->request->post('_action') == 'load' && empty($row)) || $this->request->post('_action') == 'add') {
                    return $this->renderAjax('_formKelas', ['row' => (empty($row)) ? [new \app\models\Kelas()] : $row]);
                }
            } catch (\Exception $e) {
                Yii::error('Exception in actionAddKelas: ' . $e->getMessage());
                return json_encode(['error' => $e->getMessage()]);
            }
        }
    }
}
