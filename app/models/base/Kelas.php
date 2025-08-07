<?php

namespace app\models\base;

use Yii;
use yii\db\ActiveRecord;
use mootensai\relation\RelationTrait;

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
class Kelas extends ActiveRecord
{
    use RelationTrait;

    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    /**
     * Untuk mempercepat RelationTrait
     * @return array
     */
    public function relationNames()
    {
        return [
            'historykelas',
            'jurnals',
            'kodeJenjang',
            'kodeJurusan',
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
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kode_kelas', 'kode_jenjang', 'kode_jurusan', 'nama'], 'required'],
            [['kode_kelas'], 'unique'],
            [['kode_kelas', 'kode_jenjang', 'kode_jurusan', 'nama'], 'string', 'max' => 20],
            [['kode_jenjang'], 'exist', 'skipOnError' => true, 'targetClass' => Jenjang::class, 'targetAttribute' => ['kode_jenjang' => 'kode_jenjang']],
            [['kode_jurusan'], 'exist', 'skipOnError' => true, 'targetClass' => Jurusan::class, 'targetAttribute' => ['kode_jurusan' => 'kode_jurusan']],
        ];
    }

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
     * Relasi ke tabel Jenjang
     * @return \yii\db\ActiveQuery
     */
    public function getKodeJenjang()
    {
        return $this->hasOne(Jenjang::class, ['kode_jenjang' => 'kode_jenjang']);
    }

    /**
     * Relasi ke tabel Jurusan
     * @return \yii\db\ActiveQuery
     */
    public function getKodeJurusan()
    {
        return $this->hasOne(Jurusan::class, ['kode_jurusan' => 'kode_jurusan']);
    }

    /**
     * Relasi ke tabel Historykelas
     * @return \yii\db\ActiveQuery
     */
    public function getHistorykelas()
    {
        return $this->hasMany(Historykelas::class, ['kode_kelas' => 'kode_kelas']);
    }

    /**
     * Relasi ke tabel Jurnal
     * @return \yii\db\ActiveQuery
     */
    public function getJurnals()
    {
        return $this->hasMany(Jurnal::class, ['kode_kelas' => 'kode_kelas']);
    }

    /**
     * @inheritdoc
     * @return \app\models\KelasQuery
     */
    public static function find()
    {
        return new \app\models\KelasQuery(get_called_class());
    }
}
