<?php

namespace app\models\base;

use Yii;
use yii\db\ActiveRecord;
use mootensai\relation\RelationTrait;

class Guru extends ActiveRecord
{
    use RelationTrait;

    public static function tableName()
    {
        return 'guru';
    }

    public function relationNames()
    {
        return [
            'kodeJk',
            'jurnals',
        ];
    }

    public function rules()
    {
        return [
            [['guru_id', 'nama', 'kode_jk'], 'required'],
            [['tanggal_lahir'], 'safe'],
            [['guru_id'], 'string', 'max' => 20],
            [['guru_id'], 'unique'], // tambahkan validasi unik
            [['nama', 'tempat_lahir', 'alamat'], 'string', 'max' => 255],
            [['kode_jk'], 'string', 'max' => 1],
            [['nip', 'nik'], 'string', 'max' => 50],
            [['jabatan'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'guru_id' => 'Guru ID',
            'nama' => 'Nama',
            'kode_jk' => 'Kode Jenis Kelamin',
            'nip' => 'NIP',
            'nik' => 'NIK',
            'tempat_lahir' => 'Tempat Lahir',
            'tanggal_lahir' => 'Tanggal Lahir',
            'alamat' => 'Alamat',
            'jabatan' => 'Jabatan',
        ];
    }

    public function getKodeJk()
    {
        return $this->hasOne(\app\models\Jeniskelamin::class, ['kode_jk' => 'kode_jk']);
    }

    public function getJurnals()
    {
        return $this->hasMany(\app\models\Jurnal::class, ['guru_id' => 'guru_id']);
    }

    public function behaviors()
    {
        return []; // UUIDBehavior dihapus supaya tidak mengisi otomatis
    }

    public static function find()
    {
        return new \app\models\GuruQuery(get_called_class());
    }
}
