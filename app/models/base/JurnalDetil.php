<?php

namespace app\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "jurnal_detil".
 *
 * @property integer $detil_id
 * @property integer $jurnal_id
 * @property string $nis
 * @property string $nama
 * @property string $status
 * @property string $waktu_presensi
 *
 * @property \app\models\Jurnal $jurnal
 * @property \app\models\Siswa $nis0
 */
class JurnalDetil extends \yii\db\ActiveRecord
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
            'jurnal',
            'nis0'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['jurnal_id'], 'required'],
            [['jurnal_id'], 'integer'],
            [['status'], 'string'],
            [['waktu_presensi'], 'safe'],
            [['nis'], 'string', 'max' => 20],
            [['nama'], 'string', 'max' => 255],
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
        return 'jurnal_detil';
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
            'detil_id' => 'Detil ID',
            'jurnal_id' => 'Jurnal ID',
            'nis' => 'Nis',
            'nama' => 'Nama',
            'status' => 'Status',
            'waktu_presensi' => 'Waktu Presensi',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJurnal()
    {
        return $this->hasOne(\app\models\Jurnal::className(), ['jurnal_id' => 'jurnal_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNis0()
    {
        return $this->hasOne(\app\models\Siswa::className(), ['nis' => 'nis']);
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
     * @return \app\models\JurnalDetilQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\JurnalDetilQuery(get_called_class());
<<<<<<< HEAD
=======
       
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
    }
}
