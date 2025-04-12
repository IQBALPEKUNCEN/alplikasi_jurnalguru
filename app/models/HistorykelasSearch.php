<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\base\Historykelas;

/**
 * app\models\HistorykelasSearch represents the model behind the search form about `app\models\base\Historykelas`.
 */
 class HistorykelasSearch extends Historykelas
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['history_id'], 'integer'],
            [['nis', 'kodeta', 'kode_kelas'], 'safe'],
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
        $query = Historykelas::find();

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
            'history_id' => $this->history_id,
        ]);

        $query->andFilterWhere(['like', 'nis', $this->nis])
            ->andFilterWhere(['like', 'kodeta', $this->kodeta])
            ->andFilterWhere(['like', 'kode_kelas', $this->kode_kelas]);

        return $dataProvider;
    }
}
