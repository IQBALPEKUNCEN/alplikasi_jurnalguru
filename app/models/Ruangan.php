<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ruangan".
 *
 * @property int $id
 * @property string $nama
 *
 * @property Jadwal[] $jadwals
 */
class Ruangan extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'ruangan';
    }

    public function rules()
    {
        return [
            [['nama'], 'required'],
            [['nama'], 'string', 'max' => 100],
            [['nama'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama Ruangan',
        ];
    }

    public function getJadwals()
    {
        return $this->hasMany(Jadwal::class, ['ruangan_id' => 'id']);
    }
}
