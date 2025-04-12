<?php

namespace app\models;

use Yii;
use \app\models\base\JurnalDetil as BaseJurnalDetil;

/**
 * This is the model class for table "jurnal_detil".
 */
class JurnalDetil extends BaseJurnalDetil
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['jurnal_id'], 'required'],
            [['jurnal_id'], 'integer'],
            [['status'], 'string'],
            [['waktu_presensi'], 'safe'],
            [['nis'], 'string', 'max' => 20],
            [['nama'], 'string', 'max' => 255],
        ]);
    }
	
}
