<?php

namespace app\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "kelas".
 *
 * @property string $kode_kelas
 * @property string $kode_jenjang
 * @property string $kode_jurusan
 * @property string $nama
 *
 * @property \app\models\Historykelas[] $historykelas
 * @property \app\models\Jurnal[] $jurnals
 * @property \app\models\Jenjang $kodeJenjang
 * @property \app\models\Jurusan $kodeJurusan
 */
class Kelas extends \yii\db\ActiveRecord
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
            'jurnals',
            'kodeJenjang',
            'kodeJurusan'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kode_kelas'], 'required'],
            [['kode_kelas', 'kode_jenjang', 'kode_jurusan', 'nama'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kelas';
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
            'kode_kelas' => 'Kode Kelas',
            'kode_jenjang' => 'Kode Jenjang',
            'kode_jurusan' => 'Kode Jurusan',
            'nama' => 'Nama',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKodeJurusan()
    {
        return $this->hasOne(Jurusan::class, ['kode_jurusan' => 'kode_jurusan']);
    }
    

    public function getHistorykelas()
    {
        return $this->hasMany(\app\models\Historykelas::className(), ['kode_kelas' => 'kode_kelas']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJurnals()
    {
        return $this->hasMany(\app\models\Jurnal::className(), ['kode_kelas' => 'kode_kelas']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKodeJenjang()
    {
        return $this->hasOne(\app\models\Jenjang::className(), ['kode_jenjang' => 'kode_jenjang']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    // public function getKodeJurusan()
    // {
    //     return $this->hasOne(\app\models\Jurusan::className(), ['kode_jurusan' => 'kode_jurusan']);
    // }
    
    /**
     * @inheritdoc
     * @return array mixed
     */
    public function behaviors()
    {
        return [];
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
     * @return \app\models\KelasQuery the active query used by this AR class.
     */
    public static function find()
    {
       return new \app\models\KelasQuery(get_called_class());
    }
}
