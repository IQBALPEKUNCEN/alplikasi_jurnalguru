<?php

namespace app\models;

use yii\db\ActiveRecord;
use app\models\JurnalDetil;

/**
 * Class Tahunajaran
 *
 * @property string $kodeta
 * @property string $nama
 * @property string $semester
 * @property string $kode_jurusan
 * @property bool $isaktif
 */
class Tahunajaran extends ActiveRecord
{
    /**
     * Nama tabel di database
     */
    public static function tableName()
    {
        return 'tahunajaran'; // sesuaikan dengan nama tabel sebenarnya
    }

    /**
     * Rules validasi atribut
     */
    public function rules()
    {
        return [
            // FIXED: Tambahkan kode_jurusan ke required fields
            [['kodeta', 'nama', 'semester', 'kode_jurusan'], 'required'],

            [['kodeta', 'nama'], 'string', 'max' => 36],
            ['semester', 'in', 'range' => ['GASAL', 'GENAP']],
            ['isaktif', 'boolean'],

            // FIXED: Ubah dari 'string' ke 'string' dengan max length
            [['kode_jurusan'], 'string', 'max' => 20],

            // FIXED: Tambahkan validasi exist untuk foreign key
            [
                ['kode_jurusan'],
                'exist',
                'targetClass' => 'app\models\Jurusan', // Sesuaikan namespace
                'targetAttribute' => 'kode_jurusan',
                'message' => 'Jurusan yang dipilih tidak valid'
            ],
        ];
    }

    /**
     * Label untuk tiap atribut
     */
    public function attributeLabels()
    {
        return [
            'kodeta' => 'Kode Tahun Ajaran',
            'nama' => 'Nama Tahun Ajaran',
            'semester' => 'Semester',
            'isaktif' => 'Status Aktif',
            'kode_jurusan' => 'Jurusan', // FIXED: Konsisten dengan Model Jurnal
        ];
    }

    /**
     * FIXED: Tambahkan relasi ke Jurusan
     */
    public function getJurusan()
    {
        return $this->hasOne('app\models\Jurusan', ['kode_jurusan' => 'kode_jurusan']);
    }

    /**
     * Override beforeSave untuk memastikan hanya satu tahun ajaran aktif
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // Jika tahun ajaran ini diset aktif, nonaktifkan yang lain
            if ($this->isaktif) {
                static::updateAll(['isaktif' => false], ['!=', 'kodeta', $this->kodeta]);
            }
            return true;
        }
        return false;
    }

    public function getJurnalDetils()
    {
        return $this->hasMany(\app\models\base\JurnalDetil::class, ['jurnal_id' => 'jurnal_id']);
    }


    public function getGuru()
    {
        return $this->hasOne('app\models\Guru', ['guru_id' => 'guru_id']);
    }

    public function getHari()
    {
        return $this->hasOne('app\models\Hari', ['hari_id' => 'hari_id']);
    }

    public function getKodeKelas()
    {
        return $this->hasOne('app\models\Kelas', ['kode_kelas' => 'kode_kelas']);
    }

    public function getKodeMapel()
    {
        return $this->hasOne('app\models\Mapel', ['kode_mapel' => 'kode_mapel']);
    }

    public function getNilai()
    {
        return $this->hasMany(Nilai::class, ['tahun_ajaran' => 'kodeta']);
    }
}
