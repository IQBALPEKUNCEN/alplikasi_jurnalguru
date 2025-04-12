<?php

namespace app\models;

use Yii;
use \app\models\base\Jenjang as BaseJenjang;

/**
 * This is the model class for table "jenjang".
 */
class Jenjang extends BaseJenjang
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['kode_jenjang'], 'required'],
            [['kode_jenjang', 'nama'], 'string', 'max' => 20],
<<<<<<< HEAD
=======
            [['lock'], 'default', 'value' => '0'],
            [['lock'], 'mootensai\components\OptimisticLockValidator']
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
        ]);
    }
	
}
