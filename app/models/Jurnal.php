<?php

namespace app\models;

use Yii;
use \app\models\base\Jurnal as BaseJurnal;

/**
 * This is the model class for table "jurnal".
 */
class Jurnal extends BaseJurnal
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['hari_id', 'jam_ke'], 'integer'],
            [['materi', 'status'], 'string'],
            [['jam_mulai', 'jam_selesai', 'waktupresensi','tanggal'], 'safe'],
            [['guru_id', 'kodeta', 'kode_kelas', 'kode_mapel'], 'string', 'max' => 20],
            [['file_siswa'], 'string', 'max' => 255],
        ]);
    }
	
}
