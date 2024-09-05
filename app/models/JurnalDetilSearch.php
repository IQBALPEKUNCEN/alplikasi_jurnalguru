<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\base\JurnalDetil;

/**
 * app\models\JurnalDetilSearch represents the model behind the search form about `app\models\base\JurnalDetil`.
 */
 class JurnalDetilSearch extends JurnalDetil
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['detil_id', 'jurnal_id'], 'integer'],
            [['nis', 'nama', 'status', 'waktu_presensi'], 'safe'],
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
        $query = JurnalDetil::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'detil_id' => $this->detil_id,
            'jurnal_id' => $this->jurnal_id,
            'waktu_presensi' => $this->waktu_presensi,
        ]);

        $query->andFilterWhere(['like', 'nis', $this->nis])
            ->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
