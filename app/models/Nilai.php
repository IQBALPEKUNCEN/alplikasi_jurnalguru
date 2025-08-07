<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "nilai".
 *
 * @property int $id
 * @property string $nis
 * @property string $kode_mapel
 * @property float $nilai_angka
 * @property string|null $semester
 * @property string|null $tahun_ajaran
 *
 * @property Siswa $siswa
 * @property Mapel $mapel
 * @property Tahunajaran $tahunAjaran
 */
class Nilai extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'nilai';
    }

    public function rules()
    {
        return [
            [['nis', 'kode_mapel', 'nilai_angka'], 'required'],
            [['nilai_angka'], 'integer', 'min' => 0, 'max' => 100],
            [['nis'], 'string', 'max' => 20],
            [['kode_mapel', 'semester', 'tahun_ajaran'], 'string', 'max' => 20],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nis' => 'NIS',
            'kode_mapel' => 'Kode Mapel',
            'nilai_angka' => 'Nilai Angka',
            'semester' => 'Semester',
            'tahun_ajaran' => 'Tahun Ajaran',
        ];
    }

    public function getSiswa()
    {
        return $this->hasOne(Siswa::class, ['nis' => 'nis']);
    }

    public function getMapel()
    {
        return $this->hasOne(Mapel::class, ['kode_mapel' => 'kode_mapel']);
    }

    public function getTahunAjaran()
    {
        return $this->hasOne(Tahunajaran::class, ['kodeta' => 'tahun_ajaran']);
    }
}
