<?php

namespace App\Http\Controllers;

use App\Imports\MahasiswaImport;
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
use Maatwebsite\Excel\Facades\Excel;

class OperatorController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $operator = $user->operator;
        return view('dashboard/operator', compact('user','operator'), ['page' => 'dashboard']); 
    }

    public function resetPassword($nim)
    {
        
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();

        // Reset password ke nilai default
        $newPassword = Hash::make('12345');

        // Update password dalam tabel pengguna
        $mahasiswa->update(['password' => $newPassword]);

        return redirect('/generate/akunmahasiswa')->with('success', 'Password berhasil direset');
    }

    public function deleteAkun($nim)
    {
        $mhs = Mahasiswa::where('nim', $nim)->first();
        $user = User::where('username', $mhs->nim)->first();
        $irs = IRS::where('nim', $nim);
        $khs = KHS::where('nim', $nim);
        $pkl = PKL::where('nim', $nim);
        $skripsi = Skripsi::where('nim', $nim);

        if ($mhs && $user) {
            $mhs->delete();
            $user->delete();
            $irs->delete();
            $khs->delete();
            $pkl->delete();
            $skripsi->delete();

            return redirect('/generate/akunmahasiswa')->with('success', 'Akun mahasiswa berhasil dihapus');
        } else {
            return redirect('generate/akunmahasiswa')->with('error', 'Gagal menghapus akun mahasiswa. Mahasiswa tidak ditemukan');
        }
    }

    public function carimahasiswa(Request $request)
    {
        $user = Auth::user();
        $operator = $user->operator;

        $query = Mahasiswa::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nim', 'LIKE', '%' . $search . '%')
                    ->orWhere('nama', 'LIKE', '%' . $search . '%')
                    ->orWhere('angkatan', 'LIKE', '%' . $search . '%')
                    ->orWhere('dosenwali', 'LIKE', '%' . $search . '%');
            });
            $mahasiswa = $query->get();
        } else{
            $mahasiswa = Mahasiswa::all();
        }
        return view('generate/akunmahasiswa', compact('user','mahasiswa','operator'));
    }

    public function profile()
    {
        $user = Auth::user();
        $operator = $user->operator;
        return view('profile/profile/operator', compact('user','operator'), ['page' => 'profile']);
    }

    public function editprofile()
    {
        $user = Auth::user();
        $operator = $user->operator;
        return view('profile/editprofile/operator', compact('user','operator'), ['page'=> 'profile']);
    }

    public function saveprofile(Request $request)
    {
        $user = Auth::user();
        $operator = $user->operator;

        $request->validate([
            'nama'=>'required',
            'email'=>'required|email',
            'alamat'=>'required',
            'notelp'=>'required|regex:/^\d{1,12}$/',
            'kabkota' => 'required',
            'provinsi'=>'required',
            'foto' => $operator->foto ? 'nullable|image|mimes:jpeg,png,jpg|max:2048' : 'required|image|mimes:jpeg,png,jpg|max:2048',
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
            if ($operator->foto) {
                $fotoLama = 'asset/fotoprofile/operator/'.$operator->foto;
                if (file_exists($fotoLama)) {
                    //hapus foto lama
                    unlink($fotoLama);
                }
            }
        
            // simpan foto baru
            $fotoBaru = $request->file('foto')->getClientOriginalName();
            $request->file('foto')->move('asset/fotoprofile/operator/', $fotoBaru);
        
            // Menyimpan nama foto baru ke dalam data yang akan diupdate
            $updateData['foto'] = $fotoBaru;
        }

        DB::table('operator')->where('nip', $user->username)->update($updateData);
    
        return redirect('/profile/operator')->with('success', 'Profile Akun Berhasil diperbaharui');
    }

    public function entryprogresstudi()
    {
        $user = Auth::user();
        $operator = $user->operator;
        $mahasiswa = Mahasiswa::orderByDesc('angkatan')->get();
        $khs = KHS::all();

        foreach ($mahasiswa as $mhs) {
            $nim = $mhs->nim;
    
            $semesterPKL[$nim] = [];
            $semesterSkripsi[$nim] = [];
            $semesterAktif = $mhs->getSemesterAktif();

            for ($semester = 1; $semester <= $semesterAktif; $semester++) {
                $semesterList[$nim][] = $semester;
            }

            for ($semester = 5; $semester <= $semesterAktif; $semester++) {
                $semesterPKL[$nim][] = $semester;
            }
    
            foreach ($khs as $nilai) {
                if ($nilai->nim === $nim && $nilai->sksk >= 120) {
                    $semesterSkripsi[$nim][] = $nilai->semester;
                }
            }
        }

        return view('progresstudi/entry', compact('user','mahasiswa', 'operator', 'semesterList', 'semesterPKL', 'semesterSkripsi'), ['page' => 'entry']);
    }

    public function entryirs($nim)
    {
        $user = Auth::user();
        $operator = $user->operator;
        $mahasiswa = Mahasiswa::where('nim', $nim)->orderByDesc('angkatan')->first();
        $semesterAktif = $mahasiswa->getSemesterAktif();
        $irs = IRS::where('nim', $nim)->get();
        $khs = KHS::where('nim', $nim)->get();

        $semesterPKL = [];

        for ($semester = 5; $semester <= $semesterAktif; $semester++) {
            $semesterPKL[] = $semester;
        }

        $semesterSkripsi = [];
    
        foreach ($khs as $nilai) {
            if ($nilai->sksk >= 120) {
                $semesterSkripsi[] = $nilai->semester;
            }
        }

        return view('irs/entryirs', compact('user','mahasiswa','irs', 'operator', 'semesterAktif', 'semesterPKL', 'semesterSkripsi'), ['page' => 'entryirs']);
    }

    public function entrysaveirs(Request $request, $nim)
    {
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();

        $request->validate([
            'semester' => 'required',
            'jmlsks' => 'required|numeric',
            'fileirs' => 'required|file',
        ], [
            'semester.required' => 'Semester wajib dipilih',
            'jmlsks.required' => 'Jumlah SKS wajib diisi',
            'jmlsks.numeric' => 'Jumlah SKS berupa angka',
            'fileirs.required' => 'Bukti IRS wajib diupload',
            'fileirs.file' => 'Bukti IRS harus berupa file',
        ]);

        // Cek apakah IRS untuk semester tertentu sudah ada
        $existingIRS = IRS::where('nim', $mahasiswa->nim)
            ->where('semester', $request->semester)
            ->first();

        // Jika IRS sudah ada, hapus file lama
        if ($existingIRS) {
            $fileLama = 'public/irs/' . $existingIRS->fileirs;
            if (Storage::exists($fileLama)) {
                Storage::delete($fileLama);
            }
        }

        // Simpan file baru dengan nama unik
        $fileirs = $request->file('fileirs')->getClientOriginalName();
        $fileirsName = $fileirs . time() . '_' . uniqid() . '.' . $request->file('fileirs')->getClientOriginalExtension();

        // Pindahkan file ke direktori penyimpanan dengan nama unik
        $request->file('fileirs')->storeAs('public/irs', $fileirsName);

        $datairs = [
            'jumlahsks' => $request->jmlsks,
            'fileirs' => $fileirsName,
            'status' => '1',
        ];

        IRS::updateOrInsert(
            [
                'nim' => $mahasiswa->nim,
                'semester' => $request->semester,
            ],
            $datairs
        );

        return redirect('/entry/irs/'.$nim)->with('success', 'Berhasil Upload IRS Mahasiswa');
    }

    public function entrykhs($nim)
    {
        $user = Auth::user();
        $operator = $user->operator;
        $mahasiswa = Mahasiswa::where('nim', $nim)->orderByDesc('angkatan')->first();
        $semesterAktif = $mahasiswa->getSemesterAktif();
        $khs = KHS::where('nim', $nim)->get();

        $semesterPKL = [];

        for ($semester = 5; $semester <= $semesterAktif; $semester++) {
            $semesterPKL[] = $semester;
        }

        $semesterSkripsi = [];
    
        foreach ($khs as $nilai) {
            if ($nilai->sksk >= 120) {
                $semesterSkripsi[] = $nilai->semester;
            }
        }

        return view('khs/entrykhs', compact('user','mahasiswa', 'khs', 'operator', 'semesterAktif', 'semesterPKL', 'semesterSkripsi'), ['page' => 'entrykhs']);
    }

    public function entrysavekhs(Request $request, $nim)
    {
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();

        $request->validate([
            'semester' => 'required',
            'skss' => 'required|numeric',
            'sksk' => 'required|numeric',
            'ips' => 'required|regex:/^\d+\.\d{2}$/',
            'ipk' => 'required|regex:/^\d+\.\d{2}$/',
            'filekhs' => 'required|file',
        ], [
            'semester.required' => 'Semester wajib dipilih',
            'skss.required' => 'Jumlah SKS Semester wajib diisi',
            'skss.numeric' => 'Jumlah SKS Semester berupa angka',
            'sksk.required' => 'Jumlah SKS Kumulatif wajib diisi',
            'sksk.numeric' => 'Jumlah SKS Kumulatif berupa angka',
            'ips.required' => 'Nilai IP harus diisi',
            'ips.regex' => 'Nilai IP harus sesuai format : x.yz (4.00)',
            'ipk.required' => 'Nilai IP harus diisi',
            'ipk.regex' => 'Nilai IP harus sesuai format : x.yz (4.00)',
            'filekhs.required' => 'Bukti KHS wajib diupload',
            'filekhs.file' => 'Bukti KHS harus berupa file',
        ]);

        // Cek apakah KHS untuk semester tertentu sudah ada
        $existingKHS = KHS::where('nim', $mahasiswa->nim)
            ->where('semester', $request->semester)
            ->first();

        // Jika KHS sudah ada, hapus file lama
        if ($existingKHS) {
            $fileLama = 'public/khs/' . $existingKHS->filekhs;
            if (Storage::exists($fileLama)) {
                Storage::delete($fileLama);
            }
        }

        // Simpan file baru dengan nama unik
        $filekhs = $request->file('filekhs')->getClientOriginalName();
        $filekhsName = $filekhs . time() . '_' . uniqid() . '.' . $request->file('filekhs')->getClientOriginalExtension();

        // Pindahkan file ke direktori penyimpanan dengan nama unik
        $request->file('filekhs')->storeAs('public/khs', $filekhsName);

        $datakhs = [
            'skss' => $request->skss,
            'sksk' => $request->sksk,
            'ips' => $request->ips,
            'ipk' => $request->ipk,
            'status' => '1',
            'filekhs' => $filekhsName,
        ];

        KHS::updateOrInsert(
            [
                'nim' => $mahasiswa->nim,
                'semester' => $request->semester,
            ],
            $datakhs
        );

        return redirect('/entry/khs/'.$nim)->with('success', 'Berhasil Upload KHS Mahasiswa');
    }

    public function entrypkl($nim)
    {
        $user = Auth::user();
        $operator = $user->operator;
        $mahasiswa = Mahasiswa::where('nim', $nim)->orderByDesc('angkatan')->first();
        $semesterAktif = $mahasiswa->getSemesterAktif();
        $pkl = PKL::where('nim', $nim)->first();
        $khs = KHS::where('nim', $nim)->get();

        $semesterPKL = [];

        for ($semester = 5; $semester <= $semesterAktif; $semester++) {
            $semesterPKL[] = $semester;
        }

        $semesterSkripsi = [];
    
        foreach ($khs as $nilai) {
            if ($nilai->sksk >= 120) {
                $semesterSkripsi[] = $nilai->semester;
            }
        }

        return view('pkl/entrypkl', compact('user','mahasiswa', 'pkl', 'operator', 'semesterAktif', 'semesterPKL', 'semesterSkripsi'), ['page' => 'entrypkl']);
    }

    public function entrysavepkl(Request $request, $nim)
    {
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();

        $request->validate([
            'semester' => 'required',
            'nilai' => 'required',
            'filepkl' => 'required|file',
        ],[
            'semester.required' => 'Semester wajib dipilih',
            'nilai.required' => 'Nilai PKL wajib diisi',
            'filepkl.required' => 'Wajib upload File PKL',
            'filepkl.file' => 'Bukti PKL harus berupa file',
        ]);

        // Cek apakah PKL untuk semester tertentu sudah ada
        $existingPKL = PKL::where('nim', $mahasiswa->nim)->first();;

        // Jika PKL sudah ada, hapus file lama
        if ($existingPKL) {
            $fileLama = 'public/pkl/' . $existingPKL->filepkl;
            if (Storage::exists($fileLama)) {
                Storage::delete($fileLama);
            }
        }

        // Simpan file baru dengan nama unik
        $filepkl = $request->file('filepkl')->getClientOriginalName();
        $filepklName = $filepkl . time() . '_' . uniqid() . '.' . $request->file('filepkl')->getClientOriginalExtension();

        // Pindahkan file ke direktori penyimpanan dengan nama unik
        $request->file('filepkl')->storeAs('public/pkl', $filepklName);

        $datapkl = [
            'semester' => $request->semester,
            'nilai' => $request->nilai,
            'filepkl' => $filepklName,
            'status' => '1',
        ];
        
        PKL::updateOrInsert(
            [
                'nim' => $mahasiswa->nim,
            ],
            $datapkl
        );
        return redirect('/entry/pkl/'.$nim)->with('success', 'Berhasil Upload PKL Mahasiswa');
    }

    public function entryskripsi($nim)
    {
        $user = Auth::user();
        $operator = $user->operator;
        $mahasiswa = Mahasiswa::where('nim', $nim)->orderByDesc('angkatan')->first();
        $semesterAktif = $mahasiswa->getSemesterAktif();
        $skripsi = Skripsi::where('nim', $nim)->first();
        $khs = KHS::where('nim', $nim)->get();

        $semesterPKL = [];

        for ($semester = 5; $semester <= $semesterAktif; $semester++) {
            $semesterPKL[] = $semester;
        }

        $semesterSkripsi = [];
    
        foreach ($khs as $nilai) {
            if ($nilai->sksk >= 120) {
                $semesterSkripsi[] = $nilai->semester;
            }
        }

        return view('skripsi/entryskripsi', compact('user','mahasiswa', 'operator','skripsi', 'semesterAktif', 'semesterPKL', 'semesterSkripsi'), ['page' => 'skripsi']);
    }

    public function saveskripsi(Request $request, $nim)
    {
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();

        $request->validate([
            'semester' => 'required',
            'nilai' => 'required',
            'tglsidang' => 'required',
            'fileskripsi' => 'required|file',
        ],[
            'semester.required' => 'Semester wajib dipilih',
            'nilai.required' => 'Nilai Skripsi wajib diisi',
            'tglsidang.required' => 'Tanggal Sidang Skripsi wajib diisi',            
            'fileskripsi.required' => 'Wajib upload File Skripsi',
            'fileskripsi.file' => 'Bukti Skripsi harus berupa file',
        ]);

        // Cek apakah Skripsi untuk semester tertentu sudah ada
        $existingSkripsi = Skripsi::where('nim', $mahasiswa->nim)->first();;

        // Jika Skripsi sudah ada, hapus file lama
        if ($existingSkripsi) {
            $fileLama = 'public/Skripsi/' . $existingSkripsi->fileSkripsi;
            if (Storage::exists($fileLama)) {
                Storage::delete($fileLama);
            }
        }

        // Simpan file baru dengan nama unik
        $fileSkripsi = $request->file('fileskripsi')->getClientOriginalName();
        $fileSkripsiName = $fileSkripsi . time() . '_' . uniqid() . '.' . $request->file('fileskripsi')->getClientOriginalExtension();

        // Pindahkan file ke direktori penyimpanan dengan nama unik
        $request->file('fileskripsi')->storeAs('public/skripsi', $fileSkripsiName);

        $dataSkripsi = [
            'semester' => $request->semester,
            'nilai' => $request->nilai,
            'tglsidang' => $request->tglsidang,
            'fileskripsi' => $fileSkripsiName,
            'status'=>'1',
        ];
        
        Skripsi::updateOrInsert(
            [
                'nim' => $mahasiswa->nim,
            ],
            $dataSkripsi
        );
        return redirect('/entry/skripsi/'.$nim)->with('success', 'Berhasil Upload Skripsi Mahasiswa');
    }

    public function generateakun()
    {
        $user = Auth::user();
        $operator = $user->operator;

        $mahasiswa = Mahasiswa::orderByDesc('angkatan')->get();
        
        return view('generate/akunmahasiswa', compact('user','mahasiswa', 'operator'), ['page' => 'generate']);
    }
    

    public function generatesatuakun(Request $request)
    {

        $request->validate([
            'nama'=>'required',
            'nim'=>'required|unique:mahasiswa,nim',
            'angkatan'=>'required',
            'dosenwali' => 'required',
        ],[
            'nama.required'=>'Nama wajib diisi',
            'nim.required' => 'NIM wajib diisi',
            'nim.unique' => 'NIM sudah tersedia',
            'angkatan.required' => 'Angkatan wajib diisi',
            'dosenwali.required' => 'Dosen Wali wajib diisi',
        ]);

        $datamhs = [
            'nim' => $request->nim,
            'nama' => $request->nama,
            'dosenwali' => $request->dosenwali,
            'angkatan' => $request->angkatan,
            'status' => 'aktif',
        ];

        DB::table('mahasiswa')->insert($datamhs);

        DB::table('users')->insert([
            'username' => $request->nim,
            'password' => Hash::make('12345'),
        ]);

        return redirect('generate/akunmahasiswa')->with('success', 'Akun mahasiswa berhasil digenerate');
    }

    public function generatesemuaakun(Request $request)
    {
        $data = $request->file('akunmhs');

        $namafile = $data->getClientOriginalName();
        $data->move('excel/akunmahasiswa/', $namafile);

        Excel::import(new MahasiswaImport, \public_path('excel/akunmahasiswa/'.$namafile));

        unlink(public_path('excel/akunmahasiswa/'.$namafile));

        return redirect('generate/akunmahasiswa')->with('success', 'Berhasil generate semua akun mahasiswa');;
    }
    
    public function exportExcel()
    {
        $filePath = storage_path('app\public\excel\format\formatakunmhs.xlsx');

        return response()->download($filePath);
    }

    public function op_profile($nim)
    {
        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();
        $operator = $user->operator;
        
        return view('profile/profile/mahasiswa', compact('user','mahasiswa','operator'), ['page' => 'profile']);
    }

    public function op_editprofile($nim)
    {
        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();
        $mahasiswaBaru = null;
        $operator = $user->operator;

        return view('profile/editprofile/mahasiswa', compact('user','mahasiswa', 'mahasiswaBaru','operator'), ['page' => 'profile']);
    }

    public function op_saveprofile(Request $request, $nim)
    {
        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();

        $request->validate([
            'nama'=>'required',
            'email'=>'required|email',
            'dosenwali' => 'required',
            'angkatan' => 'required|regex:/^\d{4}$/',
            'alamat'=>'required',
            'notelp'=>'required|regex:/^\d{1,12}$/',
            'provinsi'=>'required',
            'kabkota' => 'required',
            'jalurmasuk' =>'required',
            'status' => 'required',
            'foto' => $mahasiswa->foto ? 'nullable|image|mimes:jpeg,png,jpg|max:2048' : 'required|image|mimes:jpeg,png,jpg|max:2048',
        ],[
            'nama.required'=>'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Email harus sesuai format',
            'dosenwali.required' => 'Dosen Wali wajib dipilih',
            'angkatan.required' => 'Angkatan wajib diisi',
            'angkatan.regex' => 'Angkatan terdiri dari 4 angka (ex: 2020)',
            'alamat.required' => 'Alamat wajib diisi',
            'notelp.required' => 'Nomor Telepon wajib diisi',
            'notelp.regex' => 'Nomor Telepon terdiri dari 12 angka',
            'kabkota.required'=>'Kabupaten/Kota wajib diisi',
            'provinsi.required'=>'Provinsi wajib diisi',
            'jalurmasuk.required' => 'Jalur Masuk wajib diisi',
            'status.required'=>'Status wajib diisi',
            'foto.required'=>'Foto wajib diisi',
            'foto.image' => 'Foto harus berupa gambar',
            'foto.mimes' => 'Format foto berupa jpeg, png, jpg',
            'foto.max' => 'Ukuran foto tidak boleh lebih dari 2 MB',
        ]);

        $updateData = [
            'nama' => $request->nama,
            'email' => $request->email,
            'dosenwali' => $request->dosenwali,
            'angkatan' => $request->angkatan,
            'alamat' => $request->alamat,
            'kabkota'=> $request->kabkota,
            'provinsi' => $request->provinsi,
            'jalurmasuk' => $request->jalurmasuk,
            'status' => $request->status,
            'notelp' => $request->notelp,
        ];
    
        if ($request->hasFile('foto')) {
            if ($mahasiswa->foto) {
                $fotoLama = 'asset/fotoprofile/mahasiswa/'.$mahasiswa->foto;
                if (file_exists($fotoLama)) {
                    //hapus foto lama
                    unlink($fotoLama);
                }
            }
        
            // simpan foto baru
            $fotoBaru = $request->file('foto')->getClientOriginalName();
            $request->file('foto')->move('asset/fotoprofile/mahasiswa/', $fotoBaru);
        
            // Menyimpan nama foto baru ke dalam data yang akan diupdate
            $updateData['foto'] = $fotoBaru;
        }
    
        $updatePassword = [];
        if ($request->has('password')) {
            if (password_verify($request->password, $user->password)) {
                $updatePassword['password'] = Hash::make($request->passwordbaru);
            } else {
                return redirect()
                        ->back()
                        ->withInput($request->all())
                        ->with('error', 'Password tidak sesuai.');
            }
        }

        if (!empty($updatePassword)) {
            DB::table('users')->where('username', $mahasiswa->nim)->update($updatePassword);
        }

        DB::table('mahasiswa')->where('nim', $user->username)->update($updateData);
    
        return redirect('/profile/mahasiswa/'. $nim)->with('success', 'Profile Akun Berhasil diperbaharui.');
    }

}
