<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PengumpulanTugas;

/**
 * PengumpulanTugasSearch represents the model behind the search form of `app\models\PengumpulanTugas`.
 */
class PengumpulanTugasSearch extends PengumpulanTugas
{
    public $nama_siswa;
    public $kode_kelas;
    public $siswa_id;

    public function rules()
    {
        return [
            [['id', 'tugas_id', 'siswa_id'], 'integer'],
            [['nama_siswa', 'file_tugas', 'keterangan', 'tanggal_kumpul', 'kode_kelas'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = PengumpulanTugas::find()->alias('pt')
            ->joinWith(['siswa s' => function ($q) {
                $q->joinWith('kelas k'); // join ke relasi kelas dari siswa
            }]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // Sorting manual untuk nama_siswa
        $dataProvider->sort->attributes['nama_siswa'] = [
            'asc' => ['s.nama' => SORT_ASC],
            'desc' => ['s.nama' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['kode_kelas'] = [
            'asc' => ['k.kode_kelas' => SORT_ASC],
            'desc' => ['k.kode_kelas' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'pt.id' => $this->id,
            'pt.tugas_id' => $this->tugas_id,
            'pt.tanggal_kumpul' => $this->tanggal_kumpul,
            'pt.siswa_id' => $this->siswa_id, // ✅ Tambahkan ini
        ]);

        $query->andFilterWhere(['like', 's.nama', $this->nama_siswa])
            ->andFilterWhere(['like', 'k.kode_kelas', $this->kode_kelas])
            ->andFilterWhere(['like', 'pt.file_tugas', $this->file_tugas])
            ->andFilterWhere(['like', 'pt.keterangan', $this->keterangan]);

        return $dataProvider;
    }
}
