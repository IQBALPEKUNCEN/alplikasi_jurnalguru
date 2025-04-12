<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\base\Kelas;

/**
 * app\models\KelasSearch represents the model behind the search form about `app\models\base\Kelas`.
 */
 class KelasSearch extends Kelas
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kode_kelas', 'kode_jenjang', 'kode_jurusan', 'nama'], 'safe'],
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
        $query = Kelas::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'kode_kelas', $this->kode_kelas])
            ->andFilterWhere(['like', 'kode_jenjang', $this->kode_jenjang])
            ->andFilterWhere(['like', 'kode_jurusan', $this->kode_jurusan])
            ->andFilterWhere(['like', 'nama', $this->nama]);

        return $dataProvider;
    }
}
