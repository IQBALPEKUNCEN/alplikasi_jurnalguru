<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\base\Siswa;

/**
 * app\models\SiswaSearch represents the model behind the search form about `app\models\base\Siswa`.
 */
 class SiswaSearch extends Siswa
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nis', 'nama', 'kode_kelas', 'kode_jk', 'tempat_lahir', 'tanggal_lahir', 'no_hp', 'alamat'], 'safe'],
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
        $query = Siswa::find();

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

        $query->andFilterWhere(['like', 'nis', $this->nis])
            ->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'kode_kelas', $this->kode_kelas])
            ->andFilterWhere(['like', 'kode_jk', $this->kode_jk])
            ->andFilterWhere(['like', 'tempat_lahir', $this->tempat_lahir])
            ->andFilterWhere(['like', 'no_hp', $this->no_hp])
            ->andFilterWhere(['like', 'alamat', $this->alamat]);

        return $dataProvider;
    }
}
