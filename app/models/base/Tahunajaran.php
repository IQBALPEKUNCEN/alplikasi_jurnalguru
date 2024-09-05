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

    

    public function __construct(){
        
    }

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
            [['lock'], 'default', 'value' => '0'],
            [['lock'], 'mootensai\components\OptimisticLockValidator']
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
     *
     * @return string
     * overwrite function optimisticLock
     * return string name of field are used to stored optimistic lock
     *
     */
    public function optimisticLock() {
        return 'lock';
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
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new \yii\db\Expression('NOW()'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            'uuid' => [
                'class' => UUIDBehavior::className(),
                'column' => 'id',
            ],
        ];
    }

    /**
     * The following code shows how to apply a default condition for all queries:
     *
     * ```php
     * class Customer extends ActiveRecord
     * {
     *     public static function find()
     *     {
     *         return parent::find()->where(['deleted' => false]);
     *     }
     * }
     *
     * // Use andWhere()/orWhere() to apply the default condition
     * // SELECT FROM customer WHERE `deleted`=:deleted AND age>30
     * $customers = Customer::find()->andWhere('age>30')->all();
     *
     * // Use where() to ignore the default condition
     * // SELECT FROM customer WHERE age>30
     * $customers = Customer::find()->where('age>30')->all();
     * ```
     */

    /**
     * @inheritdoc
     * @return \app\models\TahunajaranQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\TahunajaranQuery(get_called_class());
        
    }
}
