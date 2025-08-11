<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ], [
            'username.required' => 'Email wajib diisi',
            'password.required' => 'Password wajib diisi',
        ]);

        $infoLogin = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($infoLogin)) {
            $user = Auth::user();
            $userRole = $user->role;
            $mahasiswa = $user->mahasiswa;

            // Periksa apakah data mahasiswa masih null pada kolom tertentu
            if (
                $userRole == 'mahasiswa' && (
                is_null($mahasiswa->email) ||
                is_null($mahasiswa->alamat) ||
                is_null($mahasiswa->kabkota) ||
                is_null($mahasiswa->provinsi) ||
                is_null($mahasiswa->notelp) ||
                is_null($mahasiswa->jalurmasuk) ||
                is_null($mahasiswa->foto))
            ) {
                return redirect('/editprofile/mahasiswa');
            } else {
                return redirect("dashboard/$userRole");
            }
        } else {
            return redirect('')->with('LoginError', 'Email dan 
            password yang dimasukkan tidak sesuai')->withInput();
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('');
    }
}
