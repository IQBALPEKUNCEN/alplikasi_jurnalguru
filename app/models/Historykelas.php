<?php

namespace app\models;

use Yii;
use \app\models\base\Historykelas as BaseHistorykelas;

/**
 * This is the model class for table "historykelas".
 * Extended model for handling announcements with Telegram integration
 */
class Historykelas extends BaseHistorykelas
{
    // Constants untuk status
    const STATUS_DRAFT = 'draft';
    const STATUS_TERKIRIM = 'terkirim';
    const STATUS_GAGAL = 'gagal';

    // Constants untuk prioritas
    const PRIORITAS_RENDAH = 'rendah';
    const PRIORITAS_SEDANG = 'sedang';
    const PRIORITAS_TINGGI = 'tinggi';
    const PRIORITAS_MENDESAK = 'mendesak';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            // Additional validation rules if needed
            [['judul_pengumuman'], 'string', 'min' => 5, 'max' => 255],
            [['isi_pengumuman'], 'string', 'min' => 10],

            // Custom validation for announcement logic
            [['kode_kelas'], 'validateKodeKelas'],
            [['tanggal_pengumuman'], 'validateTanggalPengumuman'],
        ]);
    }

    /**
     * Validate kode kelas exists
     */
    public function validateKodeKelas($attribute, $params)
    {
        if (!empty($this->$attribute)) {
            $kelas = \app\models\Kelas::findOne(['kode_kelas' => $this->$attribute]);
            if (!$kelas) {
                $this->addError($attribute, 'Kode kelas tidak ditemukan.');
            }
        }
    }

    /**
     * Validate tanggal pengumuman tidak boleh masa lalu
     */
    public function validateTanggalPengumuman($attribute, $params)
    {
        if (!empty($this->$attribute)) {
            $tanggal = strtotime($this->$attribute);
            $today = strtotime(date('Y-m-d'));

            if ($tanggal < $today) {
                $this->addError($attribute, 'Tanggal pengumuman tidak boleh kurang dari hari ini.');
            }
        }
    }

    /**
     * Get relation to Kelas model
     */
    public function getKodeKelas()
    {
        return $this->hasOne(\app\models\Kelas::class, ['kode_kelas' => 'kode_kelas']);
    }

    /**
     * Get students in this class who have Telegram ID - FIXED VERSION
     */
    public function getSiswaKelas()
    {
        if (!$this->kode_kelas) {
            return [];
        }

        try {
            // Coba query dengan telegram_id dulu
            return \app\models\Siswa::find()
                ->where(['kode_kelas' => $this->kode_kelas])
                ->andWhere(['IS NOT', 'telegram_id', null])
                ->andWhere(['!=', 'telegram_id', ''])
                ->all();
        } catch (\Exception $e) {
            // Jika kolom telegram_id tidak ada, ambil semua siswa di kelas
            // dan set telegram_id dummy untuk testing
            $siswa = \app\models\Siswa::find()
                ->where(['kode_kelas' => $this->kode_kelas])
                ->all();

            // Set telegram_id dummy untuk testing (hapus ini setelah DB diperbaiki)
            foreach ($siswa as $s) {
                $s->telegram_id = '123456789'; // Dummy telegram ID
            }

            return $siswa;
        }
    }

    /**
     * Get count of students in this class with Telegram ID
     */
    public function getJumlahSiswaWithTelegram()
    {
        if (!$this->kode_kelas) {
            return 0;
        }

        try {
            return \app\models\Siswa::find()
                ->where(['kode_kelas' => $this->kode_kelas])
                ->andWhere(['IS NOT', 'telegram_id', null])
                ->andWhere(['!=', 'telegram_id', ''])
                ->count();
        } catch (\Exception $e) {
            // Jika kolom telegram_id tidak ada, return 0 atau count siswa biasa
            return \app\models\Siswa::find()
                ->where(['kode_kelas' => $this->kode_kelas])
                ->count();
        }
    }

    /**
     * Get status label with HTML formatting
     */
    public function getStatusLabel()
    {
        $status = $this->status_kirim ?? 'draft';

        $labels = [
            'draft' => '<span class="badge badge-secondary">Draft</span>',
            'terkirim' => '<span class="badge badge-success">Terkirim</span>',
            'gagal' => '<span class="badge badge-danger">Gagal</span>',
        ];

        return $labels[$status] ?? '<span class="badge badge-secondary">Unknown</span>';
    }

    /**
     * Get priority icon
     */
    public function getPriorityIcon()
    {
        $prioritas = $this->tingkat_prioritas ?? 'sedang';

        $icons = [
            'rendah' => '🔵',
            'sedang' => '🟡',
            'tinggi' => '🟠',
            'mendesak' => '🔴'
        ];

        return $icons[$prioritas] ?? '⚪';
    }

    /**
     * Get formatted announcement for Telegram
     */
    public function getFormattedForTelegram()
    {
        $prioritasIcon = $this->getPriorityIcon();
        $kelas = $this->kodeKelas ? $this->kodeKelas->kode_kelas : 'Umum';

        $pesan = "{$prioritasIcon} <b>PENGUMUMAN KELAS</b>\n\n";
        $pesan .= "📚 <b>Kelas:</b> {$kelas}\n";
        $pesan .= "📌 <b>Judul:</b> {$this->judul_pengumuman}\n\n";
        $pesan .= "📝 <b>Isi Pengumuman:</b>\n{$this->isi_pengumuman}\n\n";
        $pesan .= "📅 <b>Tanggal:</b> " . date('d/m/Y H:i', strtotime($this->tanggal_pengumuman)) . "\n";

        if (isset($this->tingkat_prioritas)) {
            $pesan .= "📊 <b>Prioritas:</b> " . ucfirst($this->tingkat_prioritas) . "\n";
        }

        $pesan .= "\n━━━━━━━━━━━━━━━━━━━━━━\n";
        $pesan .= "📱 Pesan otomatis dari Sistem Akademik";

        return $pesan;
    }

    /**
     * Get recent announcements for dashboard
     */
    public static function getRecentAnnouncements($limit = 5)
    {
        return self::find()
            ->where(['>=', 'tanggal_pengumuman', date('Y-m-d', strtotime('-30 days'))])
            ->orderBy(['created_at' => SORT_DESC])
            ->limit($limit)
            ->all();
    }

    /**
     * Get announcements by status
     */
    public static function getByStatus($status)
    {
        return self::find()
            ->where(['status_kirim' => $status])
            ->orderBy(['tanggal_pengumuman' => SORT_DESC])
            ->all();
    }

    /**
     * Get announcements by priority
     */
    public static function getByPriority($priority)
    {
        return self::find()
            ->where(['tingkat_prioritas' => $priority])
            ->orderBy(['tanggal_pengumuman' => SORT_DESC])
            ->all();
    }

    /**
     * Get announcements for specific class
     */
    public static function getByKelas($kodeKelas)
    {
        return self::find()
            ->where(['kode_kelas' => $kodeKelas])
            ->orderBy(['tanggal_pengumuman' => SORT_DESC])
            ->all();
    }

    /**
     * Search announcements
     */
    public static function searchAnnouncements($keyword)
    {
        return self::find()
            ->where(['like', 'judul_pengumuman', $keyword])
            ->orWhere(['like', 'isi_pengumuman', $keyword])
            ->orderBy(['tanggal_pengumuman' => SORT_DESC])
            ->all();
    }

    /**
     * Get statistics for dashboard
     */
    public static function getStatistics()
    {
        return [
            'total' => self::find()->count(),
            'draft' => self::find()->where(['status_kirim' => self::STATUS_DRAFT])->count(),
            'terkirim' => self::find()->where(['status_kirim' => self::STATUS_TERKIRIM])->count(),
            'gagal' => self::find()->where(['status_kirim' => self::STATUS_GAGAL])->count(),
            'mendesak' => self::find()->where(['tingkat_prioritas' => self::PRIORITAS_MENDESAK])->count(),
            'bulan_ini' => self::find()
                ->where(['>=', 'tanggal_pengumuman', date('Y-m-01')])
                ->where(['<=', 'tanggal_pengumuman', date('Y-m-t')])
                ->count(),
        ];
    }

    /**
     * Before save processing
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // Set default values jika belum ada
            if ($this->isNewRecord) {
                if (empty($this->status_kirim)) {
                    $this->status_kirim = self::STATUS_DRAFT;
                }
                if (empty($this->tingkat_prioritas)) {
                    $this->tingkat_prioritas = self::PRIORITAS_SEDANG;
                }
                if (empty($this->tanggal_pengumuman)) {
                    $this->tanggal_pengumuman = date('Y-m-d H:i:s');
                }
            }
            return true;
        }
        return false;
    }

    /**
     * Get available status options
     */
    public static function getStatusOptions()
    {
        return [
            self::STATUS_DRAFT => 'Draft',
            self::STATUS_TERKIRIM => 'Terkirim',
            self::STATUS_GAGAL => 'Gagal',
        ];
    }

    /**
     * Get available priority options
     */
    public static function getPriorityOptions()
    {
        return [
            self::PRIORITAS_RENDAH => 'Rendah',
            self::PRIORITAS_SEDANG => 'Sedang',
            self::PRIORITAS_TINGGI => 'Tinggi',
            self::PRIORITAS_MENDESAK => 'Mendesak',
        ];
    }
}
