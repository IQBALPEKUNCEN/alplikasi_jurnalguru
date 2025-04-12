<?php

namespace app\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "tahunajaran".
 *
 * @property string $kodeta
 * @property string $semester
 * @property string $namata
 * @property integer $isaktif
 *
 * @property \app\models\Historykelas[] $historykelas
 * @property \app\models\Jurnal[] $jurnals
 */
class Tahunajaran extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    public function __construct() {}

    /**
     * This function helps \mootensai\relation\RelationTrait runs faster
     * @return array relation names of this model
     */
    public function relationNames()
    {
        return [
            'historykelas',
            'jurnals'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kodeta'], 'required'],
            [['semester'], 'string'],
            [['kodeta', 'namata'], 'string', 'max' => 20],
            [['isaktif'], 'string', 'max' => 1],
            // Tambahkan custom rule untuk memeriksa isaktif
        ];
    }

    /**
     * Custom validation rule untuk memastikan isaktif tidak diset ke '1' pada saat penyimpanan
     */

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tahunajaran';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'kodeta' => 'Kodeta',
            'semester' => 'Semester',
            'namata' => 'Namata',
            'isaktif' => 'Isaktif',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHistorykelas()
    {
        return $this->hasMany(\app\models\Historykelas::className(), ['kodeta' => 'kodeta']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJurnals()
    {
        return $this->hasMany(\app\models\Jurnal::className(), ['kodeta' => 'kodeta']);
    }

    /**
     * @inheritdoc
     * @return array mixed
     */
    public function behaviors()
    {
        return [];
    }

    /**
     * @inheritdoc
     * @return \app\models\TahunajaranQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\TahunajaranQuery(get_called_class());
    }
}
