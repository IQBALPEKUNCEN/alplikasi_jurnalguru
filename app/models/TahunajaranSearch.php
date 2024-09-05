<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\base\Tahunajaran;

/**
 * app\models\TahunajaranSearch represents the model behind the search form about `app\models\base\Tahunajaran`.
 */
 class TahunajaranSearch extends Tahunajaran
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kodeta', 'semester', 'namata', 'isaktif'], 'safe'],
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
        $query = Tahunajaran::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'kodeta', $this->kodeta])
            ->andFilterWhere(['like', 'semester', $this->semester])
            ->andFilterWhere(['like', 'namata', $this->namata])
            ->andFilterWhere(['like', 'isaktif', $this->isaktif]);

        return $dataProvider;
    }
}
