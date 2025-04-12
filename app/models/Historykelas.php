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
        ]);
    }
	
}
