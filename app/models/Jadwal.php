<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "jadwal".
 *
 * @property int $id
 * @property string $hari
 * @property string $jam_mulai
 * @property string $jam_selesai
 * @property string $guru_id
 * @property string $kode_kelas
 * @property string $kode_mapel
 * @property string $kode_jurusan
 * @property int|null $ruangan_id
 *
 * @property Guru $guru
 * @property Jurusan $kodeJurusan
 * @property Kelas $kodeKelas
 * @property Mapel $kodeMapel
 * @property Ruangan $ruangan
 */
class Jadwal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jadwal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['hari', 'jam_mulai', 'jam_selesai', 'guru_id', 'kode_kelas', 'kode_mapel', 'kode_jurusan'], 'required'],
            [['jam_mulai', 'jam_selesai'], 'safe'],
            [['ruangan_id'], 'integer'],
            [['hari'], 'string'],
            [['guru_id'], 'string', 'max' => 32],
            [['kode_kelas', 'kode_mapel', 'kode_jurusan'], 'string', 'max' => 20],
            [['guru_id'], 'exist', 'skipOnError' => true, 'targetClass' => Guru::class, 'targetAttribute' => ['guru_id' => 'guru_id']],
            [['kode_kelas'], 'exist', 'skipOnError' => true, 'targetClass' => Kelas::class, 'targetAttribute' => ['kode_kelas' => 'kode_kelas']],
            [['kode_mapel'], 'exist', 'skipOnError' => true, 'targetClass' => Mapel::class, 'targetAttribute' => ['kode_mapel' => 'kode_mapel']],
            [['kode_jurusan'], 'exist', 'skipOnError' => true, 'targetClass' => Jurusan::class, 'targetAttribute' => ['kode_jurusan' => 'kode_jurusan']],
            [['ruangan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ruangan::class, 'targetAttribute' => ['ruangan_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hari' => 'Hari',
            'jam_mulai' => 'Jam Mulai',
            'jam_selesai' => 'Jam Selesai',
            'guru_id' => 'Guru',
            'kode_kelas' => 'Kelas',
            'kode_mapel' => 'Mata Pelajaran',
            'kode_jurusan' => 'Jurusan',
            'ruangan_id' => 'Ruangan',
        ];
    }

    /**
     * Gets query for [[Guru]].
     */
    public function getGuru()
    {
        return $this->hasOne(Guru::class, ['guru_id' => 'guru_id']);
    }

    /**
     * Gets query for [[KodeJurusan]].
     */
    public function getKodeJurusan()
    {
        return $this->hasOne(Jurusan::class, ['kode_jurusan' => 'kode_jurusan']);
    }

    /**
     * Gets query for [[KodeKelas]].
     */
    public function getKodeKelas()
    {
        return $this->hasOne(Kelas::class, ['kode_kelas' => 'kode_kelas']);
    }

    /**
     * Gets query for [[KodeMapel]].
     */
    public function getKodeMapel()
    {
        return $this->hasOne(Mapel::class, ['kode_mapel' => 'kode_mapel']);
    }

    /**
     * Gets query for [[Ruangan]].
     */
    public function getRuangan()
    {
        return $this->hasOne(Ruangan::class, ['id' => 'ruangan_id']);
    }

    public function getRuanganNama()
    {
        return $this->ruangan ? $this->ruangan->nama : null;
    }

    /**
     * Helper method to get ruangan name
     */
    // public function getRuanganNama()
    // {
    //     return $this->ruangan ? $this->ruangan->nama : '-';
    // }

    /**
     * Helper method to get guru name
     */
    public function getGuruNama()
    {
        return $this->guru ? $this->guru->nama : '-';
    }

    /**
     * Helper method to get mapel name
     */
    public function getMapelNama()
    {
        return $this->kodeMapel ? $this->kodeMapel->nama : '-';
    }

    /**
     * Helper method to get formatted jam
     */
    public function getJamFormatted()
    {
        return date('H:i', strtotime($this->jam_mulai)) . ' - ' . date('H:i', strtotime($this->jam_selesai));
    }
}
