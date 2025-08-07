<?php

namespace app\models\base;

use Yii;

/**
 * This is the base model class for table "historykelas".
 *
 * @property integer $history_id
 * @property string $nis
 * @property string $kodeta
 * @property string $kode_kelas
 *
 * @property \app\models\Kelas $kodeKelas
 * @property \app\models\Siswa $nis0
 * @property \app\models\Tahunajaran $kodeta0
 */
class Historykelas extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    public function __construct() {}

    public function relationNames()
    {
        return [
            'kodeKelas',
            'nis0',
            'kodeta0'
        ];
    }

    public function rules()
    {
        return [
            [['nis', 'kodeta', 'kode_kelas'], 'string', 'max' => 20]
        ];
    }

    public static function tableName()
    {
        return 'historykelas';
    }

    public function attributeLabels()
    {
        return [
            'history_id' => 'History ID',
            'nis' => 'Nis',
            'kodeta' => 'Kodeta',
            'kode_kelas' => 'Kode Kelas',
        ];
    }

    public function getKodeKelas()
    {
        return $this->hasOne(\app\models\Kelas::className(), ['kode_kelas' => 'kode_kelas']);
    }

    public function getNis0()
    {
        return $this->hasOne(\app\models\Siswa::className(), ['nis' => 'nis']);
    }

    public function getKodeta0()
    {
        return $this->hasOne(\app\models\Tahunajaran::className(), ['kodeta' => 'kodeta']);
    }

    public static function find()
    {
        return new \app\models\HistorykelasQuery(get_called_class());
    }
}
