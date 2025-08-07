<?php

namespace app\models;

use Yii;
use \app\models\base\JurnalDetil as BaseJurnalDetil;

/**
 * This is the model class for table "jurnal_detil".
 */
class JurnalDetil extends BaseJurnalDetil
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(), [
            [['jurnal_id', 'nis', 'status'], 'required'],
            [['jurnal_id'], 'integer'],
            [['status'], 'string'],
            [['waktu_presensi'], 'safe'],
            [['nis'], 'string', 'max' => 20],
            [['nama'], 'string', 'max' => 255],
            [['status'], 'in', 'range' => ['HADIR', 'IZIN', 'SAKIT', 'ALPA']],
        ]);
    }

    /**
     * Relasi ke jurnal
     */
    public function getJurnal()
    {
        return $this->hasOne(Jurnal::class, ['jurnal_id' => 'jurnal_id']);
    }

    /**
     * Relasi ke siswa (via NIS)
     */
    public function getSiswa()
    {
        return $this->hasOne(Siswa::class, ['nis' => 'nis']);
    }

    /**
     * Relasi ke kelas (via siswa)
     */
    public function getKelas()
    {
        return $this->hasOne(Kelas::class, ['kode_kelas' => 'kode_kelas'])->via('siswa');
    }

    /**
     * Relasi ke jurusan (via siswa)
     */
    public function getJurusan()
    {
        return $this->hasOne(Jurusan::class, ['kode_jurusan' => 'kode_jurusan'])->via('siswa');
    }

    /**
     * Ambil nama siswa dengan fallback
     */
    public function getSiswaNama()
    {
        return $this->siswa ? $this->siswa->nama : ($this->nama ?: 'Nama tidak tersedia');
    }

    /**
     * Nama kelas dari relasi
     */
    public function getKelasNama()
    {
        return $this->kelas ? $this->kelas->nama_kelas : 'Kelas tidak tersedia';
    }

    /**
     * Nama jurusan dari relasi
     */
    public function getJurusanNama()
    {
        return $this->jurusan ? $this->jurusan->nama_jurusan : 'Jurusan tidak tersedia';
    }

    /**
     * Digunakan oleh Gii dan dynamic form
     */
    public function relationNames()
    {
        return [
            'jurnal',
            'siswa',
            'kelas',
            'jurusan',
        ];
    }
}
