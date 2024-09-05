<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\base\Guru;

/**
 * app\models\GuruSearch represents the model behind the search form about `app\models\base\Guru`.
 */
 class GuruSearch extends Guru
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['guru_id', 'nama', 'kode_jk', 'nip', 'nik', 'tempat_lahir', 'tanggal_lahir', 'alamat'], 'safe'],
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
        $query = Guru::find();

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
            'tanggal_lahir' => $this->tanggal_lahir,
        ]);

        $query->andFilterWhere(['like', 'guru_id', $this->guru_id])
            ->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'kode_jk', $this->kode_jk])
            ->andFilterWhere(['like', 'nip', $this->nip])
            ->andFilterWhere(['like', 'nik', $this->nik])
            ->andFilterWhere(['like', 'tempat_lahir', $this->tempat_lahir])
            ->andFilterWhere(['like', 'alamat', $this->alamat]);

        return $dataProvider;
    }
}
