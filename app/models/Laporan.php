<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Laporan extends ActiveRecord
{
    public $date_range; // Atribut untuk menyimpan rentang tanggal
    public $start_date; // Atribut untuk tanggal mulai
    public $end_date; // Atribut untuk tanggal akhir

    public static function tableName()
    {
        return 'laporan'; // Pastikan ini sesuai dengan nama tabel di database
    }

    public function rules()
{
    return [
        [['tanggal', 'kode_kelas', 'kode_mapel', 'status', 'waktupresensi'], 'required'],
        [['tanggal', 'waktupresensi'], 'safe'], // Pastikan ini ditangani dengan benar
        // Tambahkan aturan validasi lain yang diperlukan
    ];
}


    // Metode tambahan jika diperlukan
}
