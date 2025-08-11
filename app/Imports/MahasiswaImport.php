<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;

class MahasiswaImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Simpan data ke tabel 'users'
        $user = new User([
            'username' => $row[0],
            'password' => Hash::make('12345'),
        ]);
        $user->save();

        // Simpan data ke tabel 'mahasiswa'
        $mahasiswa = new Mahasiswa([
            'nim' => $row[0],
            'nama' => $row[1],
            'angkatan' =>$row[2],
            'dosenwali' =>$row[3],
        ]);
        $mahasiswa->save();

        return $user;
    }
}
