<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * RECOMMENDED MODEL STRUCTURE
 * 
 * This is the recommended model class for table "pengumpulan_tugas".
 * 
 * Recommended table structure:
 * - id (int, PK, auto_increment)
 * - tugas_id (int, FK to tugas.id)
 * - nis (varchar(20), FK to siswa.nis)  <-- Change nama_siswa to nis
 * - file_tugas (varchar(255), nullable)
 * - keterangan (text, nullable)
 * - tanggal_kumpul (datetime, nullable)
 *
 * @property int $id
 * @property int $tugas_id
 * @property string $nis
 * @property string|null $file_tugas
 * @property string|null $keterangan
 * @property string|null $tanggal_kumpul
 *
 * @property Tugas $tugas
 * @property Siswa $siswa
 */
class PengumpulanTugas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pengumpulan_tugas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tugas_id', 'nis'], 'required'],
            [['tugas_id'], 'integer'],
            [['keterangan'], 'string'],
            [['tanggal_kumpul'], 'safe'],
            [['nis'], 'string', 'max' => 20],
            [['file_tugas'], 'string', 'max' => 255],
            // Validasi untuk upload file
            [
                ['file_tugas'],
                'file',
                'skipOnEmpty' => true,
                'extensions' => 'pdf, doc, docx, txt, jpg, png, zip, rar',
                'maxSize' => 1024 * 1024 * 10, // 10MB
                'tooBig' => 'File terlalu besar. Maksimal 10MB.'
            ],
            [['tugas_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tugas::class, 'targetAttribute' => ['tugas_id' => 'id']],
            [['nis'], 'exist', 'skipOnError' => true, 'targetClass' => Siswa::class, 'targetAttribute' => ['nis' => 'nis']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tugas_id' => 'Judul Tugas',
            'nis' => 'Siswa',
            'file_tugas' => 'File Tugas',
            'keterangan' => 'Keterangan',
            'tanggal_kumpul' => 'Tanggal Kumpul',
        ];
    }

    /**
     * Gets query for [[Tugas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTugas()
    {
        return $this->hasOne(Tugas::class, ['id' => 'tugas_id']);
    }

    /**
     * Gets query for [[Siswa]].
     * Proper foreign key relationship
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNis0()
    {
        return $this->hasOne(\app\models\Siswa::class, ['nis' => 'nis']);
    }

    public function getJurusan()
    {
        return $this->hasOne(Jurusan::class, ['jurusan_id' => 'kode_jurusan']);
    }

    /**
     * Get kelas siswa melalui relasi
     */
    public function getKelasSiswa()
    {
        return $this->siswa && $this->siswa->kelas ? $this->siswa->kelas->kode_kelas : null;
    }

    public function getSiswa()
    {
        return $this->hasOne(Siswa::class, ['nis' => 'nis']);
    }

    public function getKelas()
    {
        return $this->hasOne(\app\models\base\Kelas::class, ['kode_kelas' => 'kode_kelas']);
    }

    public function getMapel()
    {
        return $this->hasOne(Mapel::class, ['kode_mapel' => 'kode_mapel']); // sesuaikan kolomnya
    }

    /**
     * Get file URL for download/display
     */
    public function getFileUrl()
    {
        if ($this->file_tugas) {
            return Yii::getAlias('@web/uploads/tugas/') . $this->file_tugas;
        }
        return null;
    }

    /**
     * Get file path for server operations
     */
    public function getFilePath()
    {
        if ($this->file_tugas) {
            return Yii::getAlias('@webroot/uploads/tugas/') . $this->file_tugas;
        }
        return null;
    }

    
    /**
     * Check if file exists
     */
    public function hasFile()
    {
        return $this->file_tugas && file_exists($this->getFilePath());
    }

    /**
     * Get formatted submission info
     */
    public function getSubmissionInfo()
    {
        if ($this->siswa) {
            $info = $this->siswa->nis . ' - ' . $this->siswa->nama;
            if ($this->siswa->kelas) {
                $info .= ' (' . $this->siswa->kelas->nama_kelas . ')';
            }
            return $info;
        }
        return $this->nis;
    }

    public function beforeSave($insert)
{
    if (parent::beforeSave($insert)) {
        if ($this->isNewRecord && empty($this->tanggal_kumpul)) {
            $this->tanggal_kumpul = date('Y-m-d H:i:s');
        }
        return true;
    }
    return false;
}

}
