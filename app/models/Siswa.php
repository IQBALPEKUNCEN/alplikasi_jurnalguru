<?php

namespace app\models;

use Yii;
use \app\models\base\Siswa as BaseSiswa;

/**
 * This is the model class for table "siswa".
 */
class Siswa extends BaseSiswa
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['nis'], 'required'],
            [['tanggal_lahir'], 'safe'],
            [['nis', 'kode_kelas', 'no_hp'], 'string', 'max' => 20],
            [['nama', 'tempat_lahir', 'alamat'], 'string', 'max' => 255],
            [['kode_jk'], 'string', 'max' => 1],


            // [['lock'], 'default', 'value' => '0'],
            // [['lock'], 'mootensai\components\OptimisticLockValidator']

        ]);
    }

    public function getKodeKelas()
    {
        return $this->hasOne(Kelas::class, ['kode_kelas' => 'kode_kelas']);
    }
    

    public function getJurnalDetils()
    {
        return $this->hasMany(\app\models\JurnalDetil::class, ['nis' => 'nis']);
    }

    public function getHistorykelas()
    {
        return $this->hasMany(\app\models\Historykelas::class, ['nis' => 'nis']);
    }


    public function getKelas()
    {
        return $this->hasOne(Kelas::class, ['kode_kelas' => 'kode_kelas']);
    }

    public function getJurusan()
    {
        return $this->hasOne(Jurusan::class, ['kode_jurusan' => 'kode_jurusan']);
    }
    
}
