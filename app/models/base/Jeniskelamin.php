<?php

namespace app\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "jeniskelamin".
 *
 * @property string $kode_jk
 * @property string $nama
 *
 * @property \app\models\Guru[] $gurus
 */
class Jeniskelamin extends \yii\db\ActiveRecord
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

            'guru'

        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kode_jk'], 'required'],
            [['kode_jk'], 'string', 'max' => 1],
            [['nama'], 'string', 'max' => 20],


        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'jeniskelamin';
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
            'kode_jk' => 'Kode Jk',
            'nama' => 'Nama',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGurus()
    {
        return $this->hasMany(\app\models\Guru::className(), ['kode_jk' => 'kode_jk']);
    }
    
    /**
     * @inheritdoc
     * @return array mixed
     */
    // public function behaviors()
    // {
    //     return [
    //         [
    //             'class' => TimestampBehavior::class,
    //             'createdAtAttribute' => false,
    //             'updatedAtAttribute' => false,
    //         ],
    //         [
    //             'class' => UUIDBehavior::class,
    //             'column' => 'guru_id',
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
     * @return \app\models\JeniskelaminQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\JeniskelaminQuery(get_called_class());


    

    }
}
