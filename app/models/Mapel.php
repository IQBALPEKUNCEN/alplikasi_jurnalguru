<?php

namespace app\models;

use Yii;
use \app\models\base\Mapel as BaseMapel;

/**
 * This is the model class for table "mapel".
 */
class Mapel extends BaseMapel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['kode_mapel'], 'required'],
            [['kode_mapel'], 'string', 'max' => 20],
            [['nama'], 'string', 'max' => 50],
        ]);
    }
	
}
