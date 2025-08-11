<?php

namespace App\Http\Controllers;

use App\Models\IRS;
use App\Models\KHS;
use App\Models\Mahasiswa;
use App\Models\PKL;
use App\Models\Skripsi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private function mahasiswaBaru()
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        if (
            is_null($mahasiswa->email) ||
            is_null($mahasiswa->alamat) ||
            is_null($mahasiswa->kabkota) ||
            is_null($mahasiswa->provinsi) ||
            is_null($mahasiswa->notelp) ||
            is_null($mahasiswa->jalurmasuk) ||
            is_null($mahasiswa->foto)
        ) {
            return redirect('/editprofile/mahasiswa');
        }

        // Kondisi profil mahasiswa terpenuhi
        return null;
    }

    public function gantipassword()
    {
        $user = Auth::user();
        if ($user->role == 'mahasiswa'){
            if ($redirect = $this->mahasiswaBaru()) {
                return $redirect;
            }
        }
        
        $mahasiswa = $user->mahasiswa;
        $dosenwali = $user->dosenwali;
        $departemen = $user->departemen;
        $operator = $user->operator;
        if ($user->role == 'mahasiswa'){
            $khs = $user->mahasiswa;
            $semesterAktif = $mahasiswa->getSemesterAktif();
            $semesterPKL = [];
    
            for ($semester = 5; $semester <= $semesterAktif; $semester++) {
                $semesterPKL[] = $semester;
            }
    
            $semesterSkripsi = [];
            
            return view('password/index', compact('user', 'mahasiswa', 'dosenwali','departemen', 'operator', 'semesterSkripsi', 'semesterPKL', 'semesterAktif'), ['page'=>'']);

        } else {
            return view('password/index', compact('user', 'mahasiswa', 'dosenwali','departemen', 'operator'), ['page'=>'']);
        }


    }

    public function savepassword(Request $request) 
    {
        $user = Auth::user();

        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'passwordbaru' => 'required',
            'konfpasswordbaru' => 'required|same:passwordbaru',
        ], [
            'username.required' => 'Username wajib diisi',
            'password.required' => 'Password lama wajib diisi',
            'passwordbaru.required' => 'Password baru wajib diisi',
            'konfpasswordbaru.required' => 'Konfirmasi password baru wajib diisi',
            'konfpasswordbaru.same' => 'Password baru dan konfirmasi password baru harus sama',
        ]);

        if (password_verify($request->password, $user->password)) {
            $updateData = [
                'password' => Hash::make($request->passwordbaru),
            ];
            DB::table('users')->where('username', $request->username)->update($updateData);
    
            return redirect()
                    ->back()
                    ->with('success', 'Perubahan password berhasil dilakukan!!');
        } else {
            return redirect()
                    ->back()
                    ->withInput($request->all())
                    ->with('error', 'Password tidak sesuai.');
        }
    }

}
