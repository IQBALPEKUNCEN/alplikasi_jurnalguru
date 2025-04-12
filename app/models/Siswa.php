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
<<<<<<< HEAD
=======
            [['lock'], 'default', 'value' => '0'],
            [['lock'], 'mootensai\components\OptimisticLockValidator']
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
        ]);
    }
	
}
