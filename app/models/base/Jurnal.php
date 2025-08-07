<?php

namespace app\models\base;

use Yii;
use yii\db\ActiveRecord;

class Jurnal extends ActiveRecord
{
    public $isaktif;
    public $keterangan;
    public $kode_jurusan;

    public static function tableName()
    {
        return 'jurnal';
    }

    public static function primaryKey()
    {
        return ['jurnal_id'];
    }

    public function rules()
    {
        return [
            [['guru_id', 'kode_jurusan', 'kodeta', 'tanggal', 'hari_id', 'jam_ke', 'kode_kelas', 'kode_mapel', 'status'], 'required'],
            [['jurnal_id', 'jam_ke', 'hari_id'], 'integer'],
            [['jam_ke'], 'integer', 'min' => 1, 'max' => 12],
            [['hari_id'], 'integer', 'min' => 1],

            [['guru_id'], 'string', 'max' => 36],
            [['kodeta', 'kode_kelas', 'kode_mapel'], 'string', 'max' => 50],
            [['status'], 'string', 'max' => 20],
            [['kode_jurusan'], 'string', 'max' => 20],
            [['materi'], 'string', 'max' => 1000],
            [['keterangan'], 'string'],

            [['tanggal'], 'date', 'format' => 'php:Y-m-d'],

            [['jam_mulai', 'jam_selesai'], 'match', 'pattern' => '/^([01]?[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?$/', 'message' => 'Format jam harus HH:MM atau HH:MM:SS', 'skipOnEmpty' => true],
            ['jam_selesai', 'validateJamSelesai'],

            [['waktupresensi'], 'safe'],
            [['isaktif'], 'boolean'],

            [['status'], 'in', 'range' => ['HADIR', 'ALPA', 'IZIN', 'SAKIT'], 'skipOnEmpty' => false],

            [['hari_id'], 'exist', 'targetClass' => Hari::class, 'targetAttribute' => 'hari_id'],
            [['guru_id'], 'exist', 'targetClass' => Guru::class, 'targetAttribute' => 'guru_id'],
            [['kode_jurusan'], 'exist', 'targetClass' => Jurusan::class, 'targetAttribute' => 'kode_jurusan'],
            [['kodeta'], 'exist', 'targetClass' => Tahunajaran::class, 'targetAttribute' => 'kodeta'],
            [['kode_kelas'], 'exist', 'targetClass' => Kelas::class, 'targetAttribute' => 'kode_kelas'],
            [['kode_mapel'], 'exist', 'targetClass' => Mapel::class, 'targetAttribute' => 'kode_mapel'],

            [['materi'], 'filter', 'filter' => fn($v) => trim((string) $v)],
            [['keterangan'], 'filter', 'filter' => fn($v) => trim((string) $v)],
        ];
    }

    public function validateJamSelesai($attribute, $params)
    {
        if (!empty($this->jam_mulai) && !empty($this->jam_selesai)) {
            $jamMulai = strtotime($this->jam_mulai);
            $jamSelesai = strtotime($this->jam_selesai);

            if ($jamSelesai === false || $jamMulai === false) {
                $this->addError($attribute, 'Format jam tidak valid');
                return;
            }

            if ($jamSelesai <= $jamMulai) {
                $this->addError($attribute, 'Jam selesai harus lebih besar dari jam mulai');
            }
        }
    }

    public function attributeLabels()
    {
        return [
            'jurnal_id' => 'ID',
            'guru_id' => 'Guru',
            'kode_jurusan' => 'Jurusan',
            'kodeta' => 'Tahun Ajaran',
            'tanggal' => 'Tanggal',
            'hari_id' => 'Hari',
            'jam_ke' => 'Jam Ke',
            'jam_mulai' => 'Jam Mulai',
            'jam_selesai' => 'Jam Selesai',
            'kode_kelas' => 'Kelas',
            'kode_mapel' => 'Mata Pelajaran',
            'materi' => 'Materi Pembelajaran',
            'keterangan' => 'Keterangan',
            'status' => 'Status',
            'waktupresensi' => 'Waktu Presensi',
            'isaktif' => 'Aktif',
        ];
    }

    public function getGuru()
    {
        return $this->hasOne(Guru::class, ['guru_id' => 'guru_id']);
    }

    public function getJurusan()
    {
        return $this->hasOne(Jurusan::class, ['jurusan_id' => 'kode_jurusan']);
    }

    public function getHari()
    {
        return $this->hasOne(Hari::class, ['hari_id' => 'hari_id']);
    }

    public function getKodeta0()
    {
        return $this->hasOne(Tahunajaran::class, ['kodeta' => 'kodeta']);
    }

    public function getKodeKelas()
    {
        return $this->hasOne(Kelas::class, ['kode_kelas' => 'kode_kelas']);
    }

    public function getKodeMapel()
    {
        return $this->hasOne(Mapel::class, ['kode_mapel' => 'kode_mapel']);
    }

    public function getJurnalDetils()
    {
        return $this->hasMany(JurnalDetil::class, ['jurnal_id' => 'jurnal_id']);
    }

    public function getNis0()
    {
        return $this->hasOne(\app\models\Siswa::class, ['nis' => 'nis']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            if (!empty($this->waktupresensi) && $this->waktupresensi !== 'N/A') {
                $converted = $this->convertWaktuPresensi($this->waktupresensi);
                $this->waktupresensi = $converted !== false ? $converted : date('Y-m-d H:i:s');
            }

            if ($insert && (empty($this->waktupresensi) || $this->waktupresensi === 'N/A')) {
                $this->waktupresensi = date('Y-m-d H:i:s');
            }

            if (!empty($this->jam_mulai) && preg_match('/^\d{2}:\d{2}$/', $this->jam_mulai)) {
                $this->jam_mulai .= ':00';
            }
            if (!empty($this->jam_selesai) && preg_match('/^\d{2}:\d{2}$/', $this->jam_selesai)) {
                $this->jam_selesai .= ':00';
            }

            if ($this->status === 'Pilih Status Kehadiran' && empty(trim((string) $this->materi))) {
                $this->addError('materi', 'Materi pembelajaran harus diisi ketika status HADIR.');
                return false;
            }

            return true;
        }
        return false;
    }

    private function convertWaktuPresensi($waktu)
    {
        try {
            if (preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}(:\d{2})?$/', $waktu)) {
                return $waktu;
            }

            if (preg_match('/^(\d{2})\/(\d{2})\/(\d{4}) (\d{2}):(\d{2})$/', $waktu, $m)) {
                [$dd, $mm, $yyyy, $hh, $ii] = array_slice($m, 1);
                if (!checkdate($mm, $dd, $yyyy)) return false;
                return "$yyyy-$mm-$dd $hh:$ii:00";
            }

            return false;
        } catch (\Exception $e) {
            Yii::error("Date conversion error: " . $e->getMessage(), __METHOD__);
            return false;
        }
    }

    public function getFormattedWaktuPresensi()
    {
        if (!empty($this->waktupresensi)) {
            try {
                $dt = new \DateTime($this->waktupresensi);
                return $dt->format('d/m/Y H:i');
            } catch (\Exception $e) {
                Yii::error("Date formatting error: " . $e->getMessage(), __METHOD__);
                return $this->waktupresensi;
            }
        }
        return '';
    }

    public function afterFind()
    {
        parent::afterFind();
    }
}
