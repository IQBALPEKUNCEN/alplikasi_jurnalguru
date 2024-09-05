<?php

namespace app\models;

use Yii;
use \app\models\base\Guru as BaseGuru;

/**
 * This is the model class for table "guru".
 */
class Guru extends BaseGuru
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['guru_id'], 'required'],
            [['tanggal_lahir'], 'safe'],
            [['guru_id'], 'string', 'max' => 20],
            [['nama', 'tempat_lahir', 'alamat'], 'string', 'max' => 255],
            [['kode_jk'], 'string', 'max' => 1],
            [['nip', 'nik'], 'string', 'max' => 50],
            [['lock'], 'default', 'value' => '0'],
            [['lock'], 'mootensai\components\OptimisticLockValidator']
        ]);
    }
	
}
