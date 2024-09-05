<?php

namespace app\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "jurnal".
 *
 * @property integer $jurnal_id
 * @property string $guru_id
 * @property string $kodeta
 * @property integer $hari_id
 * @property integer $jam_ke
 * @property string $materi
 * @property string $kode_kelas
 * @property string $kode_mapel
 * @property string $jam_mulai
 * @property string $jam_selesai
 * @property string $status
 * @property string $waktupresensi
 * @property string $file_siswa
 *
 * @property \app\models\Guru $guru
 * @property \app\models\Hari $hari
 * @property \app\models\Kelas $kodeKelas
 * @property \app\models\Mapel $kodeMapel
 * @property \app\models\Tahunajaran $kodeta0
 * @property \app\models\JurnalDetil[] $jurnalDetils
 */
class Jurnal extends \yii\db\ActiveRecord
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
            'guru',
            'hari',
            'kodeKelas',
            'kodeMapel',
            'kodeta0',
            'jurnalDetils'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hari_id', 'jam_ke'], 'integer'],
            [['materi', 'status'], 'string'],
            [['jam_mulai', 'jam_selesai', 'waktupresensi'], 'safe'],
            [['guru_id', 'kodeta', 'kode_kelas', 'kode_mapel'], 'string', 'max' => 20],
            [['file_siswa'], 'string', 'max' => 255],
            [['lock'], 'default', 'value' => '0'],
            [['lock'], 'mootensai\components\OptimisticLockValidator']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'jurnal';
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
            'jurnal_id' => 'Jurnal ID',
            'guru_id' => 'Guru ID',
            'kodeta' => 'Kodeta',
            'hari_id' => 'Hari ID',
            'jam_ke' => 'Jam Ke',
            'materi' => 'Materi',
            'kode_kelas' => 'Kode Kelas',
            'kode_mapel' => 'Kode Mapel',
            'jam_mulai' => 'Jam Mulai',
            'jam_selesai' => 'Jam Selesai',
            'status' => 'Status',
            'waktupresensi' => 'Waktupresensi',
            'file_siswa' => 'File Siswa',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGuru()
    {
        return $this->hasOne(\app\models\Guru::className(), ['guru_id' => 'guru_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHari()
    {
        return $this->hasOne(\app\models\Hari::className(), ['hari_id' => 'hari_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKodeKelas()
    {
        return $this->hasOne(\app\models\Kelas::className(), ['kode_kelas' => 'kode_kelas']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKodeMapel()
    {
        return $this->hasOne(\app\models\Mapel::className(), ['kode_mapel' => 'kode_mapel']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKodeta0()
    {
        return $this->hasOne(\app\models\Tahunajaran::className(), ['kodeta' => 'kodeta']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJurnalDetils()
    {
        return $this->hasMany(\app\models\JurnalDetil::className(), ['jurnal_id' => 'jurnal_id']);
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
     * @return \app\models\JurnalQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\JurnalQuery(get_called_class());
       
    }
}
