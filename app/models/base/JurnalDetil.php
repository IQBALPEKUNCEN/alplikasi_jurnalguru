<?php

namespace app\models\base;

use Yii;
use yii\db\ActiveRecord;

class JurnalDetil extends ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    public static function tableName()
    {
        return 'jurnal_detil';
    }

    public static function primaryKey()
    {
        return ['detil_id'];
    }

    public function rules()
    {
        return [
            [['jurnal_id', 'status', 'nis',], 'required'],
            [['jurnal_id'], 'integer'],
            [['status'], 'string'],
            [['waktu_presensi'], 'safe'],
            [['nis'], 'string', 'max' => 20],
            [['nama'], 'string', 'max' => 255],
            [['status'], 'in', 'range' => ['HADIR', 'IZIN', 'SAKIT', 'ALPA']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'detil_id' => 'Detil ID',
            'jurnal_id' => 'Jurnal ID',
            'nis' => 'NIS',
            'nama' => 'Nama',
            'status' => 'Status',
            'waktu_presensi' => 'Waktu Presensi',
        ];
    }

    /**
     * Relasi ke model Jurnal
     * @return \yii\db\ActiveQuery
     */
    public function getJurnal()
    {
        return $this->hasOne(Jurnal::class, ['jurnal_id' => 'jurnal_id']);
    }



    /**
     * Relasi ke model Siswa menggunakan NIS
     * @return \yii\db\ActiveQuery
     */
    public function getSiswa()
    {
        return $this->hasOne(Siswa::class, ['nis' => 'nis']);
    }


    /**
     * Get nama siswa (safe access)
     * @return string
     */
    public function getSiswaNama()
    {
        return $this->siswa ? $this->siswa->nama : ($this->nama ?: 'Nama tidak tersedia');
    }

    /**
     * Get NIS siswa (safe access)
     * @return string
     */
    public function getNis0()
    {
        return $this->hasOne(Siswa::class, ['nis' => 'nis']);
    }


    /**
     * Relasi ke kelas melalui siswa
     * @return \yii\db\ActiveQuery
     */
    public function getKelas()
    {
        return $this->hasOne(\app\models\Kelas::class, ['kode_kelas' => 'kode_kelas'])
            ->via('siswa');
    }

    /**
     * Relasi ke jurusan melalui siswa
     * @return \yii\db\ActiveQuery
     */
    public function getJurusan()
    {
        return $this->hasOne(\app\models\Jurusan::class, ['kode_jurusan' => 'kode_jurusan'])
            ->via('siswa');
    }

    /**
     * Get nama kelas (safe access)
     * @return string
     */
    public function getKelasNama()
    {
        return $this->kelas ? $this->kelas->nama_kelas : 'Kelas tidak tersedia';
    }

    /**
     * Get nama jurusan (safe access)
     * @return string
     */
    public function getJurusanNama()
    {
        return $this->jurusan ? $this->jurusan->nama_jurusan : 'Jurusan tidak tersedia';
    }

    public function relationNames()
    {
        return [
            'jurnal',
            'siswa',
            'kelas',
            'jurusan',
        ];
    }

    public static function find()
    {
        return new \app\models\JurnalDetilQuery(get_called_class());
    }
}
