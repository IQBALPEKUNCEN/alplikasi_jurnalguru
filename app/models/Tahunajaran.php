<?php

namespace app\models;

use Yii;
use \app\models\base\Tahunajaran as BaseTahunajaran;

/**
 * This is the model class for table "tahunajaran".
 */
class Tahunajaran extends BaseTahunajaran
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(
            parent::rules(),
            [
                [['kodeta'], 'required'],
                [['semester'], 'string'],
                [['kodeta', 'namata'], 'string', 'max' => 20],
                [['isaktif'], 'integer'], // ubah dari string ke integer
                [['isaktif'], 'in', 'range' => [0, 1]], // validasi hanya boleh 0 atau 1
            ]
        );
    }
}
