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
 *
 * @property \app\models\Jurnal[] $jurnals
 */
class Mapel extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

<<<<<<< HEAD
    public function __construct(){
=======
    

    public function __construct(){
       
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
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
            [['kode_mapel'], 'required'],
            [['kode_mapel'], 'string', 'max' => 20],
            [['nama'], 'string', 'max' => 50],
<<<<<<< HEAD
=======
            [['lock'], 'default', 'value' => '0'],
            [['lock'], 'mootensai\components\OptimisticLockValidator']
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
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
     *
     * @return string
     * overwrite function optimisticLock
     * return string name of field are used to stored optimistic lock
     *
     */
<<<<<<< HEAD
=======
    public function optimisticLock() {
        return 'lock';
    }
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'kode_mapel' => 'Kode Mapel',
            'nama' => 'Nama',
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
     * @inheritdoc
     * @return array mixed
     */
    public function behaviors()
    {
        return [
<<<<<<< HEAD
=======
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
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
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
     * @return \app\models\MapelQuery the active query used by this AR class.
     */
    public static function find()
    {
<<<<<<< HEAD
       return new \app\models\MapelQuery(get_called_class());
=======
        return new \app\models\MapelQuery(get_called_class());
        
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
    }
}
