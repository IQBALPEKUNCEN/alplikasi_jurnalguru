<?php

namespace app\controllers;

use app\models\Tugas;
use app\models\TugasSearch;
use app\models\Guru;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\filters\VerbFilter;
use yii\web\Response;

class TugasController extends Controller
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ]);
    }

    public function actionIndex()
    {
        $searchModel = new TugasSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Tugas();

        if ($model->load(Yii::$app->request->post())) {
            // Validasi guru_id harus ada di tabel guru
            if (!Guru::find()->where(['guru_id' => $model->guru_id])->exists()) {
                $model->addError('guru_id', 'Guru tidak ditemukan. Silakan pilih guru yang valid.');
            }

            // Handle file upload
            $uploadedFile = UploadedFile::getInstance($model, 'file_tugas');

            if ($uploadedFile) {
                $uploadPath = Yii::getAlias('@webroot/uploads/tugas/');
                if (!is_dir($uploadPath)) {
                    FileHelper::createDirectory($uploadPath, 0775, true);
                }

                $fileName = time() . '_' . uniqid() . '.' . $uploadedFile->extension;
                $filePath = $uploadPath . $fileName;

                if ($uploadedFile->saveAs($filePath)) {
                    // Simpan nama file ke database
                    $model->file_tugas = $fileName;
                } else {
                    $model->addError('file_tugas', 'Gagal mengupload file.');
                }
            }

            // Jika ada error validasi, kembalikan ke form
            if ($model->hasErrors()) {
                return $this->render('create', ['model' => $model]);
            }

            if ($model->save(false)) { // false agar tidak divalidasi ulang
                Yii::$app->session->setFlash('success', 'Tugas berhasil dibuat.');
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', 'Gagal menyimpan tugas.');
            }
        }

        return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oldFile = $model->file_tugas;

        if ($model->load(Yii::$app->request->post())) {
            if (!Guru::find()->where(['guru_id' => $model->guru_id])->exists()) {
                $model->addError('guru_id', 'Guru tidak ditemukan. Silakan pilih guru yang valid.');
            }

            $uploadedFile = UploadedFile::getInstance($model, 'file_tugas');

            if ($uploadedFile) {
                $uploadPath = Yii::getAlias('@webroot/uploads/tugas/');
                if (!is_dir($uploadPath)) {
                    FileHelper::createDirectory($uploadPath);
                }

                $fileName = time() . '_' . uniqid() . '.' . $uploadedFile->extension;
                $filePath = $uploadPath . $fileName;

                if ($uploadedFile->saveAs($filePath)) {
                    if ($oldFile && file_exists($uploadPath . $oldFile)) {
                        unlink($uploadPath . $oldFile);
                    }
                    $model->file_tugas = $fileName;
                } else {
                    Yii::$app->session->setFlash('error', 'Gagal mengupload file.');
                }
            } else {
                $model->file_tugas = $oldFile;
            }

            if ($model->hasErrors()) {
                return $this->render('update', ['model' => $model]);
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Tugas berhasil diupdate.');
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', 'Gagal menyimpan perubahan.');
            }
        }

        return $this->render('update', ['model' => $model]);
    }

    public function actionDownloadFile($id)
    {
        // Cari tugas berdasarkan ID
        $tugas = $this->findModel($id);

        // Periksa apakah file tugas ada
        if (!$tugas->file_tugas) {
            throw new NotFoundHttpException('File tugas tidak ditemukan.');
        }

        // Path lengkap ke file
        $filePath = Yii::getAlias('@webroot') . '/uploads/tugas/' . $tugas->file_tugas;

        // Periksa apakah file fisik ada
        if (!file_exists($filePath)) {
            throw new NotFoundHttpException('File tidak ditemukan di server.');
        }

        // Ambil informasi file
        $fileInfo = pathinfo($filePath);
        $fileName = $tugas->judul_tugas . '.' . $fileInfo['extension'];
        $mimeType = $this->getMimeType($filePath);

        // Set response untuk download
        Yii::$app->response->format = Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', $mimeType);
        Yii::$app->response->headers->add('Content-Disposition', 'attachment; filename="' . $fileName . '"');
        Yii::$app->response->headers->add('Content-Length', filesize($filePath));

        // Baca dan kirim file
        return file_get_contents($filePath);
    }


    public function actionDeleteFile($id)
    {
        $model = $this->findModel($id);

        if ($model->file_tugas) {
            $filePath = Yii::getAlias('@webroot/uploads/tugas/') . $model->file_tugas;
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $model->file_tugas = null;
            $model->save();

            Yii::$app->session->setFlash('success', 'File berhasil dihapus.');
        }

        return $this->redirect(['view', 'id' => $model->id]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->file_tugas) {
            $filePath = Yii::getAlias('@webroot/uploads/tugas/') . $model->file_tugas;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $model->delete();
        Yii::$app->session->setFlash('success', 'Tugas berhasil dihapus.');

        return $this->redirect(['index']);
    }

    public function actionTugasSiswa()
    {
        $searchModel = new TugasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // Bisa ditambahkan filter berdasarkan siswa yang login, kelas, atau mapel
        // Contoh: $dataProvider->query->andWhere(['kode_kelas' => $kelasSiswa]);

        return $this->render('tugas-siswa', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    private function getMimeType($filePath)
    {
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        $mimeTypes = [
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'xls' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'ppt' => 'application/vnd.ms-powerpoint',
            'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'txt' => 'text/plain',
            'rtf' => 'application/rtf',
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'mp4' => 'video/mp4',
            'avi' => 'video/x-msvideo',
            'mov' => 'video/quicktime',
            'mp3' => 'audio/mpeg',
            'wav' => 'audio/wav',
        ];

        return isset($mimeTypes[$extension]) ? $mimeTypes[$extension] : 'application/octet-stream';
    }

    public function actionPreviewFile($id)
    {
        $tugas = $this->findModel($id);

        if (!$tugas->file_tugas) {
            throw new NotFoundHttpException('File tugas tidak ditemukan.');
        }

        $filePath = Yii::getAlias('@webroot') . '/uploads/tugas/' . $tugas->file_tugas;

        if (!file_exists($filePath)) {
            throw new NotFoundHttpException('File tidak ditemukan di server.');
        }

        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        $previewableTypes = ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'txt'];

        if (!in_array($extension, $previewableTypes)) {
            // Jika tidak bisa di-preview, redirect ke download
            return $this->redirect(['download-file', 'id' => $id]);
        }

        $mimeType = $this->getMimeType($filePath);

        Yii::$app->response->format = Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', $mimeType);
        Yii::$app->response->headers->add('Content-Disposition', 'inline');

        return file_get_contents($filePath);
    }




    protected function findModel($id)
    {
        if (($model = Tugas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Tugas tidak ditemukan.');
    }

    /**
     * Action untuk mengecek status file
     */
    public function actionCheckFile($id)
    {
        $tugas = $this->findModel($id);

        if (!$tugas->file_tugas) {
            return $this->asJson([
                'exists' => false,
                'message' => 'File tugas tidak tersedia'
            ]);
        }

        $filePath = Yii::getAlias('@webroot') . '/uploads/tugas/' . $tugas->file_tugas;

        if (!file_exists($filePath)) {
            return $this->asJson([
                'exists' => false,
                'message' => 'File tidak ditemukan di server'
            ]);
        }

        $fileInfo = [
            'exists' => true,
            'filename' => $tugas->file_tugas,
            'size' => $this->formatBytes(filesize($filePath)),
            'type' => $this->getMimeType($filePath),
            'extension' => pathinfo($filePath, PATHINFO_EXTENSION)
        ];

        return $this->asJson($fileInfo);
    }

    /**
     * Format ukuran file menjadi readable
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }

    // public function actionPengumpulanTugas()
    // {
    //     $model = new \yii\base\DynamicModel(['nama', 'kelas', 'file_tugas']);
    //     $model->addRule(['nama', 'kelas'], 'required')
    //         ->addRule(['file_tugas'], 'file', ['skipOnEmpty' => false, 'extensions' => 'pdf,doc,docx,zip,rar']);

    //     if (Yii::$app->request->isPost) {
    //         $model->file_tugas = UploadedFile::getInstance($model, 'file_tugas');

    //         if ($model->validate()) {
    //             $uploadPath = Yii::getAlias('@webroot/uploads/pengumpulan/');
    //             if (!is_dir($uploadPath)) {
    //                 \yii\helpers\FileHelper::createDirectory($uploadPath, 0775, true);
    //             }

    //             $filename = time() . '_' . preg_replace('/\s+/', '_', $model->file_tugas->baseName) . '.' . $model->file_tugas->extension;
    //             $filePath = $uploadPath . $filename;
    //             $model->file_tugas->saveAs($filePath);

    //             Yii::$app->session->setFlash('success', 'Tugas berhasil dikumpulkan!');
    //             return $this->refresh();
    //         }
    //     }

    //     return $this->render('pengumpulan-tugas', ['model' => $model]);
    // }
}

