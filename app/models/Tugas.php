<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tugas".
 *
 * @property int $id
 * @property string $judul_tugas
 * @property string|null $deskripsi
 * @property string $tanggal_dibuat
 * @property string $tanggal_selesai
 * @property string|null $kode_mapel
 * @property string|null $kode_kelas
 * @property string|null $guru_id
 * @property string|null $file_tugas
 *
 * @property Guru $guru
 * @property Kelas $kodeKelas
 * @property Mapel $kodeMapel
 */
class Tugas extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'tugas';
    }

    public function rules()
    {
        return [
            [['judul_tugas', 'deskripsi', 'tanggal_dibuat', 'tanggal_selesai', 'kode_mapel', 'kode_kelas', 'guru_id'], 'required'],
            [['deskripsi'], 'string'],
            [['tanggal_dibuat', 'tanggal_selesai'], 'safe'],
            [['judul_tugas', 'kode_mapel', 'kode_kelas', 'guru_id'], 'string', 'max' => 255],
            [
                ['file_tugas'],
                'file',
                'skipOnEmpty' => true,
                'extensions' => 'pdf,doc,docx,xls,xlsx,ppt,pptx,txt,jpg,jpeg,png',
                'maxSize' => 10 * 1024 * 1024, // 10MB
                'tooBig' => 'Ukuran file maksimal 10MB',
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'judul_tugas' => 'Judul Tugas',
            'deskripsi' => 'Deskripsi',
            'tanggal_dibuat' => 'Tanggal Dibuat',
            'tanggal_selesai' => 'Tanggal Selesai',
            'kode_mapel' => 'Mata Pelajaran',
            'kode_kelas' => 'Kelas',
            'guru_id' => 'Guru',
            'file_tugas' => 'File Tugas',
        ];
    }

    public function getMapel()
    {
        return $this->hasOne(Mapel::class, ['kode_mapel' => 'kode_mapel']); // sesuaikan kolomnya
    }


    public function getKelas()
    {
        return $this->hasOne(\app\models\base\Kelas::class, ['kode_kelas' => 'kode_kelas']);
    }


    public function getGuru()
    {
        return $this->hasOne(\app\models\Guru::class, ['guru_id' => 'guru_id']);
    }
}
