<?php

// File: app/models/base/Historykelas.php
namespace app\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the base model class for table "historykelas".
 *
 * @property integer $history_id
 * @property string $nis
 * @property string $kodeta
 * @property string $kode_kelas
 * @property string $tanggal_pengumuman
 * @property string $status_kirim
 * @property string $judul_pengumuman
 * @property string $isi_pengumuman
 * @property string $tingkat_prioritas
 * @property string $tanggal_kirim
 * @property string $created_at
 * @property string $updated_at
 *
 * @property \app\models\Kelas $kodeKelas
 * @property \app\models\Siswa $nis0
 * @property \app\models\Tahunajaran $kodeta0
 */
class Historykelas extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    // Status kirim constants
    const STATUS_DRAFT = 'draft';
    const STATUS_TERKIRIM = 'terkirim';
    const STATUS_GAGAL = 'gagal';

    // Tingkat prioritas constants
    const PRIORITAS_RENDAH = 'rendah';
    const PRIORITAS_SEDANG = 'sedang';
    const PRIORITAS_TINGGI = 'tinggi';
    const PRIORITAS_MENDESAK = 'mendesak';

    /**
     * Nama tabel
     */
    public static function tableName()
    {
        return 'historykelas';
    }

    /**
     * Behaviors untuk timestamp.
     * Mengisi `created_at` dan `updated_at` secara otomatis.
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * Rules validasi dasar
     */
    public function rules()
    {
        return [
            // Required fields
            [['judul_pengumuman', 'isi_pengumuman', 'kode_kelas'], 'required'],

            // String lengths
            [['nis', 'kodeta', 'kode_kelas'], 'string', 'max' => 20],
            [['judul_pengumuman'], 'string', 'max' => 255],
            [['isi_pengumuman'], 'string'],
            [['status_kirim', 'tingkat_prioritas'], 'string', 'max' => 50],

            // Date fields - created_at and updated_at are safe for mass assignment
            [['tanggal_pengumuman', 'tanggal_kirim', 'created_at', 'updated_at'], 'safe'],

            // Enum validations
            [['status_kirim'], 'in', 'range' => [self::STATUS_DRAFT, self::STATUS_TERKIRIM, self::STATUS_GAGAL]],
            [['tingkat_prioritas'], 'in', 'range' => [self::PRIORITAS_RENDAH, self::PRIORITAS_SEDANG, self::PRIORITAS_TINGGI, self::PRIORITAS_MENDESAK]],

            // Default values
            [['tanggal_pengumuman'], 'default', 'value' => date('Y-m-d')],
            [['status_kirim'], 'default', 'value' => self::STATUS_DRAFT],
            [['tingkat_prioritas'], 'default', 'value' => self::PRIORITAS_SEDANG],
        ];
    }

    /**
     * Nama relasi
     */
    public function relationNames()
    {
        return [
            'kodeKelas',
            'nis0',
            'kodeta0'
        ];
    }

    /**
     * Label atribut
     */
    public function attributeLabels()
    {
        return [
            'history_id' => 'ID Pengumuman',
            'nis' => 'NIS Siswa',
            'kodeta' => 'Kode Tahun Ajaran',
            'kode_kelas' => 'Kode Kelas',
            'tanggal_pengumuman' => 'Tanggal Pengumuman',
            'status_kirim' => 'Status Pengiriman',
            'judul_pengumuman' => 'Judul Pengumuman',
            'isi_pengumuman' => 'Isi Pengumuman',
            'tingkat_prioritas' => 'Tingkat Prioritas',
            'tanggal_kirim' => 'Tanggal Dikirim',
            'created_at' => 'Dibuat Pada',
            'updated_at' => 'Diupdate Pada',
        ];
    }

    /**
     * Relasi ke tabel Kelas
     */
    public function getKodeKelas()
    {
        return $this->hasOne(\app\models\Kelas::class, ['kode_kelas' => 'kode_kelas']);
    }

    /**
     * Relasi ke tabel Siswa
     */
    public function getNis0()
    {
        return $this->hasOne(\app\models\Siswa::class, ['nis' => 'nis']);
    }

    /**
     * Relasi ke tabel Tahunajaran
     */
    public function getKodeta0()
    {
        return $this->hasOne(\app\models\Tahunajaran::class, ['kodeta' => 'kodeta']);
    }

    /**
     * Get all siswa in the same class as this announcement
     */
    // Method ini bermasalah karena mencoba join yang tidak jelas
    public function getSiswaKelas()
    {
        return \app\models\Siswa::find()
            ->joinWith('historyKelas') // <- Ini bermasalah
            ->where(['historykelas.kode_kelas' => $this->kode_kelas])
            ->andWhere(['IS NOT', 'siswa.telegram_id', null])
            ->all();
    }

    /**
     * Get status options
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
     * Get prioritas options
     */
    public static function getPrioritasOptions()
    {
        return [
            self::PRIORITAS_RENDAH => 'Rendah',
            self::PRIORITAS_SEDANG => 'Sedang',
            self::PRIORITAS_TINGGI => 'Tinggi',
            self::PRIORITAS_MENDESAK => 'Mendesak',
        ];
    }

    /**
     * Get status label with color
     */
    public function getStatusLabel()
    {
        $labels = [
            self::STATUS_DRAFT => '<span class="label label-warning">Draft</span>',
            self::STATUS_TERKIRIM => '<span class="label label-success">Terkirim</span>',
            self::STATUS_GAGAL => '<span class="label label-danger">Gagal</span>',
        ];

        return isset($labels[$this->status_kirim]) ? $labels[$this->status_kirim] : $this->status_kirim;
    }

    /**
     * Get prioritas label with color
     */
    public function getPrioritasLabel()
    {
        $labels = [
            self::PRIORITAS_RENDAH => '<span class="label label-default">Rendah</span>',
            self::PRIORITAS_SEDANG => '<span class="label label-info">Sedang</span>',
            self::PRIORITAS_TINGGI => '<span class="label label-warning">Tinggi</span>',
            self::PRIORITAS_MENDESAK => '<span class="label label-danger">Mendesak</span>',
        ];

        return isset($labels[$this->tingkat_prioritas]) ? $labels[$this->tingkat_prioritas] : $this->tingkat_prioritas;
    }

    /**
     * Get priority icon
     */
    public function getPriorityIcon()
    {
        $icons = [
            self::PRIORITAS_RENDAH => '📋',
            self::PRIORITAS_SEDANG => '📢',
            self::PRIORITAS_TINGGI => '⚠️',
            self::PRIORITAS_MENDESAK => '🚨',
        ];

        return isset($icons[$this->tingkat_prioritas]) ? $icons[$this->tingkat_prioritas] : '📢';
    }

    /**
     * Check if announcement can be sent
     */
    public function canBeSent()
    {
        return $this->status_kirim === self::STATUS_DRAFT &&
            !empty($this->judul_pengumuman) &&
            !empty($this->isi_pengumuman) &&
            !empty($this->kode_kelas);
    }

    /**
     * Mark as sent
     */
    public function markAsSent()
    {
        $this->status_kirim = self::STATUS_TERKIRIM;
        $this->tanggal_kirim = date('Y-m-d H:i:s');
        return $this->save(false);
    }

    /**
     * Mark as failed
     */
    public function markAsFailed()
    {
        $this->status_kirim = self::STATUS_GAGAL;
        return $this->save(false);
    }

    /**
     * Custom query
     */
    public static function find()
    {
        return new \app\models\HistorykelasQuery(get_called_class());
    }
}
