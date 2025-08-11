<?php

namespace App\Http\Controllers;

use App\Models\IRS;
use App\Models\KHS;
use App\Models\Mahasiswa;
use App\Models\PKL;
use App\Models\Skripsi;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DosenWaliController extends Controller
{
    public function getAngkatan()
    {
        return $this->setAngkatan();
    }

    private function setAngkatan()
    {
        $thnSekarang = date('Y');
        $blnSekarang = date('n');
        $angkatanList = [];

        // Menghitung angkatan dengan selisih 7 tahun ke atas
        for ($i = 0; $i <= 6; $i++) {
            $angkatan = $thnSekarang - $i;
            $angkatanList[] = $angkatan;
        }

        // Jika bulan saat ini kurang dari 8, tambahkan satu tahun lagi
        if ($blnSekarang < 8) {
            $angkatanList[] = $thnSekarang - 7;
        }

        return $angkatanList;
    }


    public function dashboard()
    {
        $user = Auth::user();
        $dosenwali = $user->dosenwali;
        return view("dashboard/dosenwali", compact('user','dosenwali'), ['page' => 'dashboard']);
    }

    public function profile()
    {
        $user = Auth::user();
        $dosenwali = $user->dosenwali;
        return view('profile/profile/dosenwali', compact('user','dosenwali'), ['page' => 'profile']);
    }

    public function editprofile()
    {
        $user = Auth::user();
        $dosenwali = $user->dosenwali;
        return view('profile/editprofile/dosenwali', compact('user','dosenwali'), ['page' => 'profile']);
    }

    public function saveprofile(Request $request)
    {
        $user = Auth::user();
        $dosenwali = $user->dosenwali;

        $request->validate([
            'nama'=>'required',
            'email'=>'required|email',
            'alamat'=>'required',
            'notelp'=>'required|regex:/^\d{1,12}$/',
            'kabkota' => 'required', 
            'provinsi'=>'required',
            'foto' => $dosenwali->foto ? 'nullable|image|mimes:jpeg,png,jpg|max:2048' : 'required|image|mimes:jpeg,png,jpg|max:2048',
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
            if ($dosenwali->foto) {
                $fotoLama = 'asset/fotoprofile/dosenwali/'.$dosenwali->foto;
                if (file_exists($fotoLama)) {
                    //hapus foto lama
                    unlink($fotoLama);
                }
            }
        
            // simpan foto baru
            $fotoBaru = $request->file('foto')->getClientOriginalName();
            $request->file('foto')->move('asset/fotoprofile/dosenwali/', $fotoBaru);
        
            // Menyimpan nama foto baru ke dalam data yang akan diupdate
            $updateData['foto'] = $fotoBaru;
        }
        
        DB::table('dosenwali')->where('nip', $user->username)->update($updateData);

        return redirect('/profile/dosenwali')->with('success', 'Profile Akun Berhasil diperbaharui');

    }

    public function carimahasiswa(Request $request, $page)
    {
        $user = Auth::user();
        $dosenwali = $user->dosenwali;
        $angkatanAktif = $this->getAngkatan();
        $query = Mahasiswa::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nim', 'LIKE', '%' . $search . '%')
                    ->orWhere('nama', 'LIKE', '%' . $search . '%');
            });
        }

        $mahasiswa = $query->get();

        if ($page == 'irs'){
            $irs = IRS::all();

            $data = collect($mahasiswa)->map(function ($mahasiswa) use ($irs, $dosenwali) {
                $matchingIRS = $irs->filter(function ($item) use ($mahasiswa, $dosenwali) {
                    return $item['nim'] == $mahasiswa['nim'] && $mahasiswa['dosenwali'] == $dosenwali->nama;
                });

                return ['mahasiswa' => $mahasiswa, 'irs' => $matchingIRS];
            });
            
            return view('/verifikasi/irs', compact('user', 'mahasiswa', 'dosenwali', 'data', 'angkatanAktif', 'irs'), ['page' => 'irs']);
        } else if ($page == 'khs'){
            $khs = KHS::all();

            $data = collect($mahasiswa)->map(function ($mahasiswa) use ($khs, $dosenwali) {
                $matchingKHS = $khs->filter(function ($item) use ($mahasiswa, $dosenwali) {
                    return $item['nim'] == $mahasiswa['nim'] && $mahasiswa['dosenwali'] == $dosenwali->nama;
                });

                return ['mahasiswa' => $mahasiswa, 'khs' => $matchingKHS];
            });

            return view('/verifikasi/khs', compact('user', 'mahasiswa', 'dosenwali', 'data', 'angkatanAktif', 'khs'), ['page' => 'khs']);
        } else if ($page == 'pkl'){
            $pkl = PKL::all();

            $data = collect($mahasiswa)->map(function ($mahasiswa) use ($pkl, $dosenwali) {
                $matchingPKL = $pkl->filter(function ($item) use ($mahasiswa, $dosenwali) {
                    return $item['nim'] == $mahasiswa['nim'] && $mahasiswa['dosenwali'] == $dosenwali->nama;
                });

                return ['mahasiswa' => $mahasiswa, 'pkl' => $matchingPKL];
            });

            return view('/verifikasi/pkl', compact('user', 'mahasiswa', 'dosenwali', 'data', 'angkatanAktif', 'pkl'), ['page' => 'pkl']);
        } else if ($page == 'skripsi'){
            $skripsi = Skripsi::all();

            $data = collect($mahasiswa)->map(function ($mahasiswa) use ($skripsi, $dosenwali) {
                $matchingSkripsi = $skripsi->filter(function ($item) use ($mahasiswa, $dosenwali) {
                    return $item['nim'] == $mahasiswa['nim'] && $mahasiswa['dosenwali'] == $dosenwali->nama;
                });

                return ['mahasiswa' => $mahasiswa, 'skripsi' => $matchingSkripsi];
            });

            return view('/verifikasi/skripsi', compact('user', 'mahasiswa', 'dosenwali', 'data', 'angkatanAktif', 'skripsi'), ['page' => 'skripsi']);
        }
    }
}
