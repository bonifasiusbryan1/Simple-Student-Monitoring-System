<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DepartemenController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $departemen = $user->departemen;
        return view('dashboard/departemen', compact('user','departemen'), ['page' => 'dashboard']);
    }

    public function profile()
    {
        $user = Auth::user();
        $departemen = $user->departemen;
        return view('profile/profile/departemen', compact('user','departemen'), ['page' => 'profile']);
    }

    public function editprofile()
    {
        $user = Auth::user();
        $departemen = $user->departemen;
        return view('profile/editprofile/departemen', compact('user','departemen'), ['page' => 'profile']);
    }

    public function saveprofile(Request $request)
    {
        $user = Auth::user();
        $departemen = $user->departemen;

        $request->validate([
            'nama'=>'required',
            'email'=>'required|email',
            'alamat'=>'required',
            'notelp'=>'required|regex:/^\d{1,12}$/',
            'kabkota' => 'required',
            'provinsi'=>'required',
            'foto' => $departemen->foto ? 'nullable|image|mimes:jpeg,png,jpg|max:2048' : 'required|image|mimes:jpeg,png,jpg|max:2048',
        ],[
            'nama.required'=>'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Email harus sesuai format',
            'alamat.required' => 'Alamat wajib diisi',
            'notelp.required' => 'Nomor Telepon wajib diisi',
            'notelp.required' => 'Nomor Telepon terdiri dari 12 angka',
            'kabkota.required'=>'Kabupaten/Kota wajib diisi',
            'provinsi.required'=>'Provinsi wajib diisi',
            'foto.required'=>'Foto wajib diisi',
            'foto.image' => 'Foto harus berupa gambar',
            'foto.mimes' => 'Format foto berupa jpeg, png, jpg',
            'foto.max' => 'Ukuran foto tidak boleh lebih dari 2 MB',
        ]);

        $updateData = [
            'nama' => $request->nama,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'kabkota'=> $request->kabkota,
            'provinsi' => $request->provinsi,
            'notelp' => $request->notelp,
        ];

        if ($request->hasFile('foto')) {
            if ($departemen->foto) {
                $fotoLama = 'asset/fotoprofile/departemen/'.$departemen->foto;
                if (file_exists($fotoLama)) {
                    //hapus foto lama
                    unlink($fotoLama);
                }
            }
        
            // simpan foto baru
            $fotoBaru = $request->file('foto')->getClientOriginalName();
            $request->file('foto')->move('asset/fotoprofile/departemen/', $fotoBaru);
        
            // Menyimpan nama foto baru ke dalam data yang akan diupdate
            $updateData['foto'] = $fotoBaru;
        }

        DB::table('departemen')->where('nip', $user->username)->update($updateData);

        return redirect('/profile/departemen')->with('success', 'Profile Akun Berhasil diperbaharui');
    }
}
