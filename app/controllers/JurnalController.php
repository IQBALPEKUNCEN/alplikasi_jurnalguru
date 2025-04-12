<?php

namespace app\controllers;

<<<<<<< HEAD
use app\models\base\Guru;
use app\models\base\Hari;
use app\models\base\Jenjang;
use Yii;
use app\models\base\Jurnal;
use app\models\base\Kelas;
use app\models\base\Mapel;
use app\models\JurnalSearch;
use app\models\Laporan;
use yii\base\DynamicModel;
=======
use Yii;
use app\models\base\Jurnal;
use app\models\JurnalSearch;
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
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
<<<<<<< HEAD
           
            if ($model->loadAll($this->request->post()) ) {
                //var_dump($model->tanggal);
                $hari = ['minggu','senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];

                 $tanggal = date('w', strtotime($model->tanggal));

                 $nama_hari = $hari[$tanggal];

                 $hari=Hari::find()
                 ->where(['nama'=> $nama_hari])
                 ->one();
                 $model->hari_id = $hari->hari_id;
                // var_dump($hari);
                // die;
                $model->saveAll();
                Yii::$app->session->setFlash('success', "Data berhasil ditambahkan");
               
=======
            if ($model->loadAll($this->request->post()) && $model->saveAll()) {
                Yii::$app->session->setFlash('success', "Data berhasil ditambahkan");
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
                return $this->redirect(['view', 'id' => $model->jurnal_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
<<<<<<< HEAD
       
=======
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
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
<<<<<<< HEAD
            $model->waktupresensi = date("Y-m-d H:i:s");
            $model->status = "HADIR";

=======
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
            if ($model->loadAll($this->request->post()) && $model->saveAll()) {
                Yii::$app->session->setFlash('success', "Data berhasil diupdate");
                return $this->redirect(['view', 'id' => $model->jurnal_id]);
            }
        }
<<<<<<< HEAD
        
=======

>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
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

<<<<<<< HEAD
   
   
//     public function actionLaporan()
// {
//     $model = new DynamicModel(['tanggal', 'kode_kelas', 'kode_mapel',]); // Tambahkan 'waktupresensi' di sini
//     $model->addRule(['tanggal', 'kode_kelas', 'kode_mapel',], 'required'); // Pastikan 'waktupresensi' juga ada di sini
//     $laporans = [];

//     $dataProvider = new \yii\data\ArrayDataProvider([
//         'allModels' => $laporans,
//         'pagination' => [
//             'pageSize' => 10,
//         ],
//     ]);

//     // var_dump($model);
//     // die;

//     // $laporan = new Laporan();

//     if ($model->load(Yii::$app->request->post()) ) {
//     //     var_dump($model->waktupresensi); // Cek nilai waktupresensi
//     // die;
//         // var_dump($model->tanggal);
//         // var_dump($model->kode_kelas);
//         // var_dump($model->kode_mapel);
//         // die;
//         $command = Yii::$app->db->createCommand("SELECT * FROM jurnal
//         INNER JOIN guru ON jurnal.guru_id = guru.guru_id 
//         WHERE jurnal.tanggal = :tanggal AND jurnal.kode_kelas = :kode_kelas AND jurnal.kode_mapel = :kode_mapel ");
//         $command->bindValue(':tanggal',$model->tanggal); 
//         $command->bindValue(':kode_kelas',$model->kode_kelas); 
//         $command->bindValue(':kode_mapel',$model->kode_mapel); 


//         $laporans = $command->queryAll();
//             // var_dump($laporans);
//             // die;

//         // Yii::$app->session->setFlash('success', "Laporan berhasil ditambahkan");
//         // return $this->redirect(['laporan']);
//     }

//     // Mengambil semua data laporan dari model
//     // $laporans = Laporan::find()->all();

//     // // Ambil data untuk dropdown
//     $jenjangs = Jenjang::find()->select(['kode_jenjang', 'nama'])->indexBy('kode_jenjang')->column();
//     $kelases = Kelas::find()->select(['kode_kelas', 'nama'])->indexBy('kode_kelas')->column();
//     $mapels = Mapel::find()->select(['kode_mapel', 'nama'])->indexBy('kode_mapel')->column();
    


    

//     // // Membuat data provider untuk laporan
//     // $dataProvider = new \yii\data\ArrayDataProvider([
//     //     'allModels' => $laporans,
//     //     'pagination' => [
//     //         'pageSize' => 10, // Sesuaikan dengan kebutuhan
//     //     ],
//     // ]);
//     // Mengembalikan view dengan data laporan dan model laporan baru
//     return $this->render('laporan', [
//         'laporans' => $laporans,
//         // 'laporan' => $laporan,
//         'jenjangs' => $jenjangs,
//         'kelases' => $kelases,
//         'mapels' => $mapels,
//         // 'dataProvider' => $dataProvider, // Pastikan dataProvider dikirim ke view
//         'model' => $model
//     ]);
// }

// public function actionLaporan()
// {
//     $model = new DynamicModel(['tanggal', 'kode_kelas', 'kode_mapel']);
//     $model->addRule(['tanggal', 'kode_kelas', 'kode_mapel'], 'required');
//     $laporans = [];

//     if ($model->load(Yii::$app->request->post())) {
//         // Siapkan query dasar
//         $query = "SELECT * FROM jurnal INNER JOIN guru ON jurnal.guru_id = guru.guru_id WHERE jurnal.tanggal = :tanggal";
        
//         // Tambahkan filter kode_kelas jika bukan "All"
//         if ($model->kode_kelas !== 'All') {
//             $query .= " AND jurnal.kode_kelas = :kode_kelas";
//         }

//         // Tambahkan filter kode_mapel jika bukan "All"
//         if ($model->kode_mapel !== 'All') {
//             $query .= " AND jurnal.kode_mapel = :kode_mapel";
//         }

//         // Buat command
//         $command = Yii::$app->db->createCommand($query);
//         $command->bindValue(':tanggal', $model->tanggal);

//         // Bind value untuk kode_kelas jika bukan "All"
//         if ($model->kode_kelas !== 'All') {
//             $command->bindValue(':kode_kelas', $model->kode_kelas);
//         }

//         // Bind value untuk kode_mapel jika bukan "All"
//         if ($model->kode_mapel !== 'All') {
//             $command->bindValue(':kode_mapel', $model->kode_mapel);
//         }

//         // Eksekusi query dan ambil hasilnya
//         $laporans = $command->queryAll();
//     }

//     // Ambil data untuk dropdown
//     $jenjangs = Jenjang::find()->select(['kode_jenjang', 'nama'])->indexBy('kode_jenjang')->column();
//     $kelases = Kelas::find()->select(['kode_kelas', 'nama'])->indexBy('kode_kelas')->column();
//     $mapels = Mapel::find()->select(['kode_mapel', 'nama'])->indexBy('kode_mapel')->column();

//     // Render view dengan hasil laporan
//     return $this->render('laporan', [
//         'laporans' => $laporans,
//         'jenjangs' => $jenjangs,
//         'kelases' => $kelases,
//         'mapels' => $mapels,
//         'model' => $model,
//     ]);
// }

public function actionLaporan()
{
    $model = new DynamicModel(['tanggal', 'kode_kelas', 'kode_mapel']);
    $model->addRule(['tanggal'], 'required')
          ->addRule(['kode_kelas', 'kode_mapel'], 'safe');
    $laporans = [];

    if ($model->load(Yii::$app->request->post()) && $model->validate()) {
        // Siapkan query dasar
        $query = "SELECT jurnal.*, guru.nama 
                  FROM jurnal 
                  INNER JOIN guru ON jurnal.guru_id = guru.guru_id 
                  WHERE jurnal.tanggal = :tanggal";
        
        // Tambahkan filter kode_kelas jika bukan "All"
        if (!empty($model->kode_kelas) && $model->kode_kelas !== 'All') {
            $query .= " AND jurnal.kode_kelas = :kode_kelas";
        }

        // Tambahkan filter kode_mapel jika bukan "All"
        if (!empty($model->kode_mapel) && $model->kode_mapel !== 'All') {
            $query .= " AND jurnal.kode_mapel = :kode_mapel";
        }

        // Buat command
        $command = Yii::$app->db->createCommand($query);
        $command->bindValue(':tanggal', $model->tanggal);

        // Bind value untuk kode_kelas jika bukan "All"
        if (!empty($model->kode_kelas) && $model->kode_kelas !== 'All') {
            $command->bindValue(':kode_kelas', $model->kode_kelas);
        }

        // Bind value untuk kode_mapel jika bukan "All"
        if (!empty($model->kode_mapel) && $model->kode_mapel !== 'All') {
            $command->bindValue(':kode_mapel', $model->kode_mapel);
        }

        // Eksekusi query dan ambil hasilnya
        $laporans = $command->queryAll();
    }

    // Ambil data untuk dropdown
    $jenjangs = Jenjang::find()->select(['kode_jenjang', 'nama'])->indexBy('kode_jenjang')->column();
    $kelases = Kelas::find()->select(['kode_kelas', 'nama'])->indexBy('kode_kelas')->column();
    $mapels = Mapel::find()->select(['kode_mapel', 'nama'])->indexBy('kode_mapel')->column();

    // Tambahkan opsi "All" pada dropdown
    $kelases = ['All' => 'Semua Kelas'] + $kelases;
    $mapels = ['All' => 'Semua Mapel'] + $mapels;

    // Render view dengan hasil laporan
    return $this->render('laporan', [
        'laporans' => $laporans,
        'jenjangs' => $jenjangs,
        'kelases' => $kelases,
        'mapels' => $mapels,
        'model' => $model,
    ]);
}











protected function findModel($id)
{
    if (($model = Jurnal::findOne($id)) !== null) {
        return $model;
    }

    throw new NotFoundHttpException('The requested page does not exist.');
}

    
    

=======
    
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
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
    
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
