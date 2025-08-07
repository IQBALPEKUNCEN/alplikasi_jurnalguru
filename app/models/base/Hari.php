<?php

namespace app\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "hari".
 *
 * @property integer $hari_id
 * @property string $nama
 *
 * @property \app\models\Jurnal[] $jurnals
 */
class Hari extends \yii\db\ActiveRecord
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
            'jurnals'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama'], 'string', 'max' => 20],
            [['no_urut'], 'integer'],

        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hari';
    }

    /**
     *
     * @return string
     * overwrite function optimisticLock
     * return string name of field are used to stored optimistic lock
     *
     */


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'hari_id' => 'Hari ID',
            'nama' => 'Nama',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJurnals()
    {

        // return $this->hasMany(\app\models\Jurnal::className(), ['hari_id' => 'hari_id']);

        return $this->hasMany(\app\models\Jurnal::className(), ['hari_id' => 'hari_id']);

    }
    
    /**
     * @inheritdoc
     * @return array mixed
     */
    // public function behaviors()
    // {

    //     return [];

    //     return [
    //         'timestamp' => [
    //             'class' => TimestampBehavior::className(),
    //             'createdAtAttribute' => 'created_at',
    //             'updatedAtAttribute' => 'updated_at',
    //             'value' => new \yii\db\Expression('NOW()'),
    //         ],
    //         'blameable' => [
    //             'class' => BlameableBehavior::className(),
    //             'createdByAttribute' => 'created_by',
    //             'updatedByAttribute' => 'updated_by',
    //         ],
    //         'uuid' => [
    //             'class' => UUIDBehavior::className(),
    //             'column' => 'id',
    //         ],
    //     ];

    // }

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
     * @return \app\models\HariQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\HariQuery(get_called_class());
    }
}
