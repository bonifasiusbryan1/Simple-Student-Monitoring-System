<?php

namespace App\Http\Controllers;

use App\Models\KHS;
use App\Models\Mahasiswa;
use App\Models\Skripsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SkripsiController extends Controller
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

    public function exportSkripsi($nim)
    {        
        
        $skripsi = Skripsi::where('nim', $nim)
                ->first();

        if ($skripsi) {
            $filePath = storage_path('app/public/skripsi/' . $skripsi->fileskripsi);

            return response()->download($filePath, $skripsi->fileskripsi);
        } else {
            return response()->json(['error' => 'File not found.'], 404);
        }
    }

    public function skripsi()
    {
        $user = Auth::user();
        $dosenwali = $user->dosenwali;
        $operator = $user->operator;
        $angkatanAktif = $this->getAngkatan();
        $mahasiswa = Mahasiswa::all();
        $skripsi = Skripsi::all();

        // Menggabungkan data mahasiswa dan Skripsi berdasarkan nim
        $data = collect($mahasiswa)->map(function ($mahasiswa) use ($skripsi, $user) {
            // Menyaring Skripsi berdasarkan nim
            $matchingSkripsi = $skripsi->filter(function ($item) use ($mahasiswa, $user) {
                if ($user->role == 'dosenwali') {
                    return $item['nim'] == $mahasiswa['nim'] && $mahasiswa['dosenwali'] == $user->dosenwali->nama;
                } elseif ($user->role == 'operator') {
                    return $item['nim'] == $mahasiswa['nim'];
                }
                return false;
            });

            return ['mahasiswa' => $mahasiswa, 'skripsi' => $matchingSkripsi];
        });

        return view('verifikasi/skripsi', compact('user', 'mahasiswa', 'dosenwali', 'operator', 'data', 'angkatanAktif', 'skripsi'), ['page' => 'skripsi']);
    }

    public function verifikasiskripsi($nim)
    {
        // Cari Skripsi berdasarkan nim dan semester
        $skripsi = Skripsi::where('nim', $nim)->first();

        if ($skripsi) {
            // Update status Skripsi menjadi 1
            Skripsi::where('nim', $nim)->update(['status' => '1']);

            return redirect()->back()->with('success', 'Verifikasi berhasil');
        } else {
            return redirect()->back()->with('error', 'Skripsi tidak ditemukan');
        }
    }

    public function batalverifikasiskripsi($nim)
    {
        // Cari Skripsi berdasarkan nim dan semester
        $skripsi = Skripsi::where('nim', $nim)->first();

        if ($skripsi) {
            // Update status Skripsi menjadi 1
            Skripsi::where('nim', $nim)->update(['status' => '0']);
            
            return redirect('/verifikasi/skripsi')->with('success', 'Verifikasi dibatalkan');
        } else {
            return redirect()->back()->with('error', 'Skripsi tidak ditemukan');
        }
    }

    public function verifikasieditskripsi($nim)
    {
        $user = Auth::user();
        $dosenwali = $user->dosenwali;
        $operator = $user->operator;
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();
        $skripsi = Skripsi::where('nim', $nim)->first();

        $khs = KHS::where('nim', $nim)->get();

        $semesterSkripsi = [];
    
        foreach ($khs as $nilai) {
            if ($nilai->sksk >= 120) {
                $semesterSkripsi[] = $nilai->semester;
            }
        }

        return view('verifikasi/editskripsi', compact('user', 'mahasiswa', 'dosenwali', 'operator', 'skripsi', 'semesterSkripsi'), ['page' => 'skripsi']);
    }

    public function verifikasisaveskripsi(Request $request, $nim)
    {
        $request->validate([
            'semester' => 'required',
            'nilai' => 'required|alpha|uppercase',
        ], [
            'semester.required' => 'Semester wajib dipilih',
            'nilai.required' => 'Nilai Skripsi wajib diisi',
            'nilai.alpha' => 'Nilai Skripsi harus berupa huruf',
            'nilai.uppercase' => 'Nilai Skripsi harus berupa huruf kapital',
        ]);
        
        $data = [
            'semester' => $request->semester,
            'nilai' => $request->nilai,
            'status' => '1',
        ];
    
        Skripsi::updateOrInsert(
            ['nim' => $nim],
            $data
        );

        return redirect('/verifikasi/skripsi')->with('success', 'Perubahan Skripsi berhasil dilakukan');
    }
}
