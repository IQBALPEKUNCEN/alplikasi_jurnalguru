<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\base\Hari;

/**
 * app\models\HariSearch represents the model behind the search form about `app\models\base\Hari`.
 */
 class HariSearch extends Hari
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hari_id'], 'integer'],
            [['nama'], 'safe'],
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
        $query = Hari::find();

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
            'hari_id' => $this->hari_id,
        ]);

        $query->andFilterWhere(['like', 'nama', $this->nama]);

        return $dataProvider;
    }
}
