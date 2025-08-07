<?php

namespace app\controllers;

use Yii;
use app\models\base\Historykelas;
use app\models\base\Siswa;
use app\models\base\Kelas;
use app\models\HistorykelasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\helpers\Json;
use yii\helpers\Url;

/**
 * HistorykelasController implements the CRUD actions for Historykelas model.
 * Updated to support Pengumuman (Announcement) features with WhatsApp integration
 */
class HistorykelasController extends Controller
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
                    'kirim-wa' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new HistorykelasSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionCreate()
    {
        $model = new Historykelas();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                // Set default values untuk pengumuman
                if (empty($model->tanggal_pengumuman)) {
                    $model->tanggal_pengumuman = date('Y-m-d');
                }
                if (empty($model->status_kirim)) {
                    $model->status_kirim = 'draft';
                }

                if ($model->save()) {
                    Yii::$app->session->setFlash('success', "Pengumuman berhasil dibuat");
                    return $this->redirect(['view', 'id' => $model->history_id]);
                }
            }
        } else {
            $model->loadDefaultValues();
            $model->tanggal_pengumuman = date('Y-m-d');
            $model->status_kirim = 'draft';
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', "Pengumuman berhasil diupdate");
                return $this->redirect(['view', 'id' => $model->history_id]);
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
            Yii::$app->session->setFlash('success', "Berhasil menghapus pengumuman.");
        } else {
            Yii::$app->session->setFlash('error', 'Gagal menghapus pengumuman.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Get siswa by kelas for WhatsApp sending
     */
    public function actionGetSiswaByKelas()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $kelas = $this->request->get('kelas');

        if (empty($kelas)) {
            return [
                'success' => false,
                'message' => 'Kelas tidak boleh kosong'
            ];
        }

        try {
            // Get siswa berdasarkan kelas dari tabel historykelas
            $siswaList = Siswa::find()
                ->joinWith('historyKelas')
                ->where(['historykelas.kode_kelas' => $kelas])
                ->andWhere(['IS NOT', 'siswa.no_hp', null])
                ->andWhere(['!=', 'siswa.no_hp', ''])
                ->all();

            $html = '<div class="siswa-list">';
            $html .= '<h5><i class="fa fa-users"></i> Daftar Siswa (' . count($siswaList) . ' siswa)</h5>';

            if (empty($siswaList)) {
                $html .= '<div class="alert alert-warning">Tidak ada siswa dengan nomor HP yang terdaftar di kelas ini.</div>';
            } else {
                $html .= '<div class="row">';
                foreach ($siswaList as $siswa) {
                    $html .= '<div class="col-md-6">';
                    $html .= '<div class="checkbox">';
                    $html .= '<label>';
                    $html .= '<input type="checkbox" name="siswa_terpilih[]" value="' . $siswa->nis . '" data-hp="' . $siswa->no_hp . '" checked> ';
                    $html .= $siswa->nama_siswa . ' (' . $siswa->nis . ')';
                    $html .= '<br><small class="text-muted"><i class="fa fa-phone"></i> ' . $siswa->no_hp . '</small>';
                    $html .= '</label>';
                    $html .= '</div>';
                    $html .= '</div>';
                }
                $html .= '</div>';
            }
            $html .= '</div>';

            return $html;
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Kirim pengumuman ke WhatsApp
     */
    public function actionKirimWa()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (!$this->request->isPost) {
            return [
                'success' => false,
                'message' => 'Method tidak diizinkan'
            ];
        }

        $pengumumanId = $this->request->post('history_id');
        $token = $this->request->post('token');
        $siswaTerpilih = $this->request->post('siswa_terpilih', []);

        // Validasi token
        if ($token !== 'xkhUEThsZp3sGW2UE4Fi') {
            return [
                'success' => false,
                'message' => 'Token WhatsApp tidak valid'
            ];
        }

        if (empty($pengumumanId)) {
            return [
                'success' => false,
                'message' => 'ID Pengumuman tidak boleh kosong'
            ];
        }

        if (empty($siswaTerpilih)) {
            return [
                'success' => false,
                'message' => 'Pilih minimal satu siswa'
            ];
        }

        try {
            $model = $this->findModel($pengumumanId);

            // Format pesan WhatsApp
            $pesan = $this->formatPesanWhatsApp($model);

            $berhasilKirim = 0;
            $gagalKirim = 0;
            $errorMessages = [];

            foreach ($siswaTerpilih as $nis) {
                $siswa = Siswa::findOne($nis);
                if ($siswa && !empty($siswa->no_hp)) {
                    $nomorHP = $this->formatNomorHP($siswa->no_hp);

                    // Kirim WhatsApp (implementasi sesuai dengan API yang digunakan)
                    $result = $this->kirimWhatsApp($nomorHP, $pesan, $token);

                    if ($result['success']) {
                        $berhasilKirim++;

                        // Log pengiriman (optional)
                        $this->logPengiriman($model->history_id, $siswa->nis, $nomorHP, 'success');
                    } else {
                        $gagalKirim++;
                        $errorMessages[] = "Gagal kirim ke {$siswa->nama_siswa} ({$nomorHP}): {$result['message']}";

                        // Log pengiriman (optional)
                        $this->logPengiriman($model->history_id, $siswa->nis, $nomorHP, 'failed', $result['message']);
                    }
                }
            }

            // Update status pengumuman
            if ($berhasilKirim > 0) {
                $model->status_kirim = 'terkirim';
                $model->tanggal_kirim = date('Y-m-d H:i:s');
                $model->save();
            }

            return [
                'success' => true,
                'message' => "Berhasil mengirim ke {$berhasilKirim} siswa" . ($gagalKirim > 0 ? ", gagal {$gagalKirim} siswa" : ""),
                'details' => [
                    'berhasil' => $berhasilKirim,
                    'gagal' => $gagalKirim,
                    'errors' => $errorMessages
                ]
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Format pesan WhatsApp
     */
    private function formatPesanWhatsApp($model)
    {
        $prioritasIcon = $this->getPriorityIcon($model->tingkat_prioritas);

        $pesan = "{$prioritasIcon} *PENGUMUMAN KELAS*\n\n";
        $pesan .= "*{$model->judul_pengumuman}*\n\n";
        $pesan .= "{$model->isi_pengumuman}\n\n";
        $pesan .= "📅 Tanggal: {$model->tanggal_pengumuman}\n";
        $pesan .= "🏫 Kelas: {$model->kode_kelas}\n";
        $pesan .= "📊 Prioritas: {$model->tingkat_prioritas}\n\n";
        $pesan .= "_Pesan ini dikirim secara otomatis dari Sistem Sekolah_";

        return $pesan;
    }

    /**
     * Get priority icon
     */
    private function getPriorityIcon($prioritas)
    {
        switch ($prioritas) {
            case 'mendesak':
                return '🚨';
            case 'tinggi':
                return '⚠️';
            case 'sedang':
                return '📢';
            default:
                return '📋';
        }
    }

    /**
     * Format nomor HP
     */
    private function formatNomorHP($nomorHP)
    {
        // Remove non-numeric characters
        $nomor = preg_replace('/[^0-9]/', '', $nomorHP);

        // Convert to international format
        if (substr($nomor, 0, 1) === '0') {
            $nomor = '62' . substr($nomor, 1);
        } elseif (substr($nomor, 0, 2) !== '62') {
            $nomor = '62' . $nomor;
        }

        return $nomor;
    }

    /**
     * Kirim WhatsApp menggunakan API
     * Sesuaikan dengan provider WhatsApp API yang Anda gunakan
     */
    private function kirimWhatsApp($nomorHP, $pesan, $token)
    {
        try {
            // Contoh implementasi dengan cURL
            // Ganti URL dan parameter sesuai dengan API WhatsApp yang digunakan

            $url = "https://api.whatsapp.com/send"; // Ganti dengan URL API yang sesuai

            $data = [
                'token' => $token,
                'number' => $nomorHP,
                'message' => $pesan
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode === 200) {
                $result = json_decode($response, true);
                return [
                    'success' => true,
                    'message' => 'Pesan berhasil dikirim',
                    'response' => $result
                ];
            } else {
                return [
                    'success' => false,
                    'message' => "HTTP Error: {$httpCode}"
                ];
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Log pengiriman WhatsApp
     */
    private function logPengiriman($pengumumanId, $nis, $nomorHP, $status, $error = null)
    {
        // Implementasi logging sesuai kebutuhan
        // Bisa disimpan ke database atau file log

        $logData = [
            'tanggal' => date('Y-m-d H:i:s'),
            'pengumuman_id' => $pengumumanId,
            'nis' => $nis,
            'nomor_hp' => $nomorHP,
            'status' => $status,
            'error' => $error
        ];

        // Contoh: simpan ke file log
        $logFile = Yii::getAlias('@runtime/logs/whatsapp.log');
        file_put_contents($logFile, json_encode($logData) . "\n", FILE_APPEND | LOCK_EX);
    }

    /**
     * Action untuk melihat pengumuman publik (untuk siswa)
     */
    public function actionPengumuman($token = null)
    {
        // Validasi token untuk akses publik
        if ($token !== 'xkhUEThsZp3sGW2UE4Fi') {
            throw new NotFoundHttpException('Akses tidak diizinkan');
        }

        $pengumumanList = Historykelas::find()
            ->where(['status_kirim' => 'terkirim'])
            ->andWhere(['>=', 'tanggal_pengumuman', date('Y-m-d', strtotime('-30 days'))])
            ->orderBy(['tanggal_pengumuman' => SORT_DESC])
            ->all();

        return $this->render('pengumuman-publik', [
            'pengumumanList' => $pengumumanList,
            'token' => $token
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Historykelas::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Pengumuman tidak ditemukan.');
        }
    }
}
