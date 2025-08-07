<?php

namespace app\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\data\ActiveDataProvider;

/**
 * This is the base model class for table "jurusan".
 *
 * @property string $kode_jurusan
 * @property string $nama
 *
 * @property \app\models\Kelas[] $kelas
 */
class Jurusan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kode_jurusan', 'nama'], 'required', 'message' => '{attribute} tidak boleh kosong'],
            [['kode_jurusan'], 'string', 'max' => 20],
            [['nama'], 'string', 'max' => 100],
            [['kode_jurusan'], 'unique', 'message' => 'Kode jurusan sudah digunakan']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'jurusan';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'kode_jurusan' => 'Kode Jurusan',
            'nama' => 'Nama Jurusan'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKelas()
    {
        return $this->hasMany(\app\models\Kelas::className(), ['kode_jurusan' => 'kode_jurusan']);
    }
    public function getJurnalDetils()
    {
        return $this->hasMany(JurnalDetil::class, ['jurnal_id' => 'jurnal_id']);
    }


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = [];

        // Timestamp behavior
        if (class_exists(TimestampBehavior::class)) {
            $behaviors['timestamp'] = [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => false,
                'updatedAtAttribute' => false,
            ];
        }

        // Blameable behavior
        if (class_exists(BlameableBehavior::class)) {
            $behaviors['blameable'] = [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => false,
                'updatedByAttribute' => false,
            ];
        }

        return $behaviors;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'kode_jurusan' => SORT_ASC,
                ]
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'kode_jurusan', $this->kode_jurusan])
            ->andFilterWhere(['like', 'nama', $this->nama]);

        return $dataProvider;
    }

    /**
     * @inheritdoc
     * @return \yii\db\ActiveQuery
     */
    public static function find()
    {
        return parent::find();
    }

    /**
     * Validasi sebelum simpan
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        // Validasi tambahan bisa ditambahkan di sini
        if (empty($this->nama)) {
            $this->addError('nama', 'Nama Jurusan tidak boleh kosong');
            return false;
        }

        return true;
    }

    /**
     * Proses setelah simpan
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        // Logging atau proses tambahan
        Yii::info("Data jurusan {$this->kode_jurusan} telah " . ($insert ? 'ditambahkan' : 'diupdate'), 'application');
    }

    /**
     * Override save untuk penanganan error yang lebih baik
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        try {
            if (!parent::save($runValidation, $attributeNames)) {
                Yii::error('Gagal menyimpan jurusan: ' . json_encode($this->errors), 'application');
                return false;
            }
            return true;
        } catch (\Exception $e) {
            Yii::error('Exception saat menyimpan jurusan: ' . $e->getMessage(), 'application');
            $this->addError('general', 'Terjadi kesalahan sistem');
            return false;
        }
    }
}
