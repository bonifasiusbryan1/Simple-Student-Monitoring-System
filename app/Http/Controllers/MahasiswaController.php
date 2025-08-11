<?php

namespace App\Http\Controllers;

use App\Models\IRS;
use App\Models\KHS;
use App\Models\Mahasiswa;
use App\Models\PKL;
use App\Models\Skripsi;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class MahasiswaController extends Controller
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
            return redirect('/editprofile/mahasiswa')->with('success', 'Lengkapi profile anda terlebih dahulu');
        }

        // Kondisi profil mahasiswa terpenuhi
        return null;
    }

    public function dashboard()
    {
        if ($redirect = $this->mahasiswaBaru()) {
            return $redirect;
        }

        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;
        $semesterAktif = $mahasiswa->getSemesterAktif();
        $irs = $user->irs;
        $khs = $user->khs;
        $pkl = $user->pkl;
        $skripsi = $user->skripsi;

        $semesterData = [];

        for ($i = 1; $i <= 14; $i++) {
            $irsData = $irs ? $irs->where('semester', $i)->first() : null;
            $khsData = $khs ? $khs->where('semester', $i)->first() : null;
            $pklData = $pkl ? $pkl->where('nim', $user->username)->where('semester', $i)->where('status', '1')->where('status_pkl', 'lulus')->first() : null;
            $skripsiData = $skripsi ? $skripsi->where('nim', $user->username)->where('semester', $i)->where('status', '1')->where('status_skripsi', 'lulus')->first() : null;

            if ($irsData && !$khsData && !$pklData && !$skripsiData){
                $class = 'bluelight';
            } else if ($irsData && $khsData && !$pklData && !$skripsiData){
                $class = 'blue';
            } else if ($irsData && $khsData && $pklData && !$skripsiData){
                $class = 'orange';
            } else if ($skripsiData){
                $class = 'green';
            } else{
                $class = 'red';
            }

            $semesterData[$i] = [
                'semester' => $i,
                'class' => $class,
            ];
        }

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
        
        return view('dashboard/mahasiswa', compact('user', 'mahasiswa', 'irs', 'khs', 'pkl', 'skripsi', 'semesterData', 'semesterPKL','semesterSkripsi', 'semesterAktif'));
    }

    public function profile()
    {
        if ($redirect = $this->mahasiswaBaru()) {
            return $redirect;
        }

        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;
        $khs = $user->khs;
        $semesterAktif = $mahasiswa->getSemesterAktif();

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

        
        return view('profile/profile/mahasiswa', compact('user','mahasiswa', 'semesterAktif', 'semesterPKL', 'semesterSkripsi'), ['page' => 'profile']);
    }

    public function editprofile()
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;
        $khs = $user->khs;
        $semesterAktif = $mahasiswa->getSemesterAktif();
        $mahasiswaBaru = $this->mahasiswaBaru() !== null;

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
    
        return view('profile/editprofile/mahasiswa', compact('user','mahasiswa', 'mahasiswaBaru', 'semesterAktif', 'semesterPKL', 'semesterSkripsi'), ['page' => 'profile']);
    }

    public function saveprofile(Request $request)
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;
        $mahasiswaBaru = $this->mahasiswaBaru() !== null;
        
        $request->validate([
            'nama'=>'required',
            'email'=>'required|email',
            'password'=>  $mahasiswaBaru ? 'required' : '',
            'passwordbaru'=>  $mahasiswaBaru ? 'required' : '',
            'alamat'=>'required',
            'notelp'=>'required|regex:/^\d{1,12}$/',
            'provinsi'=>'required',
            'kabkota' => 'required',
            'jalurmasuk' => $mahasiswa->jalurmasuk ? '' : 'required',
            'foto' => $mahasiswa->foto ? 'nullable|image|mimes:jpeg,png,jpg|max:2048' : 'required|image|mimes:jpeg,png,jpg|max:2048',
        ],[
            'nama.required'=>'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Email harus sesuai format',
            'password.required' => 'Password lama wajib diisi',
            'passwordbaru.required' => 'Password baru wajib diisi',
            'alamat.required' => 'Alamat wajib diisi',
            'notelp.required' => 'Nomor Telepon wajib diisi',
            'notelp.regex' => 'Nomor Telepon terdiri dari 12 angka',
            'kabkota.required'=>'Kabupaten/Kota wajib diisi',
            'provinsi.required'=>'Provinsi wajib diisi',
            'jalurmasuk.required' => 'Jalur Masuk wajib diisi',
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

        if ($request->has('jalurmasuk')) {
            $updateData['jalurmasuk'] = $request->jalurmasuk;
        }
    
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

        Mahasiswa::where('nim', $user->username)->update($updateData);
    
        return redirect('/profile/mahasiswa')->with('success', 'Profile Akun Berhasil diperbaharui');
        
    }

    public function editirs()
    {
        if ($redirect = $this->mahasiswaBaru()) {
            return $redirect;
        }

        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;
        $semesterAktif = $mahasiswa->getSemesterAktif();
        $irs = $user->irs;
        $khs = $user->khs;

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

        return view('irs/mahasiswa', compact('user','mahasiswa','irs', 'semesterAktif', 'semesterPKL', 'semesterSkripsi'), ['page' => 'irs']);
    }

    public function saveirs(Request $request)
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

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
            'status' => '0',
        ];

        IRS::updateOrInsert(
            [
                'nim' => $mahasiswa->nim,
                'semester' => $request->semester,
            ],
            $datairs
        );

        return redirect('/irs/mahasiswa')->with('success', 'Berhasil Upload IRS');
    }

    public function editkhs()
    {
        if ($redirect = $this->mahasiswaBaru()) {
            return $redirect;
        }

        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;
        $semesterAktif = $mahasiswa->getSemesterAktif();
        $khs = $user->khs;
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
        

        return view('khs/mahasiswa', compact('user','mahasiswa','khs', 'semesterAktif', 'semesterPKL', 'semesterSkripsi'), ['page' => 'khs']);
    }

    public function savekhs(Request $request)
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

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
            'status' => '0',
            'filekhs' => $filekhsName,
        ];

        KHS::updateOrInsert(
            [
                'nim' => $mahasiswa->nim,
                'semester' => $request->semester,
            ],
            $datakhs
        );

        return redirect('/khs/mahasiswa')->with('success', 'Berhasil Upload KHS');
    }


    public function editpkl()
    {
        if ($redirect = $this->mahasiswaBaru()) {
            return $redirect;
        }

        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;
        $semesterAktif = $mahasiswa->getSemesterAktif();
        $khs = $user->khs;
        $pkl = $user->pkl;

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

        return view('pkl/mahasiswa', compact('user','mahasiswa', 'pkl','semesterPKL', 'semesterAktif', 'semesterSkripsi'), ['page' => 'pkl']);
    }

    public function savepkl(Request $request)
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

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
        ];
        
        PKL::updateOrInsert(
            [
                'nim' => $mahasiswa->nim,
            ],
            $datapkl
        );
        return redirect('/pkl/mahasiswa')->with('success', 'Berhasil Upload PKL');
    }

    public function editskripsi()
    {
        if ($redirect = $this->mahasiswaBaru()) {
            return $redirect;
        }

        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;
        $semesterAktif = $mahasiswa->getSemesterAktif();
        $khs = $user->khs;
        $skripsi = $user->skripsi;

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

        return view('skripsi/mahasiswa', compact('user','mahasiswa','skripsi', 'semesterAktif', 'semesterPKL', 'semesterSkripsi'), ['page' => 'skripsi']);
    }

    public function saveskripsi(Request $request)
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

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
        ];
        
        Skripsi::updateOrInsert(
            [
                'nim' => $mahasiswa->nim,
            ],
            $dataSkripsi
        );
        return redirect('/skripsi/mahasiswa')->with('success', 'Berhasil Upload Skripsi');
    }
}
