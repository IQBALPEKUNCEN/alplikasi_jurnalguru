<?php

namespace app\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "guru".
 *
 * @property string $guru_id
 * @property string $nama
 * @property string $kode_jk
 * @property string $nip
 * @property string $nik
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $alamat
 *
 * @property \app\models\Jeniskelamin $kodeJk
 * @property \app\models\Jurnal[] $jurnals
 */
class Guru extends \yii\db\ActiveRecord
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
            'kodeJk',
            'jurnals'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['guru_id'], 'required'],
            [['tanggal_lahir'], 'safe'],
            [['guru_id'], 'string', 'max' => 20],
            [['nama', 'tempat_lahir', 'alamat'], 'string', 'max' => 255],
            [['kode_jk'], 'string', 'max' => 1],
            [['nip', 'nik'], 'string', 'max' => 50],
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
        return 'guru';
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
            'guru_id' => 'Guru ID',
            'nama' => 'Nama',
            'kode_jk' => 'Kode Jk',
            'nip' => 'Nip',
            'nik' => 'Nik',
            'tempat_lahir' => 'Tempat Lahir',
            'tanggal_lahir' => 'Tanggal Lahir',
            'alamat' => 'Alamat',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKodeJk()
    {
        return $this->hasOne(\app\models\Jeniskelamin::className(), ['kode_jk' => 'kode_jk']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJurnals()
    {
        return $this->hasMany(\app\models\Jurnal::className(), ['guru_id' => 'guru_id']);
    }
    
    /**
     * @inheritdoc
     * @return array mixed
     */
    public function behaviors()
    {
<<<<<<< HEAD
        return [];
=======
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
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
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
     * @return \app\models\GuruQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\GuruQuery(get_called_class());
<<<<<<< HEAD
=======
       
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
    }
}
