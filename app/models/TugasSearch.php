<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Tugas;

/**
 * TugasSearch represents the model behind the search form of `app\models\Tugas`.
 */
class TugasSearch extends Tugas
{
    public $nama_kelas; // ✅ Tambahan properti untuk filter kelas

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['judul_tugas', 'deskripsi', 'tanggal_dibuat', 'tanggal_selesai', 'kode_mapel', 'kode_kelas', 'guru_id', 'file_tugas', 'nama_kelas'], 'safe'], // ✅ nama_kelas ditambahkan
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
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
        $query = Tugas::find()->joinWith(['kelas']); // ✅ join ke relasi kelas

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // Optional: jika kamu ingin enable sorting berdasarkan nama_kelas
        $dataProvider->sort->attributes['nama_kelas'] = [
            'asc' => ['kelas.nama_kelas' => SORT_ASC],
            'desc' => ['kelas.nama_kelas' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'tanggal_dibuat' => $this->tanggal_dibuat,
            'tanggal_selesai' => $this->tanggal_selesai,
        ]);

        $query->andFilterWhere(['like', 'judul_tugas', $this->judul_tugas])
            ->andFilterWhere(['like', 'deskripsi', $this->deskripsi])
            ->andFilterWhere(['like', 'kode_mapel', $this->kode_mapel])
            ->andFilterWhere(['like', 'kode_kelas', $this->kode_kelas])
            ->andFilterWhere(['like', 'guru_id', $this->guru_id])
            ->andFilterWhere(['like', 'file_tugas', $this->file_tugas]);

        // ✅ filter berdasarkan nama_kelas dari relasi kelas
        $query->andFilterWhere(['like', 'kelas.nama_kelas', $this->kode_kelas]);

        // ✅ hanya tampilkan tugas dengan deadline hari ini atau yang akan datang
        $query->andWhere(['>=', 'tanggal_selesai', date('Y-m-d')]);

        return $dataProvider;
    }
}
