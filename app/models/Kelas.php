<?php

namespace app\models;

use Yii;
use \app\models\base\Kelas as BaseKelas;

/**
 * This is the model class for table "kelas".
 */
class Kelas extends BaseKelas
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['kode_kelas'], 'required'],
            [['kode_kelas', 'kode_jenjang', 'kode_jurusan', 'nama'], 'string', 'max' => 20],
<<<<<<< HEAD
=======
            [['lock'], 'default', 'value' => '0'],
            [['lock'], 'mootensai\components\OptimisticLockValidator']
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
        ]);
    }
	
}
