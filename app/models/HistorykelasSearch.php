<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\base\Historykelas;

/**
 * HistorykelasSearch represents the model behind the search form of `app\models\base\Historykelas`.
 */
class HistorykelasSearch extends Historykelas
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['history_id', 'nis', 'kodeta', 'kode_kelas'], 'safe'],
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
            'pagination' => [
                'pageSize' => 20, // atau sesuaikan dengan kebutuhan
            ],
            'sort' => [
                'defaultOrder' => [
                    'history_id' => SORT_DESC,
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // Jika validasi gagal, jangan kembalikan data apa pun
            return $dataProvider;
        }

        // Filter pencarian
        $query->andFilterWhere(['like', 'history_id', $this->history_id])
            ->andFilterWhere(['like', 'nis', $this->nis])
            ->andFilterWhere(['like', 'kodeta', $this->kodeta])
            ->andFilterWhere(['like', 'kode_kelas', $this->kode_kelas]);

        return $dataProvider;
    }
}
