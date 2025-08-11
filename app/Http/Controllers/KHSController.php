<?php

namespace App\Http\Controllers;

use App\Models\KHS;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KHSController extends Controller
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

    public function exportKHS($nim, $semester)
    {
        $khs = KHS::where('nim', $nim)
            ->where('semester', $semester)
            ->first();

        if ($khs) {
            $filePath = storage_path('app/public/khs/' . $khs->filekhs);

            return response()->download($filePath, $khs->filekhs);
        } else {
            return response()->json(['error' => 'File not found.'], 404);
        }
    }

    public function khs()
    {
        $user = Auth::user();
        $dosenwali = $user->dosenwali;
        $operator = $user->operator;
        $angkatanAktif = $this->getAngkatan();
        $mahasiswa = Mahasiswa::all();
        $khs = KHS::all();

        // Menggabungkan data mahasiswa dan KHS berdasarkan nim
        $data = collect($mahasiswa)->map(function ($mahasiswa) use ($khs, $user) {
            // Menyaring KHS berdasarkan nim
            $matchingKHS = $khs->filter(function ($item) use ($mahasiswa, $user) {
                if ($user->role == 'dosenwali') {
                    return $item['nim'] == $mahasiswa['nim'] && $mahasiswa['dosenwali'] == $user->dosenwali->nama;
                } elseif ($user->role == 'operator') {
                    return $item['nim'] == $mahasiswa['nim'];
                }
                return false;
            });

            return ['mahasiswa' => $mahasiswa, 'khs' => $matchingKHS];
        });

        return view('verifikasi/khs', compact('user', 'mahasiswa', 'dosenwali','operator', 'data', 'angkatanAktif', 'khs'), ['page' => 'khs']);
    }

    public function verifikasikhs($nim, $semester)
    {
        // Cari KHS berdasarkan nim dan semester
        $khs = KHS::where('nim', $nim)->where('semester', $semester)->first();

        if ($khs) {
            // Update status KHS menjadi 1
            KHS::where('nim', $nim)->where('semester', $semester)->update(['status' => '1']);

            return redirect()->back()->with('success', 'Verifikasi berhasil');
        } else {
            return redirect()->back()->with('error', 'KHS tidak ditemukan');
        }
    }

    public function batalverifikasikhs($nim, $semester)
    {
        // Cari KHS berdasarkan nim dan semester
        $khs = KHS::where('nim', $nim)->where('semester', $semester)->first();

        if ($khs) {
            // Update status KHS menjadi 1
            KHS::where('nim', $nim)->where('semester', $semester)->update(['status' => '0']);
            
            return redirect('/verifikasi/khs')->with('success', 'Verifikasi dibatalkan');
        } else {
            return redirect()->back()->with('error', 'KHS tidak ditemukan');
        }
    }

    public function verifikasieditkhs($nim, $semester)
    {

        $user = Auth::user();
        $dosenwali = $user->dosenwali;
        $operator = $user->operator;
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();
        $semesterAktif = $mahasiswa->getSemesterAktif();
        
        $khs = KHS::where('nim', $nim)->where('semester', $semester)->first();
        
        return view('verifikasi/editkhs', compact('user','mahasiswa','dosenwali','operator','khs','semesterAktif','semester'), ['page' => 'khs']);
    }

    public function verifikasisavekhs(Request $request, $nim)
    {
        $request->validate([
            'skss' => 'required|numeric',
            'sksk' => 'required|numeric',
            'ips' => 'required|regex:/^\d+\.\d{2}$/',
            'ipk' => 'required|regex:/^\d+\.\d{2}$/',
        ], [
            'skss.required' => 'Jumlah SKS Semester wajib diisi',
            'skss.numeric' => 'Jumlah SKS Semester berupa angka',
            'sksk.required' => 'Jumlah SKS Kumulatif wajib diisi',
            'sksk.numeric' => 'Jumlah SKS Kumulatif berupa angka',
            'ips.required' => 'Nilai IP harus diisi',
            'ips.regex' => 'Nilai IP harus sesuai format : x.yz (4.00)',
            'ipk.required' => 'Nilai IP harus diisi',
            'ipk.regex' => 'Nilai IP harus sesuai format : x.yz (4.00)',
        ]);

        $data = [
            'semester' => $request->semester,
            'skss' => $request->skss,
            'sksk' => $request->sksk,
            'ips' => $request->ips,
            'ipk' => $request->ipk,
            'status' => '1',
        ];
    
        KHS::updateOrInsert(
            ['nim' => $nim, 'semester' => $request->semester],
            $data
        );

        return redirect('/verifikasi/khs')->with('success', 'Perubahan KHS berhasil dilakukan');
    }
}
