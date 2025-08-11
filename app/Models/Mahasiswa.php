<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Mahasiswa extends Model
{
    protected $table = 'mahasiswa';
    protected $primaryKey = 'nim';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'nim',
        'nama',
        'email',
        'alamat',
        'provinsi',
        'notelp',
        'angkatan',
        'status',
        'dosenwali',
        'foto',
    ];

    public function getSemesterAktif()
    {
        return $this->setSemesterAktif();
    }

    private function setSemesterAktif()
    {
        if ($this->status == 'lulus') {
            $skripsi = Skripsi::where('nim', $this->nim)->first();
            if ($skripsi){
                return $skripsi->semester;
            }
        } else{
            $tahunSekarang = date('Y');
            $bulanSekarang = date('n');
            $angkatan = $this->angkatan;
            $selisihTahun = $tahunSekarang - $angkatan;
            $semesterAktif = $selisihTahun * 2;

            if ($bulanSekarang >= 8) {
                $semesterAktif += 1;
            }
            
            return $semesterAktif;
        }
    }
}
