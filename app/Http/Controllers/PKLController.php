<?php

namespace App\Http\Controllers;

use App\Models\KHS;
use App\Models\Mahasiswa;
use App\Models\PKL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PKLController extends Controller
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

    public function exportPKL($nim)
    {        
        
        $pkl = PKL::where('nim', $nim)
                ->first();

        if ($pkl) {
            $filePath = storage_path('app/public/pkl/' . $pkl->filepkl);

            return response()->download($filePath, $pkl->filepkl);
        } else {
            return response()->json(['error' => 'File not found.'], 404);
        }
    }

    public function pkl()
    {
        $user = Auth::user();
        $dosenwali = $user->dosenwali;
        $operator = $user->operator;
        $angkatanAktif = $this->getAngkatan();
        $mahasiswa = Mahasiswa::all();
        $pkl = PKL::all();

        // Menggabungkan data mahasiswa dan PKL berdasarkan nim
        $data = collect($mahasiswa)->map(function ($mahasiswa) use ($pkl, $user) {
            // Menyaring PKL berdasarkan nim
            $matchingPKL = $pkl->filter(function ($item) use ($mahasiswa, $user) {
                if ($user->role == 'dosenwali') {
                    return $item['nim'] == $mahasiswa['nim'] && $mahasiswa['dosenwali'] == $user->dosenwali->nama;
                } elseif ($user->role == 'operator') {
                    return $item['nim'] == $mahasiswa['nim'];
                }
                return false;
            });

            return ['mahasiswa' => $mahasiswa, 'pkl' => $matchingPKL];
        });

        return view('verifikasi/pkl', compact('user', 'mahasiswa', 'dosenwali', 'operator' ,'data', 'angkatanAktif', 'pkl'), ['page' => 'pkl']);
    }

    public function verifikasipkl($nim)
    {
        // Cari PKL berdasarkan nim dan semester
        $pkl = PKL::where('nim', $nim)->first();

        if ($pkl) {
            // Update status PKL menjadi 1
            PKL::where('nim', $nim)->update(['status' => '1']);

            return redirect()->back()->with('success', 'Verifikasi berhasil');
        } else {
            return redirect()->back()->with('error', 'PKL tidak ditemukan');
        }
    }

    public function batalverifikasipkl($nim)
    {
        // Cari PKL berdasarkan nim dan semester
        $pkl = PKL::where('nim', $nim)->first();

        if ($pkl) {
            // Update status PKL menjadi 1
            PKL::where('nim', $nim)->update(['status' => '0']);
            
            return redirect('/verifikasi/pkl')->with('success', 'Verifikasi dibatalkan');
        } else {
            return redirect()->back()->with('error', 'pkl tidak ditemukan');
        }
    }

    public function verifikasieditpkl($nim)
    {
        $user = Auth::user();
        $dosenwali = $user->dosenwali;
        $operator = $user->operator;
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();
        $pkl = PKL::where('nim', $nim)->first();

        $semesterPKL = [];

        // Loop dari semester 5 hingga $mahasiswa->getSemesterAktif()
        for ($semester = 5; $semester <= $mahasiswa->getSemesterAktif(); $semester++) {
            $semesterPKL[] = $semester;
        }

        return view('verifikasi/editpkl', compact('user', 'mahasiswa', 'dosenwali','operator' , 'pkl', 'semesterPKL'), ['page' => 'pkl']);
    }


    public function verifikasisavepkl(Request $request, $nim)
    {
        $request->validate([
            'semester' => 'required',
            'nilai' => 'required|alpha|uppercase',
        ], [
            'semester.required' => 'Semester wajib dipilih',
            'nilai.required' => 'Nilai PKL wajib diisi',
            'nilai.alpha' => 'Nilai PKL harus berupa huruf',
            'nilai.uppercase' => 'Nilai PKL harus berupa huruf kapital',
        ]);
        
        $data = [
            'semester' => $request->semester,
            'nilai' => $request->nilai,
            'status' => '1',
        ];
    
        PKL::updateOrInsert(
            ['nim' => $nim],
            $data
        );

        return redirect('/verifikasi/pkl')->with('success', 'Perubahan PKL berhasil dilakukan');
    }
}
