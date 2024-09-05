<?php

namespace app\models;

use Yii;
use \app\models\base\Jurusan as BaseJurusan;

/**
 * This is the model class for table "jurusan".
 */
class Jurusan extends BaseJurusan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['kode_jurusan'], 'required'],
            [['kode_jurusan', 'nama'], 'string', 'max' => 20],
            [['lock'], 'default', 'value' => '0'],
            [['lock'], 'mootensai\components\OptimisticLockValidator']
        ]);
    }
	
}
