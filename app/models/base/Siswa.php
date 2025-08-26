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
            [['telegram_id'], 'string', 'max' => 50], // ✅ tambahkan ini

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
            'telegram_id' => 'Telegram ID', // ✅ tambahkan ini
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJurnalDetils()
    {
        return $this->hasMany(\app\models\JurnalDetil::class, ['nis' => 'nis']);
    }

    public function getHistorykelas()
    {
        return $this->hasMany(\app\models\Historykelas::class, ['nis' => 'nis']);
    }


    public function getKodeJurusan()
    {
        return $this->hasOne(\app\models\base\Jurusan::class, ['kode_jurusan' => 'kode_jurusan'])
            ->via('kodeKelas');
    }

    public function getKodeKelas()
    {
        return $this->hasOne(\app\models\base\Kelas::class, ['kode_kelas' => 'kode_kelas']);
    }

    public function getKelas()
    {
        return $this->hasOne(Kelas::class, ['kode_kelas' => 'kode_kelas']);
    }

    
    




    /**
     * @inheritdoc
     * @return array mixed
     */
    // public function behaviors()
    // {
    //     return [
    //         // Jika tidak ada kolom created_at di tabel, hapus atau modifikasi behavior ini
    //         'timestamp' => [
    //             'class' => TimestampBehavior::className(),
    //             'createdAtAttribute' => false, // Set false jika tidak ada kolom created_at
    //             'updatedAtAttribute' => false, // Set false jika tidak ada kolom updated_at
    //         ],
    //         // Behavior lainnya jika ada
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
     * @return \app\models\SiswaQuery the active query used by this AR class.
     */
    public static function find()
    {

        return new \app\models\SiswaQuery(get_called_class());
    }
    
}
