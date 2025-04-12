<?php

namespace app\models;

use Yii;
use \app\models\base\Jeniskelamin as BaseJeniskelamin;

/**
 * This is the model class for table "jeniskelamin".
 */
class Jeniskelamin extends BaseJeniskelamin
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['kode_jk'], 'required'],
            [['kode_jk'], 'string', 'max' => 1],
            [['nama'], 'string', 'max' => 20],
<<<<<<< HEAD
=======
            [['lock'], 'default', 'value' => '0'],
            [['lock'], 'mootensai\components\OptimisticLockValidator']
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
        ]);
    }
	
}
