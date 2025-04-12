<?php

namespace app\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "siswa".
 *
 * @property string $nis
 * @property string $nama
 * @property string $kode_kelas
 * @property string $kode_jk
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $no_hp
 * @property string $alamat
 *
 * @property \app\models\Historykelas[] $historykelas
 * @property \app\models\JurnalDetil[] $jurnalDetils
 */
class Siswa extends \yii\db\ActiveRecord
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
            'historykelas',
            'jurnalDetils'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nis'], 'required'],
            [['tanggal_lahir'], 'safe'],
            [['nis', 'kode_kelas', 'no_hp'], 'string', 'max' => 20],
            [['nama', 'tempat_lahir', 'alamat'], 'string', 'max' => 255],
            [['kode_jk'], 'string', 'max' => 1],
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
        return 'siswa';
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
            'nis' => 'Nis',
            'nama' => 'Nama',
            'kode_kelas' => 'Kode Kelas',
            'kode_jk' => 'Kode Jk',
            'tempat_lahir' => 'Tempat Lahir',
            'tanggal_lahir' => 'Tanggal Lahir',
            'no_hp' => 'No Hp',
            'alamat' => 'Alamat',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHistorykelas()
    {
        return $this->hasMany(\app\models\Historykelas::className(), ['nis' => 'nis']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJurnalDetils()
    {
        return $this->hasMany(\app\models\JurnalDetil::className(), ['nis' => 'nis']);
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
     * @return \app\models\SiswaQuery the active query used by this AR class.
     */
    public static function find()
    {
<<<<<<< HEAD
       return new \app\models\SiswaQuery(get_called_class());
=======
        return new \app\models\SiswaQuery(get_called_class());
       
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
    }
}
