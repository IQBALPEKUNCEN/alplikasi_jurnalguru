<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\base\Jurusan;

/**
 * app\models\JurusanSearch represents the model behind the search form about `app\models\base\Jurusan`.
 */
 class JurusanSearch extends Jurusan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kode_jurusan', 'nama'], 'safe'],
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
        $query = Jurusan::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'kode_jurusan', $this->kode_jurusan])
            ->andFilterWhere(['like', 'nama', $this->nama]);

        return $dataProvider;
    }
}
