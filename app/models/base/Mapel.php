<?php

namespace app\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use mootensai\behaviors\UUIDBehavior;

/**
* This is the base model class for table "mapel".
*
* @property string $kode_mapel
* @property string $nama
* @property string $guru_id
*
* @property \app\models\Jurnal[] $jurnals
* @property \app\models\Guru $guru
*/
class Mapel extends \yii\db\ActiveRecord
{
use \mootensai\relation\RelationTrait;

public $guru_id; // Tambahkan properti guru_id agar tidak ada error saat menyetelnya

public function __construct(){
// Konstruktor jika diperlukan
}

/**
* @inheritdoc
*/
    public function rules()
    {
        return [
            [['kode_mapel'], 'required'],
            [['kode_mapel'], 'string', 'max' => 20],
            [['nama'], 'string', 'max' => 50],
            // [['lock'], 'default', 'value' => '0'],
            // [['lock'], 'mootensai\components\OptimisticLockValidator']
        ];
    }

/**
* @inheritdoc
*/
public static function tableName()
{
return 'mapel';
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
'kode_mapel' => 'Kode Mapel',
'nama' => 'Nama',
'guru_id' => 'Guru', // Ganti 'guru' menjadi 'guru_id'
];
}

/**
* @return \yii\db\ActiveQuery
*/
public function getJurnals()
{
return $this->hasMany(\app\models\Jurnal::className(), ['kode_mapel' => 'kode_mapel']);
}

/**
* Relasi ke model Guru
*/
public function getGuru()
{
return $this->hasOne(Guru::class, ['id' => 'guru_id']);
}

/**
* @inheritdoc
*/
// public function behaviors()
// {
// return [
// [
// 'class' => TimestampBehavior::class,
// 'createdAtAttribute' => false,
// 'updatedAtAttribute' => false,
// ],
// [
// 'class' => UUIDBehavior::class,
// 'column' => 'guru_id',
// ],
// ];
// }

/**
* @inheritdoc
* @return \app\models\MapelQuery the active query used by this AR class.
*/
public static function find()
{
return new \app\models\MapelQuery(get_called_class());
}
}