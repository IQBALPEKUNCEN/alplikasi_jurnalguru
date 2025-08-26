<?php

namespace app\controllers;

use Yii;
use app\models\Historykelas;
use app\models\HistorykelasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use Exception;
use yii\helpers\Html;

class HistorykelasController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'send-telegram' => ['POST'],
                    'kirim-massal-telegram' => ['POST'],
                    'test-and-save-telegram-id' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new HistorykelasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

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
        $model = new Historykelas();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->history_id]);
        }

        return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->history_id]);
        }

        return $this->render('update', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();
        Yii::$app->session->setFlash('success', 'Pengumuman berhasil dihapus.');
        return $this->redirect(['index']);
    }

    /**
     * KIRIM TELEGRAM UNTUK SATU PENGUMUMAN
     * Mengirim pengumuman ke semua siswa dalam satu kelas.
     * Tidak menampilkan pesan per-siswa ke UI (hanya ringkasan).
     */
    public function actionSendTelegram()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        try {
            $history_id = Yii::$app->request->post('history_id');

            if (!$history_id) {
                return ['success' => false, 'message' => 'ID pengumuman tidak valid.'];
            }

            $model = $this->findModel($history_id);

            // Cek sudah pernah terkirim
            if ($model->status_kirim == 'terkirim') {
                return ['success' => false, 'message' => 'Pengumuman sudah pernah dikirim sebelumnya.'];
            }

            // Cek koneksi internet
            if (!$this->checkInternetConnection()) {
                return ['success' => false, 'message' => 'Tidak ada koneksi internet. Pastikan komputer terhubung ke internet.'];
            }

            // Ambil semua siswa dengan telegram_id
            $siswaList = $this->getSiswaByKelas($model);
            if (empty($siswaList)) {
                return ['success' => false, 'message' => 'Tidak ada siswa dengan Telegram ID di kelas ini.'];
            }

            $message = $this->formatTelegramMessage($model);
            $successCount = 0;
            $failedCount = 0;

            $issuesSummary = [
                'chat_not_found' => 0, // kemungkinan belum /start atau chat_id salah
                'bot_blocked'    => 0,
                'invalid_chat_id' => 0,
                'other_errors'   => 0,
            ];

            foreach ($siswaList as $siswa) {
                if (empty($siswa->telegram_id)) {
                    continue;
                }

                $siswaName = $this->getSiswaName($siswa);
                $chatId = trim((string)$siswa->telegram_id);

                $result = $this->sendTelegramNotificationWithRetry($chatId, $message, $siswaName);

                if ($result['success']) {
                    $successCount++;
                } else {
                    $failedCount++;

                    // Kategorikan jenis error (untuk ringkasan)
                    switch ($result['action_needed'] ?? 'OTHER') {
                        case 'STUDENT_START_BOT':
                            $issuesSummary['chat_not_found']++;
                            break;
                        case 'STUDENT_UNBLOCK_BOT':
                            $issuesSummary['bot_blocked']++;
                            break;
                        case 'UPDATE_CHAT_ID':
                            $issuesSummary['invalid_chat_id']++;
                            break;
                        default:
                            $issuesSummary['other_errors']++;
                            break;
                    }

                    // Log detail teknis per-siswa untuk admin (tidak tampil di UI)
                    Yii::error("Telegram send failed :: {$siswaName} ({$chatId}) :: {$result['error']}");
                }

                usleep(100000); // 0.1s hindari rate limit
            }

            if ($successCount > 0) {
                $model->status_kirim = 'terkirim';
                $model->tanggal_kirim = date('Y-m-d H:i:s');
                $model->save(false);
            }

            // SUSUN RINGKASAN UNTUK UI (tanpa list nama siswa/❌ asu dst)
            $parts = [];
            $parts[] = "✅ Berhasil: {$successCount}";
            if ($failedCount > 0) {
                $parts[] = "❗ Gagal: {$failedCount}";
            }

            $detail = [];
            if ($issuesSummary['chat_not_found'] > 0) {
                $detail[] = "{$issuesSummary['chat_not_found']} chat belum aktif /start atau chat_id salah";
            }
            if ($issuesSummary['bot_blocked'] > 0) {
                $detail[] = "{$issuesSummary['bot_blocked']} user memblokir bot";
            }
            if ($issuesSummary['invalid_chat_id'] > 0) {
                $detail[] = "{$issuesSummary['invalid_chat_id']} Chat ID tidak valid";
            }
            if ($issuesSummary['other_errors'] > 0) {
                $detail[] = "{$issuesSummary['other_errors']} error lain";
            }

            // Tambahkan saran singkat
            $advices = [];
            $botLink = $this->buildBotStartLink(); // t.me/username (jika tersedia di params)
            if (!empty($botLink) && $failedCount > 0) {
                $advices[] = "Bagikan link bot ke siswa bermasalah: {$botLink}";
            }
            $advices[] = "Minta siswa kirim /start ke bot & pastikan Chat ID benar (bisa dari @userinfobot).";

            $messageText = implode(' | ', $parts);
            if (!empty($detail)) {
                $messageText .= "\nDetail: " . implode(', ', $detail);
            }
            if (!empty($advices)) {
                $messageText .= "\nTips: " . implode(' ', $advices);
            }

            // Sukses bila ada minimal 1 terkirim
            return [
                'success' => $successCount > 0,
                'message' => $messageText
            ];
        } catch (Exception $e) {
            Yii::error('Error in actionSendTelegram: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()];
        }
    }

    /**
     * KIRIM MASSAL TELEGRAM untuk banyak pengumuman.
     * Tidak menampilkan pesan per-siswa ke UI (hanya ringkasan).
     */
    public function actionKirimMassalTelegram()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        try {
            $ids = Yii::$app->request->post('pengumuman_ids', []);

            if (empty($ids)) {
                return ['success' => false, 'message' => 'Tidak ada pengumuman terpilih.'];
            }

            if (!$this->checkInternetConnection()) {
                return ['success' => false, 'message' => 'Tidak ada koneksi internet. Pastikan komputer terhubung ke internet.'];
            }

            $totalSent = 0;
            $totalFailed = 0;
            $processedAnnouncements = 0;

            foreach ($ids as $id) {
                $model = Historykelas::findOne($id);
                if (!$model) {
                    continue;
                }
                if ($model->status_kirim == 'terkirim') {
                    continue;
                }

                $siswaList = $this->getSiswaByKelas($model);
                if (empty($siswaList)) {
                    continue;
                }

                $message = $this->formatTelegramMessage($model);
                $sentCount = 0;

                foreach ($siswaList as $siswa) {
                    if (empty($siswa->telegram_id)) {
                        continue;
                    }
                    $siswaName = $this->getSiswaName($siswa);
                    $chatId = trim((string)$siswa->telegram_id);

                    $result = $this->sendTelegramNotificationWithRetry($chatId, $message, $siswaName);
                    if ($result['success']) {
                        $sentCount++;
                        $totalSent++;
                    } else {
                        $totalFailed++;
                        Yii::error("Bulk send failed :: {$siswaName} ({$chatId}) :: {$result['error']}");
                    }

                    usleep(200000); // 0.2s
                }

                if ($sentCount > 0) {
                    $model->status_kirim = 'terkirim';
                    $model->tanggal_kirim = date('Y-m-d H:i:s');
                    $model->save(false);
                    $processedAnnouncements++;
                }
            }

            if ($processedAnnouncements > 0) {
                $msg = "✅ Pengumuman diproses: {$processedAnnouncements} | Pesan terkirim: {$totalSent}";
                if ($totalFailed > 0) {
                    $msg .= " | Gagal: {$totalFailed}. Pastikan siswa sudah /start & Chat ID benar.";
                }
                $botLink = $this->buildBotStartLink();
                if (!empty($botLink)) {
                    $msg .= " Bagikan link bot: {$botLink}";
                }
                return ['success' => true, 'message' => $msg];
            }

            return ['success' => false, 'message' => 'Tidak ada pengumuman yang dapat diproses.'];
        } catch (Exception $e) {
            Yii::error('Error in actionKirimMassalTelegram: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()];
        }
    }

    /**
     * Test dan Simpan Telegram ID siswa.
     */
    public function actionTestAndSaveTelegramId()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        try {
            $telegram_id = Yii::$app->request->post('telegram_id');
            $student_id  = Yii::$app->request->post('student_id');

            if (!$telegram_id || !$student_id) {
                return ['success' => false, 'message' => 'Data tidak lengkap.'];
            }

            $telegram_id = trim($telegram_id);

            if (!$this->validateTelegramChatId($telegram_id)) {
                return ['success' => false, 'message' => 'Format Chat ID tidak valid. Gunakan angka dari @userinfobot.'];
            }

            $testMessage = "✅ Telegram ID Anda berhasil diuji.\nAnda akan menerima pengumuman kelas di chat ini.\nJangan blokir bot agar tetap menerima notifikasi. Terima kasih 🙏";

            $result = $this->sendTelegramNotification($telegram_id, $testMessage);

            if ($result['success']) {
                $siswa = \app\models\Siswa::findOne($student_id);
                if ($siswa) {
                    $siswa->telegram_id = $telegram_id;
                    if ($siswa->save()) {
                        return ['success' => true, 'message' => '✅ Telegram ID tersimpan & terverifikasi. Silakan cek chat Telegram Anda.'];
                    }
                    return ['success' => false, 'message' => 'Gagal menyimpan ke database: ' . implode(', ', $siswa->getFirstErrors())];
                }
                return ['success' => false, 'message' => 'Data siswa tidak ditemukan.'];
            }

            // Panduan ringkas tanpa sebut nama per-siswa
            $hint = 'Gagal mengirim pesan uji. ';
            if (strpos(strtolower($result['error']), 'chat not found') !== false) {
                $hint .= 'Pastikan sudah kirim /start ke bot.';
            } elseif (strpos(strtolower($result['error']), 'blocked') !== false) {
                $hint .= 'Bot sedang diblokir. Mohon unblock bot.';
            } else {
                $hint .= 'Detail: ' . $result['error'];
            }
            return ['success' => false, 'message' => $hint];
        } catch (Exception $e) {
            Yii::error('Error in actionTestAndSaveTelegramId: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()];
        }
    }

    /**
     * Enhanced Telegram Error Handling (tanpa pesan per-siswa di UI).
     */
    protected function sendTelegramNotificationWithRetry($chat_id, $message, $studentName = 'Unknown')
    {
        $result = $this->sendTelegramNotification($chat_id, $message);

        if ($result['success']) {
            return $result;
        }

        $err = strtolower($result['error'] ?? '');

        if (strpos($err, 'chat not found') !== false) {
            $this->logTelegramIssue($chat_id, $studentName, 'CHAT_NOT_FOUND', $result['error']);
            return [
                'success' => false,
                'error' => 'Chat tidak ditemukan',
                'action_needed' => 'STUDENT_START_BOT'
            ];
        }
        if (strpos($err, 'blocked') !== false || strpos($err, 'forbidden') !== false) {
            $this->logTelegramIssue($chat_id, $studentName, 'BOT_BLOCKED', $result['error']);
            return [
                'success' => false,
                'error' => 'Bot diblokir oleh user',
                'action_needed' => 'STUDENT_UNBLOCK_BOT'
            ];
        }
        if (strpos($err, 'bad request') !== false) {
            $this->logTelegramIssue($chat_id, $studentName, 'INVALID_CHAT_ID', $result['error']);
            return [
                'success' => false,
                'error' => 'Chat ID tidak valid',
                'action_needed' => 'UPDATE_CHAT_ID'
            ];
        }

        $this->logTelegramIssue($chat_id, $studentName, 'OTHER_ERROR', $result['error'] ?? 'Unknown error');
        return [
            'success' => false,
            'error' => $result['error'] ?? 'Unknown error',
            'action_needed' => 'INVESTIGATE'
        ];
    }

    protected function logTelegramIssue($chat_id, $studentName, $issueType, $error)
    {
        Yii::error("Telegram Issue [{$issueType}] {$studentName} (ID: {$chat_id}) :: {$error}");
        // Optionally simpan ke DB seperti komentar Anda sebelumnya.
    }

    public function actionTelegramIssuesReport()
    {
        if (!YII_ENV_DEV && !Yii::$app->user->can('admin')) {
            throw new NotFoundHttpException('Access denied');
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        $siswaList = \app\models\Siswa::find()
            ->where(['IS NOT', 'telegram_id', null])
            ->andWhere(['!=', 'telegram_id', ''])
            ->all();

        $report = [
            'total_students_with_telegram' => count($siswaList),
            'issues' => [],
            'valid_chat_ids' => 0,
            'invalid_chat_ids' => 0,
            'recommendations' => []
        ];

        foreach ($siswaList as $siswa) {
            $chatId = $siswa->telegram_id;
            $studentName = $this->getSiswaName($siswa);

            if (!$this->validateTelegramChatId($chatId)) {
                $report['invalid_chat_ids']++;
                $report['issues'][] = [
                    'student' => $studentName,
                    'chat_id' => $chatId,
                    'kelas' => $siswa->kode_kelas ?? 'N/A',
                    'issue' => 'Format Chat ID tidak valid',
                    'recommendation' => 'Minta siswa berikan Chat ID yang benar dari @userinfobot'
                ];
            } else {
                $report['valid_chat_ids']++;
            }
        }

        if ($report['invalid_chat_ids'] > 0) {
            $report['recommendations'][] = "❌ Ada {$report['invalid_chat_ids']} siswa dengan Chat ID tidak valid";
            $report['recommendations'][] = "💡 Minta siswa mendapatkan Chat ID dari @userinfobot";
            $report['recommendations'][] = "📋 Gunakan fitur 'Test Telegram ID' sebelum menyimpan";
        }
        if ($report['valid_chat_ids'] > 0) {
            $report['recommendations'][] = "✅ {$report['valid_chat_ids']} siswa memiliki Chat ID dengan format valid";
        }

        return $report;
    }

    public function actionValidateAllTelegramIds()
    {
        if (!YII_ENV_DEV && !Yii::$app->user->can('admin')) {
            throw new NotFoundHttpException('Access denied');
        }

        set_time_limit(300);
        Yii::$app->response->format = Response::FORMAT_JSON;

        $siswaList = \app\models\Siswa::find()
            ->where(['IS NOT', 'telegram_id', null])
            ->andWhere(['!=', 'telegram_id', ''])
            ->limit(20)
            ->all();

        $results = [];
        $validCount = 0;
        $invalidCount = 0;

        foreach ($siswaList as $siswa) {
            $chatId = trim((string)$siswa->telegram_id);
            $studentName = $this->getSiswaName($siswa);

            $testMessage = "✅ Test koneksi bot - " . date('H:i:s') . "\nChat ID Anda masih aktif dan valid.";
            $result = $this->sendTelegramNotification($chatId, $testMessage);

            $statusOk = $result['success'] ?? false;
            $results[] = [
                'student' => $studentName,
                'chat_id' => $chatId,
                'kelas' => $siswa->kode_kelas ?? 'N/A',
                'status' => $statusOk ? 'VALID' : 'INVALID',
                'status_icon' => $statusOk ? '✅' : '❌',
                'error' => $statusOk ? null : ($result['error'] ?? null)
            ];

            if ($statusOk) $validCount++;
            else $invalidCount++;

            usleep(500000);
        }

        $total = count($results);
        return [
            'total_tested' => $total,
            'valid_count' => $validCount,
            'invalid_count' => $invalidCount,
            'success_rate' => $total > 0 ? round(($validCount / $total) * 100, 2) : 0,
            'results' => $results,
            'summary' => [
                'message' => "Dari {$total} Chat ID: ✅ {$validCount} valid, ❌ {$invalidCount} bermasalah"
            ]
        ];
    }

    // ===== HELPER =====

    protected function checkInternetConnection()
    {
        $connected = @fsockopen("www.google.com", 80);
        if ($connected) {
            fclose($connected);
            return true;
        }
        return false;
    }

    protected function getSiswaName($siswa)
    {
        $possibleFields = ['nama_lengkap', 'nama_siswa', 'nama', 'name', 'full_name', 'student_name'];
        foreach ($possibleFields as $field) {
            try {
                if (isset($siswa->$field) && !empty($siswa->$field)) {
                    return $siswa->$field;
                }
            } catch (Exception $e) {
                continue;
            }
        }
        $attributes = $siswa->attributes ?? [];
        foreach ($attributes as $key => $value) {
            if (stripos($key, 'nama') !== false && !empty($value)) {
                return $value;
            }
        }
        $primaryKey = method_exists($siswa, 'getPrimaryKey') ? $siswa->getPrimaryKey() : null;
        return "Siswa " . (is_array($primaryKey) ? implode('-', $primaryKey) : ($primaryKey ?? 'Tanpa ID'));
    }

    protected function getSiswaByKelas($model)
    {
        if (!$model->kode_kelas) {
            return [];
        }

        return \app\models\Siswa::find()
            ->where(['kode_kelas' => $model->kode_kelas])
            ->andWhere(['IS NOT', 'telegram_id', null])
            ->andWhere(['!=', 'telegram_id', ''])
            ->all();
    }

    protected function formatTelegramMessage($model)
    {
        if (method_exists($model, 'getFormattedForTelegram')) {
            return $model->getFormattedForTelegram();
        }

        $kelas = $model->kodeKelas ? $model->kodeKelas->kode_kelas : 'Umum';
        $judul = strlen($model->judul_pengumuman) > 100 ?
            substr($model->judul_pengumuman, 0, 97) . '...' :
            $model->judul_pengumuman;

        $isi = strlen($model->isi_pengumuman) > 1000 ?
            substr($model->isi_pengumuman, 0, 997) . '...' :
            $model->isi_pengumuman;

        $tgl = $model->tanggal_pengumuman ? date('d/m/Y H:i', strtotime($model->tanggal_pengumuman)) : date('d/m/Y H:i');

        $text = "🔔 <b>PENGUMUMAN KELAS</b> 🔔\n\n" .
            "📚 <b>Kelas:</b> {$kelas}\n" .
            "📌 <b>Judul:</b> {$judul}\n\n" .
            "📝 <b>Isi Pengumuman:</b>\n{$isi}\n\n" .
            "📅 <b>Tanggal:</b> {$tgl}\n\n" .
            "━━━━━━━━━━━━━━━━━━━━━━\n" .
            "📱 <i>Pesan otomatis dari Sistem Akademik</i>";

        return $this->sanitizeTelegramMessage($text);
    }

    protected function validateTelegramChatId($chat_id)
    {
        $chat_id = trim((string)$chat_id);
        if ($chat_id === '') return false;
        if (!preg_match('/^-?\d+$/', $chat_id)) {
            Yii::warning("Invalid chat_id format: {$chat_id}");
            return false;
        }
        // length check (allow supergroup -100xxxxxxxxxx)
        $len = strlen(ltrim($chat_id, '-'));
        if ($len < 5 || $len > 15) {
            Yii::warning("Invalid chat_id length: {$chat_id}");
            return false;
        }
        return true;
    }

    protected function sanitizeTelegramMessage($message)
    {
        // izinkan subset tag HTML yang didukung Telegram
        $allowed = '<b><strong><i><em><u><ins><s><strike><del><a><code><pre>';
        $message = strip_tags($message, $allowed);

        // batasi panjang (limit Telegram 4096)
        if (mb_strlen($message) > 4000) {
            $message = mb_substr($message, 0, 3900) . "\n...\n[Pesan dipotong karena terlalu panjang]";
        }

        return $message;
    }

    protected function sendTelegramNotification($chat_id, $message)
    {
        $token = Yii::$app->params['telegramBotToken'] ?? "8294291566:AAEfUbKCJs__-7f9u5Tx5E5Sa7M-0dJadus";

        if (empty($chat_id) || empty($message)) {
            return ['success' => false, 'error' => 'Chat ID atau pesan kosong'];
        }

        if (!$this->validateTelegramChatId($chat_id)) {
            return ['success' => false, 'error' => "Chat ID tidak valid: {$chat_id}"];
        }

        $url = "https://api.telegram.org/bot{$token}/sendMessage";
        $data = [
            'chat_id' => $chat_id,
            'text' => $message,
            'parse_mode' => 'HTML',
            'disable_web_page_preview' => true
        ];

        $postData = http_build_query($data);

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CONNECTTIMEOUT => 15,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_USERAGENT => 'TelegramBot/1.0',
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/x-www-form-urlencoded',
                'Accept: application/json'
            ],
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 3
        ]);

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlErr = curl_error($ch);
        curl_close($ch);

        if ($curlErr) {
            Yii::error("Telegram CURL Error for {$chat_id}: {$curlErr}");
            return ['success' => false, 'error' => "Koneksi error: {$curlErr}"];
        }

        if ($httpCode !== 200) {
            $response = json_decode($result, true);
            $desc = $response['description'] ?? 'Server tidak merespons';
            Yii::error("Telegram HTTP {$httpCode} for {$chat_id}: {$desc}");
            return ['success' => false, 'error' => "HTTP {$httpCode}: {$desc}"];
        }

        $response = json_decode($result, true);
        if (!$response || !isset($response['ok'])) {
            return ['success' => false, 'error' => 'Response tidak valid dari Telegram API'];
        }

        if (!$response['ok']) {
            $errorDesc = $response['description'] ?? 'Unknown error';
            Yii::error("Telegram API Error for {$chat_id}: {$errorDesc}");

            $descLow = strtolower($errorDesc);
            if (strpos($descLow, 'chat not found') !== false) {
                return ['success' => false, 'error' => 'Chat not found'];
            } elseif (strpos($descLow, 'blocked') !== false || strpos($descLow, 'forbidden') !== false) {
                return ['success' => false, 'error' => 'Bot diblokir oleh user'];
            } elseif (strpos($descLow, 'bad request') !== false) {
                return ['success' => false, 'error' => 'Bad Request'];
            } elseif (strpos($descLow, 'too many requests') !== false) {
                return ['success' => false, 'error' => 'Too Many Requests'];
            } elseif (strpos($descLow, 'message is too long') !== false) {
                return ['success' => false, 'error' => 'Pesan terlalu panjang'];
            } else {
                return ['success' => false, 'error' => $errorDesc];
            }
        }

        return [
            'success' => true,
            'error' => '',
            'message_id' => $response['result']['message_id'] ?? null
        ];
    }

    protected function buildBotStartLink(): string
    {
        // set di params.php: 'telegramBotUsername' => 'NamaBotAnda'
        $username = Yii::$app->params['telegramBotUsername'] ?? '';
        if (!$username) return '';
        // Bisa tambahkan startparameter jika mau, ex: ?start=kelas_{kode}
        return "https://t.me/{$username}";
    }

    protected function findModel($id)
    {
        if (($model = Historykelas::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Halaman yang diminta tidak ditemukan.');
    }
}
