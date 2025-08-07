<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\DynamicModel;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use app\models\base\Jurnal;
use app\models\base\Hari;
use app\models\base\Kelas;
use app\models\base\Mapel;
use app\models\JurnalSearch;
use app\models\JurnalDetil;
use app\models\Siswa;
use app\models\Jurusan;
use Exception;
use yii\web\Response;



class JurnalController extends Controller
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
                    'update-status' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new JurnalSearch();
        $currentUser = Yii::$app->user->identity;

        // Tentukan apakah user adalah admin atau bukan
        $isAdmin = $currentUser && in_array($currentUser->username, ['admin', 'superadmin']);

        if ($isAdmin) {
            // Jika admin, gunakan search tanpa filter user
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, false);
        } else {
            // Jika bukan admin, buat query manual dengan filter
            $query = \app\models\base\Jurnal::find();

            // Tambahkan join dan filter untuk non-admin
            $query->alias('j')
                ->joinWith([
                    'guru g',
                    'kodeta0 ta',
                    'hari h',
                    'kodeKelas k',
                    'kodeMapel m'
                ])
                ->andWhere(['g.nama' => $currentUser->username]);

            $dataProvider = new \yii\data\ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => 20,
                ],
                'sort' => [
                    'defaultOrder' => [
                        'jurnal_id' => SORT_DESC
                    ]
                ]
            ]);

            // Load search parameters
            $searchModel->load(Yii::$app->request->queryParams);

            // Apply search filters
            if ($searchModel->validate()) {
                $query->andFilterWhere([
                    'j.jurnal_id' => $searchModel->jurnal_id,
                    'j.guru_id' => $searchModel->guru_id,
                    'j.hari_id' => $searchModel->hari_id,
                    'j.jam_ke' => $searchModel->jam_ke,
                    'j.tanggal' => $searchModel->tanggal,
                ]);

                $query->andFilterWhere(['like', 'j.kodeta', $searchModel->kodeta])
                    ->andFilterWhere(['like', 'j.kode_kelas', $searchModel->kode_kelas])
                    ->andFilterWhere(['like', 'j.kode_mapel', $searchModel->kode_mapel])
                    ->andFilterWhere(['like', 'j.status', $searchModel->status])
                    ->andFilterWhere(['like', 'j.materi', $searchModel->materi]);
            }
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    
    public function actionView($id)
    {
        // Load model jurnal dengan relasi yang diperlukan
        $model = $this->findModel($id);

        // Load data jurnal detail dengan relasi yang diperlukan
        $providerJurnalDetil = new ActiveDataProvider([
            'query' => JurnalDetil::find()
                ->where(['jurnal_id' => $id])
                ->with([
                    'nis0',
                    'nis0.kodeKelas',
                    'nis0.kodeKelas.kodeJurusan',
                    'siswa',
                    'siswa.kodeKelas',
                    'siswa.kodeKelas.kodeJurusan'
                ]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        // Debug untuk melihat apakah ada data
        $count = JurnalDetil::find()->where(['jurnal_id' => $id])->count();
        Yii::info("Jurnal Detail count for ID {$id}: {$count}", __METHOD__);

        return $this->render('view', [
            'model' => $model,
            'providerJurnalDetil' => $providerJurnalDetil,
        ]);
    }

    // Method untuk mencari model dengan relasi
    protected function findModel($id)
    {
        if (($model = Jurnal::find()
            ->where(['jurnal_id' => $id])
            ->with([
                'guru',
                'kodeta0',
                'hari',
                'kodeKelas',
                'kodeMapel'
            ])
            ->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    // Fungsi bantu konversi format tanggal dan waktu
    private function convertDateTimeFormat($dateTimeString, $fromFormat, $toFormat)
    {
        try {
            if (empty($dateTimeString)) {
                return null;
            }

            $dt = \DateTime::createFromFormat($fromFormat, $dateTimeString);
            if ($dt === false) {
                return null;
            }

            return $dt->format($toFormat);
        } catch (\Exception $e) {
            Yii::error("DateTime conversion error: " . $e->getMessage(), __METHOD__);
            return null;
        }
    }

    // Fungsi bantu untuk proses input waktu
    private function processWaktuPresensi($waktuInput, $tanggal = null)
    {
        if (empty($waktuInput)) {
            return date('Y-m-d H:i:s');
        }

        $formats = [
            'd/m/Y H:i',
            'd/m/Y H:i:s',
            'Y-m-d H:i:s',
            'Y-m-d H:i',
            'H:i',
            'H:i:s',
        ];

        foreach ($formats as $format) {
            try {
                $dt = \DateTime::createFromFormat($format, $waktuInput);
                if ($dt !== false) {
                    if (in_array($format, ['H:i', 'H:i:s'])) {
                        $dateBase = !empty($tanggal) ? $tanggal : date('Y-m-d');
                        return $dateBase . ' ' . $dt->format('H:i:s');
                    }

                    return $dt->format('Y-m-d H:i:s');
                }
            } catch (\Exception $e) {
                continue;
            }
        }

        return date('Y-m-d H:i:s');
    }

    public function actionCreate()
    {
        $model = new Jurnal();
        $postData = Yii::$app->request->post();

        if ($model->load($postData)) {
            if (empty($model->tanggal)) {
                $model->tanggal = date('Y-m-d');
            }

            if (empty($model->status)) {
                $model->status = 'HADIR';
            }

            if (!empty($model->tanggal) && empty($model->hari_id)) {
                $this->setHariFromTanggal($model);
            }

            if (!empty($postData['Jurnal']['waktupresensi'])) {
                $waktuInput = $postData['Jurnal']['waktupresensi'];
                $model->waktupresensi = $this->processWaktuPresensi($waktuInput, $model->tanggal);
            } else {
                $model->waktupresensi = $this->processWaktuPresensi(null, $model->tanggal);
            }

            if ($model->validate()) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($model->save(false)) {
                        if (!empty($postData['JurnalDetil']) && is_array($postData['JurnalDetil'])) {
                            foreach ($postData['JurnalDetil'] as $detilData) {
                                $detil = new JurnalDetil();
                                $detil->attributes = [
                                    "status" => $detilData["status"],
                                    "nis" => $detilData["siswa_id"],
                                    "kode_jurusan" => $detilData["kode_jurusan"] ?? null,
                                ];
                                $detil->jurnal_id = $model->jurnal_id;

                                if (!$detil->save()) {
                                    $transaction->rollBack();
                                    Yii::$app->session->setFlash('error', 'Gagal menyimpan detail jurnal');
                                    return $this->render('create', ['model' => $model]);
                                }
                            }
                        }

                        $transaction->commit();
                        Yii::$app->session->setFlash('success', 'Data jurnal berhasil ditambahkan');
                        return $this->redirect(['index']);
                    } else {
                        $transaction->rollBack();
                        Yii::$app->session->setFlash('error', 'Gagal menyimpan data jurnal');
                    }
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    Yii::error($e->getMessage(), __METHOD__);
                    Yii::$app->session->setFlash('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
                }
            } else {
                Yii::$app->session->setFlash('error', 'Validasi gagal.');
            }
        } else {
            $model->tanggal = date('Y-m-d');
            $model->status = 'HADIR';
            $model->waktupresensi = date('Y-m-d H:i:s');
            $this->setHariFromTanggal($model);
        }

        return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $postData = Yii::$app->request->post();

        if ($model->load($postData)) {
            if (!empty($postData['Jurnal']['waktupresensi'])) {
                $waktuInput = $postData['Jurnal']['waktupresensi'];
                $convertedTime = $this->processWaktuPresensi($waktuInput, $model->tanggal);
                $model->waktupresensi = $convertedTime ?? $model->waktupresensi;
            } else {
                $model->waktupresensi = date('Y-m-d H:i:s');
            }

            if (!empty($model->tanggal)) {
                $this->setHariFromTanggal($model);
            }

            if (!$model->hasErrors() && $model->validate()) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($model->save(false)) {
                        JurnalDetil::deleteAll(['jurnal_id' => $model->jurnal_id]);

                        if (!empty($postData['JurnalDetil']) && is_array($postData['JurnalDetil'])) {
                            foreach ($postData['JurnalDetil'] as $index => $detilData) {
                                if (empty($detilData['siswa_id']) || empty($detilData['status'])) {
                                    $transaction->rollBack();
                                    Yii::$app->session->setFlash('error', "Data detail jurnal tidak lengkap pada baris " . ($index + 1));
                                    return $this->render('update', ['model' => $model, 'modelsDetil' => []]);
                                }

                                $detil = new JurnalDetil();
                                $detil->attributes = [
                                    "status" => $detilData["status"],
                                    "nis" => $detilData["siswa_id"],
                                    "kode_jurusan" => $detilData["kode_jurusan"] ?? null,
                                ];
                                $detil->jurnal_id = $model->jurnal_id;

                                if (!$detil->validate()) {
                                    $transaction->rollBack();
                                    Yii::$app->session->setFlash('error', 'Validasi detail jurnal gagal');
                                    return $this->render('update', ['model' => $model, 'modelsDetil' => []]);
                                }

                                if (!$detil->save(false)) {
                                    $transaction->rollBack();
                                    Yii::$app->session->setFlash('error', 'Gagal menyimpan detail jurnal pada baris ' . ($index + 1));
                                    return $this->render('update', ['model' => $model, 'modelsDetil' => []]);
                                }
                            }
                        }

                        $transaction->commit();
                        Yii::$app->session->setFlash('success', 'Jurnal berhasil diperbarui.');
                        return $this->redirect(['view', 'id' => $model->jurnal_id]);
                    } else {
                        $transaction->rollBack();
                        Yii::$app->session->setFlash('error', 'Gagal menyimpan jurnal.');
                    }
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    Yii::error($e->getMessage(), __METHOD__);
                    Yii::$app->session->setFlash('error', 'Terjadi kesalahan: ' . $e->getMessage());
                }
            }
        }

        // Ambil data JurnalDetil untuk ditampilkan kembali
        $modelsDetil = JurnalDetil::find()
            ->where(['jurnal_id' => $model->jurnal_id])
            ->asArray()
            ->all();

        return $this->render('update', [
            'model' => $model,
            'modelsDetil' => $modelsDetil,
        ]);
    }

    private function setHariFromTanggal($model)
    {
        if (!empty($model->tanggal)) {
            $hariList = ['minggu', 'senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];
            $dayIndex = date('w', strtotime($model->tanggal));
            $namaHari = $hariList[$dayIndex];

            try {
                $hari = Hari::find()->where(['nama' => $namaHari])->one();
                if ($hari) {
                    $model->hari_id = $hari->hari_id;
                }
            } catch (\Exception $e) {
                Yii::error("Error finding hari: " . $e->getMessage(), __METHOD__);
            }
        }
    }

    // public function actionUpdate($id)
    // {
    //     $model = $this->findModel($id);
    //     $postData = Yii::$app->request->post();

    //     if ($model->load($postData)) {

    //         // Proses waktu presensi
    //         if (!empty($postData['Jurnal']['waktupresensi'])) {
    //             $waktuInput = $postData['Jurnal']['waktupresensi'];
    //             $convertedTime = $this->processWaktuPresensi($waktuInput, $model->tanggal);

    //             if ($convertedTime !== null) {
    //                 $model->waktupresensi = $convertedTime;
    //             } else {
    //                 $model->addError('waktupresensi', 'Format waktu presensi tidak valid.');
    //             }
    //         } else {
    //             $model->waktupresensi = date('Y-m-d H:i:s');
    //         }

    //         // Set hari otomatis dari tanggal
    //         if (!empty($model->tanggal)) {
    //             $this->setHariFromTanggal($model);
    //         }

    //         if (!$model->hasErrors() && $model->validate()) {
    //             $transaction = Yii::$app->db->beginTransaction();
    //             try {
    //                 if ($model->save(false)) {

    //                     // Hapus detail jurnal lama
    //                     JurnalDetil::deleteAll(['jurnal_id' => $model->jurnal_id]);

    //                     if (!empty($postData['JurnalDetil']) && is_array($postData['JurnalDetil'])) {
    //                         Yii::info("JurnalDetil update data received: " . json_encode($postData['JurnalDetil']), __METHOD__);

    //                         foreach ($postData['JurnalDetil'] as $index => $detilData) {
    //                             if (empty($detilData['siswa_id']) || empty($detilData['status'])) {
    //                                 $transaction->rollBack();
    //                                 Yii::$app->session->setFlash('error', "Data detail jurnal tidak lengkap pada baris " . ($index + 1));
    //                                 return $this->render('update', ['model' => $model]);
    //                             }

    //                             $detil = new JurnalDetil();
    //                             $detil->attributes = [
    //                                 "status" => $detilData["status"],
    //                                 "nis" => $detilData["siswa_id"],
    //                                 "kode_jurusan" => $detilData["kode_jurusan"] ?? null,
    //                             ];
    //                             $detil->jurnal_id = $model->jurnal_id;

    //                             if (!$detil->validate()) {
    //                                 $transaction->rollBack();
    //                                 $errors = $detil->getErrors();
    //                                 $errorMessages = [];
    //                                 foreach ($errors as $field => $fieldErrors) {
    //                                     $errorMessages[] = $field . ': ' . implode(', ', $fieldErrors);
    //                                 }
    //                                 Yii::error("JurnalDetil validation failed: " . implode(' | ', $errorMessages), __METHOD__);
    //                                 Yii::$app->session->setFlash('error', 'Validasi detail jurnal gagal: ' . implode(' | ', $errorMessages));
    //                                 return $this->render('update', ['model' => $model]);
    //                             }

    //                             if (!$detil->save(false)) {
    //                                 $transaction->rollBack();
    //                                 Yii::error("JurnalDetil save failed for index $index", __METHOD__);
    //                                 Yii::$app->session->setFlash('error', 'Gagal menyimpan detail jurnal pada baris ' . ($index + 1));
    //                                 return $this->render('update', ['model' => $model]);
    //                             }
    //                         }
    //                     }

    //                     $transaction->commit();
    //                     Yii::$app->session->setFlash('success', 'Jurnal berhasil diperbarui.');
    //                     return $this->redirect(['view', 'id' => $model->jurnal_id]);
    //                 } else {
    //                     $transaction->rollBack();
    //                     Yii::$app->session->setFlash('error', 'Gagal menyimpan jurnal.');
    //                 }
    //             } catch (\Exception $e) {
    //                 $transaction->rollBack();
    //                 Yii::error($e->getMessage(), __METHOD__);
    //                 Yii::$app->session->setFlash('error', 'Terjadi kesalahan: ' . $e->getMessage());
    //             }
    //         } else {
    //             $errors = $model->getErrors();
    //             $errorMessages = [];
    //             foreach ($errors as $field => $fieldErrors) {
    //                 $errorMessages[] = $field . ': ' . implode(', ', $fieldErrors);
    //             }
    //             Yii::$app->session->setFlash('error', 'Validasi gagal: ' . implode(' | ', $errorMessages));
    //         }
    //     }

    //     return $this->render('update', ['model' => $model]);
    // }


    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($model->delete()) {
                $transaction->commit();
                Yii::$app->session->setFlash('success', 'Data berhasil dihapus');
            } else {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', 'Gagal menghapus data');
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::error($e->getMessage(), __METHOD__);
            Yii::$app->session->setFlash('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
        return $this->redirect(['index']);
    }
    public function actionLaporanSiswa()
    {
        $model = new \yii\base\DynamicModel([
            'tanggal_dari',
            'tanggal_sampai',
            'kode_kelas',
            'kode_mapel',
            'nis',
            'status',
            'kode_jurusan'
        ]);
        $model->addRule([
            'tanggal_dari',
            'tanggal_sampai',
            'kode_kelas',
            'kode_mapel',
            'nis',
            'status',
            'kode_jurusan'
        ], 'safe');

        $query = JurnalDetil::find()
            ->joinWith([
                'jurnal' => function ($q) {
                    $q->with(['guru', 'kodeKelas', 'kodeMapel', 'hari']);
                },
                'nis0' => function ($q) {
                    $q->joinWith([
                        'kodeKelas kodeKelas' => function ($q) {
                            $q->joinWith('kodeJurusan');
                        }
                    ]);
                }
            ])
            ->orderBy(['jurnal.tanggal' => SORT_DESC, 'jurnal.waktupresensi' => SORT_DESC]);

        if ($model->load(Yii::$app->request->get()) && $model->validate()) {
            if (!empty($model->tanggal_dari)) {
                $query->andWhere(['>=', 'jurnal.tanggal', $model->tanggal_dari]);
            }
            if (!empty($model->tanggal_sampai)) {
                $query->andWhere(['<=', 'jurnal.tanggal', $model->tanggal_sampai]);
            }

            // PERBAIKAN UTAMA: Filter kelas berdasarkan kode_kelas dari tabel jurnal
            if (!empty($model->kode_kelas)) {
                $query->andWhere(['jurnal.kode_kelas' => $model->kode_kelas]);
            }

            if (!empty($model->kode_mapel)) {
                $query->andWhere(['jurnal.kode_mapel' => $model->kode_mapel]);
            }
            if (!empty($model->nis)) {
                $query->andWhere(['jurnal_detil.nis' => $model->nis]);
            }
            if (!empty($model->status)) {
                $query->andWhere(['jurnal_detil.status' => $model->status]);
            }

            // PERBAIKAN: Filter jurusan berdasarkan kelas siswa, bukan jurnal
            if (!empty($model->kode_jurusan)) {
                // Gunakan join dengan tabel siswa dan kelas untuk filter jurusan
                $query->innerJoin('siswa s', 's.nis = jurnal_detil.nis')
                    ->innerJoin('kelas k', 'k.kode_kelas = s.kode_kelas')
                    ->andWhere(['k.kode_jurusan' => $model->kode_jurusan]);
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 50],
            'sort' => [
                'defaultOrder' => [
                    'tanggal' => SORT_DESC,
                    'waktupresensi' => SORT_DESC,
                ],
                'attributes' => [
                    'tanggal' => [
                        'asc' => ['jurnal.tanggal' => SORT_ASC],
                        'desc' => ['jurnal.tanggal' => SORT_DESC],
                    ],
                    'waktupresensi' => [
                        'asc' => ['jurnal.waktupresensi' => SORT_ASC],
                        'desc' => ['jurnal.waktupresensi' => SORT_DESC],
                    ],
                    'kode_kelas' => [
                        'asc' => ['jurnal.kode_kelas' => SORT_ASC],
                        'desc' => ['jurnal.kode_kelas' => SORT_DESC],
                    ],
                    'kode_mapel' => [
                        'asc' => ['jurnal.kode_mapel' => SORT_ASC],
                        'desc' => ['jurnal.kode_mapel' => SORT_DESC],
                    ],
                    'nis' => [
                        'asc' => ['jurnal_detil.nis' => SORT_ASC],
                        'desc' => ['jurnal_detil.nis' => SORT_DESC],
                    ],
                    'status' => [
                        'asc' => ['jurnal_detil.status' => SORT_ASC],
                        'desc' => ['jurnal_detil.status' => SORT_DESC],
                    ],
                ],
            ],
        ]);

        $totalHadir = $totalIzin = $totalSakit = $totalAlpa = 0;
        $statistikSiswa = [];

        foreach ($dataProvider->getModels() as $item) {
            $status = strtolower($item->status);
            $siswa = $item->nis0;

            switch ($status) {
                case 'hadir':
                    $totalHadir++;
                    break;
                case 'izin':
                    $totalIzin++;
                    break;
                case 'sakit':
                    $totalSakit++;
                    break;
                case 'alpa':
                    $totalAlpa++;
                    break;
            }

            if ($siswa) {
                $siswaKey = $siswa->nis;
                if (!isset($statistikSiswa[$siswaKey])) {
                    $statistikSiswa[$siswaKey] = [
                        'nama' => $siswa->nama,
                        'nis' => $siswa->nis,
                        'kelas' => $siswa->kodeKelas ? $siswa->kodeKelas->nama : '-',
                        'jurusan' => ($siswa->kodeKelas && $siswa->kodeKelas->kodeJurusan) ? $siswa->kodeKelas->kodeJurusan->nama : '-',
                        'hadir' => 0,
                        'izin' => 0,
                        'sakit' => 0,
                        'alpa' => 0,
                        'total' => 0,
                    ];
                }

                $statistikSiswa[$siswaKey][$status]++;
                $statistikSiswa[$siswaKey]['total']++;
            }
        }

        uasort($statistikSiswa, function ($a, $b) {
            return strcmp($a['nama'], $b['nama']);
        });

        try {
            // PERBAIKAN: Gunakan field yang benar untuk kelas list
            // Pastikan ini sesuai dengan struktur database Anda
            $kelasList = \yii\helpers\ArrayHelper::map(
                Kelas::find()->orderBy('nama')->all(),
                'kode_kelas',  // Pastikan ini adalah field yang benar
                'nama'
            );

            // Alternative jika field berbeda:
            // $kelasList = \yii\helpers\ArrayHelper::map(
            //     Kelas::find()->orderBy('nama')->all(), 
            //     'kode',  // Gunakan 'kode' jika field kodenya adalah 'kode'
            //     'nama'
            // );

            $mapelList = \yii\helpers\ArrayHelper::map(Mapel::find()->orderBy('nama')->all(), 'kode_mapel', 'nama');
            $siswaList = \yii\helpers\ArrayHelper::map(
                Siswa::find()->orderBy('nama')->all(),
                'nis',
                function ($siswa) {
                    return $siswa->nama . ' (' . $siswa->nis . ')';
                }
            );
            $statusList = [
                'HADIR' => 'Hadir',
                'IZIN' => 'Izin',
                'SAKIT' => 'Sakit',
                'ALPA' => 'Alpa',
            ];
            $jurusanList = \yii\helpers\ArrayHelper::map(Jurusan::find()->orderBy('nama')->all(), 'kode_jurusan', 'nama');
        } catch (\Exception $e) {
            Yii::error("Error loading reference data: " . $e->getMessage(), __METHOD__);
            $kelasList = $mapelList = $siswaList = $statusList = $jurusanList = [];
        }

        return $this->render('laporan-siswa', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'kelasList' => $kelasList,
            'mapelList' => $mapelList,
            'siswaList' => $siswaList,
            'statusList' => $statusList,
            'jurusanList' => $jurusanList,
            'totalHadir' => $totalHadir,
            'totalIzin' => $totalIzin,
            'totalSakit' => $totalSakit,
            'totalAlpa' => $totalAlpa,
            'statistikSiswa' => $statistikSiswa,
        ]);
    }

    public function actionLaporanGuru()
    {
        $model = new \yii\base\DynamicModel([
            'tanggal_dari',
            'tanggal_sampai',
            'kode_kelas',
            'kode_mapel',
            'nip',
            'status',
        ]);
        $model->addRule([
            'tanggal_dari',
            'tanggal_sampai',
            'kode_kelas',
            'kode_mapel',
            'nip',
            'status',
        ], 'safe');

        $query = Jurnal::find()
            ->joinWith(['guru', 'kodeKelas', 'kodeMapel', 'hari'])
            ->orderBy(['tanggal' => SORT_DESC, 'waktupresensi' => SORT_DESC]);

        if ($model->load(Yii::$app->request->get()) && $model->validate()) {
            if (!empty($model->tanggal_dari)) {
                $query->andWhere(['>=', 'tanggal', $model->tanggal_dari]);
            }
            if (!empty($model->tanggal_sampai)) {
                $query->andWhere(['<=', 'tanggal', $model->tanggal_sampai]);
            }
            if (!empty($model->kode_kelas)) {
                $query->andWhere(['jurnal.kode_kelas' => $model->kode_kelas]);
            }
            if (!empty($model->kode_mapel)) {
                $query->andWhere(['jurnal.kode_mapel' => $model->kode_mapel]);
            }
            if (!empty($model->nip)) {
                $query->andWhere(['guru.nip' => $model->nip]);
            }
            if (!empty($model->status)) {
                $query->andWhere(['jurnal.status' => $model->status]);
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 50],
            'sort' => [
                'defaultOrder' => [
                    'tanggal' => SORT_DESC,
                    'waktupresensi' => SORT_DESC,
                ],
            ],
        ]);

        // Statistik total
        $totalHadir = $totalIzin = $totalSakit = $totalAlpa = 0;
        $statistikGuru = [];

        // PERBAIKAN: Ambil semua data untuk statistik, bukan dari pagination
        $allData = $query->all();

        foreach ($allData as $item) {
            $status = strtolower($item->status);
            $guru = $item->guru;

            // Hitung total keseluruhan
            switch ($status) {
                case 'hadir':
                    $totalHadir++;
                    break;
                case 'izin':
                    $totalIzin++;
                    break;
                case 'sakit':
                    $totalSakit++;
                    break;
                case 'alpa':
                    $totalAlpa++;
                    break;
            }

            // PERBAIKAN: Pastikan guru ada dan NIP valid
            if ($guru && !empty($guru->nip)) {
                $nip = $guru->nip;

                // Inisialisasi array untuk guru jika belum ada
                if (!isset($statistikGuru[$nip])) {
                    $statistikGuru[$nip] = [
                        'nama' => $guru->nama,
                        'nip' => $guru->nip,
                        'hadir' => 0,
                        'izin' => 0,
                        'sakit' => 0,
                        'alpa' => 0,
                        'tidak_hadir' => 0,
                        'total' => 0,
                    ];
                }

                // PERBAIKAN: Perbaiki penghitungan per status
                switch ($status) {
                    case 'hadir':
                        $statistikGuru[$nip]['hadir']++;
                        break;
                    case 'izin':
                        $statistikGuru[$nip]['izin']++;
                        break;
                    case 'sakit':
                        $statistikGuru[$nip]['sakit']++;
                        break;
                    case 'alpa':
                        $statistikGuru[$nip]['alpa']++;
                        $statistikGuru[$nip]['tidak_hadir']++;
                        break;
                }

                // Tambah total
                $statistikGuru[$nip]['total']++;
            }
        }

        // Urutkan berdasarkan nama guru
        uasort($statistikGuru, function ($a, $b) {
            return strcmp($a['nama'], $b['nama']);
        });

        try {
            $kelasList = \yii\helpers\ArrayHelper::map(Kelas::find()->orderBy('nama')->all(), 'kode_kelas', 'nama');
            $mapelList = \yii\helpers\ArrayHelper::map(Mapel::find()->orderBy('nama')->all(), 'kode_mapel', 'nama');
            $guruList = \yii\helpers\ArrayHelper::map(
                \app\models\Guru::find()->orderBy('nama')->all(),
                'nip',
                function ($guru) {
                    return $guru->nama . ' (' . $guru->nip . ')';
                }
            );
            $statusList = [
                'HADIR' => 'Hadir',
                'IZIN' => 'Izin',
                'SAKIT' => 'Sakit',
                'ALPA' => 'Alpa',
            ];
        } catch (\Exception $e) {
            Yii::error("Error loading reference data: " . $e->getMessage(), __METHOD__);
            $kelasList = $mapelList = $guruList = $statusList = [];
        }

        return $this->render('laporan-guru', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'kelasList' => $kelasList,
            'mapelList' => $mapelList,
            'guruList' => $guruList,
            'statusList' => $statusList,
            'totalHadir' => $totalHadir,
            'totalIzin' => $totalIzin,
            'totalSakit' => $totalSakit,
            'totalAlpa' => $totalAlpa,
            'statistikGuru' => $statistikGuru,
        ]);
    }



    public function actionUpdateStatus($id, $status = 'HADIR')
    {
        $model = $this->findModel($id);

        if ($model) {
            $allowedStatus = ['HADIR', 'ALPA', 'IZIN', 'SAKIT'];

            if (!in_array($status, $allowedStatus)) {
                Yii::$app->session->setFlash('error', 'Status tidak valid');
                return $this->redirect(['view', 'id' => $id]);
            }

            $oldStatus = $model->status;
            $model->status = $status;

            if ($status === 'HADIR' && $oldStatus !== 'HADIR') {
                $tanggal = !empty($model->tanggal) ? $model->tanggal : date('Y-m-d');
                $model->waktupresensi = $tanggal . ' ' . date('H:i:s');
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', "Status berhasil diubah");
            } else {
                $errors = $model->getErrors();
                $errorMessages = [];
                foreach ($errors as $field => $fieldErrors) {
                    $errorMessages[] = $field . ': ' . implode(', ', $fieldErrors);
                }
                Yii::$app->session->setFlash('error', 'Gagal mengubah status: ' . implode(' | ', $errorMessages));
            }
        }

        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionSearchByTime()
    {
        $time = Yii::$app->request->get('time');
        $status = Yii::$app->request->get('status', 'HADIR');

        if (empty($time)) {
            return $this->asJson([
                'status' => 'error',
                'message' => 'Parameter waktu tidak boleh kosong'
            ]);
        }

        try {
            $query = Jurnal::find()
                ->where(['status' => $status])
                ->andWhere(['like', 'waktupresensi', $time]);

            $count = $query->count();

            return $this->asJson([
                'status' => 'success',
                'count' => $count,
                'message' => "Ditemukan {$count} jurnal dengan waktu {$time} dan status {$status}"
            ]);
        } catch (\Exception $e) {
            return $this->asJson([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function actionGetSiswaJurusan()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $siswaId = \Yii::$app->request->get('siswa_id');

        if ($siswaId) {
            try {
                // Coba dengan model Siswa biasa
                $siswa = Siswa::findOne($siswaId);
                if ($siswa) {
                    return [
                        'success' => true,
                        'kode_jurusan' => $siswa->getKodeJurusan()
                    ];
                }

                // Jika tidak ditemukan, coba dengan base model
                $siswa = \app\models\base\Siswa::findOne($siswaId);
                if ($siswa) {
                    return [
                        'success' => true,
                        'kode_jurusa' => $siswa->getKodeJurusan()
                    ];
                }
            } catch (Exception $e) {
                return [
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ];
            }
        }

        return [
            'success' => false,
            'message' => 'Siswa tidak ditemukan'
        ];
    }

    public function actionAddJurnalDetil()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('JurnalDetil');
            if ((Yii::$app->request->post('_action') == 'add') && empty($row)) {
                $row[] = [];
            }
            return $this->renderAjax('_formJurnalDetil', ['row' => $row]);
        }
        throw new NotFoundHttpException('Halaman tidak ditemukan.');
    }

    // Method untuk debug data
    public function actionDebugJurnalDetil($id)
    {
        $details = JurnalDetil::find()
            ->where(['jurnal_id' => $id])
            ->with([
                'nis0',
                'nis0.kodeKelas',
                'nis0.kodeKelas.kodeJurusan'
            ])
            ->all();

        echo "<h3>Debug Jurnal Detail untuk ID: {$id}</h3>";
        echo "<p>Jumlah record: " . count($details) . "</p>";

        foreach ($details as $detail) {
            echo "<hr>";
            echo "<p>NIS: " . $detail->nis . "</p>";
            echo "<p>Status: " . $detail->status . "</p>";
            echo "<p>Siswa (nis0): " . ($detail->nis0 ? $detail->nis0->nama : 'NULL') . "</p>";
            echo "<p>Kelas: " . ($detail->nis0 && $detail->nis0->kodeKelas ? $detail->nis0->kodeKelas->nama : 'NULL') . "</p>";
            echo "<p>Jurusan: " . ($detail->nis0 && $detail->nis0->kodeKelas && $detail->nis0->kodeKelas->kodeJurusan ? $detail->nis0->kodeKelas->kodeJurusan->nama : 'NULL') . "</p>";
        }

        exit;
    }

    public function actionGetSiswaByKelas()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $kodeKelas = \Yii::$app->request->get('kode_kelas');

        if (empty($kodeKelas)) {
            return [
                'success' => false,
                'message' => 'Kode kelas tidak boleh kosong'
            ];
        }

        try {
            // Coba beberapa cara untuk mengambil data siswa
            $siswaList = [];

            // Cara 1: Jika ada relasi langsung antara Siswa dan Kelas
            try {
                $siswaList = \app\models\Siswa::find()
                    ->where(['kode_kelas' => $kodeKelas])
                    ->orderBy('nama ASC')
                    ->all();
            } catch (\Exception $e) {
                // Cara 2: Jika menggunakan model base
                try {
                    $siswaList = \app\models\base\Siswa::find()
                        ->where(['kode_kelas' => $kodeKelas])
                        ->orderBy('nama ASC')
                        ->all();
                } catch (\Exception $e2) {
                    // Cara 3: Query manual jika struktur tabel berbeda
                    $siswaList = \app\models\Siswa::find()
                        ->where(['kelas_id' => $kodeKelas]) // atau field lain yang sesuai
                        ->orderBy('nama ASC')
                        ->all();
                }
            }

            $siswaJurusanMap = [];

            foreach ($siswaList as $siswa) {
                // Pastikan menggunakan field yang benar
                $siswaId = isset($siswa->id) ? $siswa->id : $siswa->nis;
                $siswaJurusanMap[$siswaId] = [
                    'nama' => $siswa->nama,
                    'nis' => isset($siswa->nis) ? $siswa->nis : $siswaId,
                    'jurusan' => isset($siswa->kode_jurusan) ? $siswa->kode_jurusan : '',
                ];
            }

            return [
                'success' => true,
                'data' => $siswaJurusanMap,
                'message' => 'Data siswa berhasil dimuat'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Gagal memuat data siswa: ' . $e->getMessage()
            ];
        }
    }

}
