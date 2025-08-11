<?php

namespace App\Http\Controllers;

use App\Models\IRS;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IRSController extends Controller
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

    public function exportIRS($nim, $semester)
    {
        $irs = IRS::where('nim', $nim)
            ->where('semester', $semester)
            ->first();

        if ($irs) {
            $filePath = storage_path('app/public/irs/' . $irs->fileirs);

            return response()->download($filePath, $irs->fileirs);
        } else {
            return response()->json(['error' => 'File not found.'], 404);
        }
    }

    public function irs()
    {
        $user = Auth::user();
        $angkatanAktif = $this->getAngkatan();
        $operator = $user->operator;
        $dosenwali = $user->dosenwali; 
        $mahasiswa = Mahasiswa::all();
        $irs = IRS::all();

        // Menggabungkan data mahasiswa dan IRS berdasarkan nim
        $data = collect($mahasiswa)->map(function ($mahasiswa) use ($irs, $user) {
            // Menyaring IRS berdasarkan nim
            $matchingIRS = $irs->filter(function ($item) use ($mahasiswa, $user) {
                if ($user->role == 'dosenwali') {
                    return $item['nim'] == $mahasiswa['nim'] && $mahasiswa['dosenwali'] == $user->dosenwali->nama;
                } elseif ($user->role == 'operator') {
                    return $item['nim'] == $mahasiswa['nim'];
                }
                return false;
            });

            return ['mahasiswa' => $mahasiswa, 'irs' => $matchingIRS];
        });

        return view('verifikasi/irs', compact('user', 'mahasiswa', 'data', 'angkatanAktif', 'irs', 'operator', 'dosenwali'), ['page' => 'irs']);
    }

    public function verifikasiirs($nim, $semester)
    {
        // Cari IRS berdasarkan nim dan semester
        $irs = IRS::where('nim', $nim)->where('semester', $semester)->first();

        if ($irs) {
            // Update status IRS menjadi 1
            IRS::where('nim', $nim)->where('semester', $semester)->update(['status' => '1']);

            return redirect()->back()->with('success', 'Verifikasi berhasil');
        } else {
            return redirect()->back()->with('error', 'IRS tidak ditemukan');
        }
    }

    public function batalverifikasiirs($nim, $semester)
    {
        // Cari IRS berdasarkan nim dan semester
        $irs = IRS::where('nim', $nim)->where('semester', $semester)->first();

        if ($irs) {
            // Update status IRS menjadi 1
            IRS::where('nim', $nim)->where('semester', $semester)->update(['status' => '0']);

            return redirect('/verifikasi/irs')->with('success', 'Verifikasi dibatalkan');
        } else {
            return redirect()->back()->with('error', 'IRS tidak ditemukan');
        }
    }

    public function verifikasieditirs($nim, $semester)
    {

        $user = Auth::user();
        $operator = $user->operator;
        $dosenwali = $user->dosenwali;
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();
        $semesterAktif = $mahasiswa->getSemesterAktif();

        $irs = IRS::where('nim', $nim)->where('semester', $semester)->first();

        return view('verifikasi/editirs', compact('user','mahasiswa','dosenwali','operator','irs','semesterAktif','semester'), ['page' => 'irs']);
    }

    public function verifikasisaveirs(Request $request, $nim)
    {
        $request->validate([
            'semester' => 'required',
            'jmlsks' => 'required|numeric',
        ], [
            'semester.required' => 'Semester wajib diisi',
            'jmlsks.required' => 'Jumlah SKS wajib diisi',
            'jmlsks.numeric' => 'Jumlah SKS berupa angka',
        ]);

        $data = [
            'semester' => $request->semester,
            'jumlahsks' => $request->jmlsks,
            'status' => '1',
        ];
    
        IRS::updateOrInsert(
            ['nim' => $nim, 'semester' => $request->semester],
            $data
        );

        return redirect('/verifikasi/irs')->with('success', 'Perubahan IRS berhasil dilakukan');
    }


}
