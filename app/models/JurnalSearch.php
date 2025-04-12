<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\base\Jurnal;

/**
 * app\models\JurnalSearch represents the model behind the search form about `app\models\base\Jurnal`.
 */
class JurnalSearch extends Jurnal
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['jurnal_id', 'hari_id', 'jam_ke'], 'integer'],
            [['guru_id', 'kodeta', 'materi', 'kode_kelas', 'kode_mapel', 'jam_mulai', 'jam_selesai', 'status', 'waktupresensi', 'file_siswa', 'tanggal'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
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
        $query = Jurnal::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // Uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'jurnal_id' => $this->jurnal_id,
            'hari_id' => $this->hari_id,
            'jam_ke' => $this->jam_ke,
            'jam_mulai' => $this->jam_mulai,
            'jam_selesai' => $this->jam_selesai,
            'waktupresensi' => $this->waktupresensi,
        ]);

        $query->andFilterWhere(['like', 'guru_id', $this->guru_id])
            ->andFilterWhere(['like', 'kodeta', $this->kodeta])
            ->andFilterWhere(['like', 'materi', $this->materi])
            ->andFilterWhere(['like', 'kode_kelas', $this->kode_kelas])
            ->andFilterWhere(['like', 'kode_mapel', $this->kode_mapel])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'file_siswa', $this->file_siswa]);

        // Filter berdasarkan tanggal
        if ($this->tanggal) {
            $query->andFilterWhere(['DATE(tanggal)' => date('Y-m-d', strtotime($this->tanggal))]);
        }

        return $dataProvider;
    }
}
