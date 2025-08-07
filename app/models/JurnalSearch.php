<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\base\Jurnal;

class JurnalSearch extends Jurnal
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jurnal_id', 'guru_id', 'hari_id', 'jam_ke'], 'integer'],
            [['kodeta', 'tanggal', 'kode_kelas', 'kode_mapel', 'jam_mulai', 'jam_selesai', 'status', 'materi'], 'safe'],
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
     * @param bool $applyUserFilter - apakah filter user diterapkan di sini atau di controller
     * @return ActiveDataProvider
     */
    public function search($params, $applyUserFilter = true)
    {
        $query = Jurnal::find();

        // Gunakan alias untuk menghindari ambiguitas kolom
        $query->alias('j')
            ->joinWith([
                'guru g',
                'kodeta0 ta',
                'hari h',
                'kodeKelas k',
                'kodeMapel m'
            ]);

        // Filter berdasarkan user yang login (opsional)
        if ($applyUserFilter) {
            $currentUser = Yii::$app->user->identity;
            if ($currentUser && $currentUser->username !== 'admin') {
                $query->andWhere(['g.nama' => $currentUser->username]);
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'jurnal_id' => SORT_DESC
                ],
                'attributes' => [
                    'jurnal_id' => [
                        'asc' => ['j.jurnal_id' => SORT_ASC],
                        'desc' => ['j.jurnal_id' => SORT_DESC],
                    ],
                    'guru_id' => [
                        'asc' => ['g.nama' => SORT_ASC],
                        'desc' => ['g.nama' => SORT_DESC],
                    ],
                    'kodeta' => [
                        'asc' => ['ta.namata' => SORT_ASC],
                        'desc' => ['ta.namata' => SORT_DESC],
                    ],
                    'tanggal' => [
                        'asc' => ['j.tanggal' => SORT_ASC],
                        'desc' => ['j.tanggal' => SORT_DESC],
                    ],
                    'hari_id' => [
                        'asc' => ['h.nama' => SORT_ASC],
                        'desc' => ['h.nama' => SORT_DESC],
                    ],
                    'jam_ke' => [
                        'asc' => ['j.jam_ke' => SORT_ASC],
                        'desc' => ['j.jam_ke' => SORT_DESC],
                    ],
                    'kode_kelas' => [
                        'asc' => ['k.nama' => SORT_ASC],
                        'desc' => ['k.nama' => SORT_DESC],
                    ],
                    'kode_mapel' => [
                        'asc' => ['m.nama' => SORT_ASC],
                        'desc' => ['m.nama' => SORT_DESC],
                    ],
                    'materi' => [
                        'asc' => ['j.materi' => SORT_ASC],
                        'desc' => ['j.materi' => SORT_DESC],
                    ],
                    'status' => [
                        'asc' => ['j.status' => SORT_ASC],
                        'desc' => ['j.status' => SORT_DESC],
                    ],
                ]
            ]
        ]);

        // Memuat parameter pencarian
        $this->load($params);

        // Jika validasi gagal, kembalikan semua data
        if (!$this->validate()) {
            return $dataProvider;
        }

        // Tambahkan filter dengan menggunakan alias tabel untuk menghindari ambiguitas
        $query->andFilterWhere([
            'j.jurnal_id' => $this->jurnal_id,
            'j.guru_id' => $this->guru_id,
            'j.hari_id' => $this->hari_id,
            'j.jam_ke' => $this->jam_ke,
            'j.tanggal' => $this->tanggal,
        ]);

        // Gunakan alias tabel untuk kolom yang ambiguous
        $query->andFilterWhere(['like', 'j.kodeta', $this->kodeta])
            ->andFilterWhere(['like', 'j.kode_kelas', $this->kode_kelas])
            ->andFilterWhere(['like', 'j.kode_mapel', $this->kode_mapel])
            ->andFilterWhere(['like', 'j.status', $this->status])
            ->andFilterWhere(['like', 'j.materi', $this->materi]);

        // Filter berdasarkan jam_mulai dan jam_selesai
        if (!empty($this->jam_mulai)) {
            $query->andFilterWhere(['like', 'j.jam_mulai', $this->jam_mulai]);
        }

        if (!empty($this->jam_selesai)) {
            $query->andFilterWhere(['like', 'j.jam_selesai', $this->jam_selesai]);
        }

        return $dataProvider;
    }
}
