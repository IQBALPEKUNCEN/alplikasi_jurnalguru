<?php

namespace app\models;

use Yii;
use \app\models\base\Hari as BaseHari;

/**
 * This is the model class for table "hari".
 */
class Hari extends BaseHari
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['nama'], 'string', 'max' => 20],
        ]);
    }
	
}
