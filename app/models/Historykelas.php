<?php

namespace app\models;

use Yii;
use \app\models\base\Historykelas as BaseHistorykelas;

/**
 * This is the model class for table "historykelas".
 */
class Historykelas extends BaseHistorykelas
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['nis', 'kodeta', 'kode_kelas'], 'string', 'max' => 20],
<<<<<<< HEAD
=======
            [['lock'], 'default', 'value' => '0'],
            [['lock'], 'mootensai\components\OptimisticLockValidator']
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
        ]);
    }
	
}
