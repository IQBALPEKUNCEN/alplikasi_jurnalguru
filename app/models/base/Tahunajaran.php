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
            [['isaktif'], 'integer', 'min' => 0, 'max' => 1],
            [['isaktif'], 'default', 'value' => 0],
        ];
    }

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
            'kodeta' => 'Kode Tahun Ajaran',
            'semester' => 'Semester',
            'namata' => 'Nama Tahun Ajaran',
            'isaktif' => 'Status Aktif',
        ];
    }

    /**
     * Constructor
     */
    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    /**
     * Before save event - handle active status
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // Jika data ini diset sebagai aktif
            if ($this->isaktif == 1) {
                // Nonaktifkan semua data lain kecuali yang sedang disimpan
                if ($insert) {
                    // Untuk insert baru, nonaktifkan semua
                    self::updateAll(['isaktif' => 0]);
                } else {
                    // Untuk update, nonaktifkan semua kecuali record ini
                    self::updateAll(['isaktif' => 0], 'kodeta != :id', [':id' => $this->kodeta]);
                }
            }
            return true;
        }
        return false;
    }

    /**
     * Get active tahun ajaran
     * @return Tahunajaran|null
     */
    public static function getActive()
    {
        return self::find()->where(['isaktif' => 1])->one();
    }

    /**
     * Check if this tahun ajaran is active
     * @return boolean
     */
    public function isActive()
    {
        return $this->isaktif == 1;
    }

    /**
     * Get status text
     * @return string
     */
    public function getStatusText()
    {
        return $this->isaktif == 1 ? 'Aktif' : 'Tidak Aktif';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHistorykelas()
    {
        return $this->hasMany(Historykelas::className(), ['kodeta' => 'kodeta']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJurnals()
    {
        return $this->hasMany(Jurnal::className(), ['kodeta' => 'kodeta']);
    }

    /**
     * Get jurnal property for compatibility
     * @return \yii\db\ActiveQuery
     */
    public function getJurnal()
    {
        return $this->getJurnals();
    }
}
