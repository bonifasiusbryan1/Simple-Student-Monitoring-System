<?php

namespace App\Http\Controllers;
use App\Models\IRS;
use App\Models\KHS;
use App\Models\Mahasiswa;
use App\Models\PKL;
use App\Models\Skripsi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GeneralController extends Controller
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

    function dashboard()
    {
        $userRole = Auth::user()->role;
        return redirect("/dashboard/$userRole");
    }

    function profile()
    {
        $userRole = Auth::user()->role;
        return redirect("/profile/$userRole");
    }

    function editprofile()
    {
        $userRole = Auth::user()->role;
        return redirect("/editprofile/$userRole");
    }

    function irs()
    {
        $userRole = Auth::user()->role;
        return redirect("/irs/$userRole");
    }

    function khs()
    {
        $userRole = Auth::user()->role;
        return redirect("/khs/$userRole");
    }

    public function carimahasiswa(Request $request, $page)
    {
        $user = Auth::user();
        $dosenwali = $user->dosenwali;
        $operator = $user->operator;
        $departemen = $user->departemen;
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
            
            return view('/verifikasi/irs', compact('user', 'mahasiswa', 'dosenwali', 'operator', 'data', 'angkatanAktif', 'irs'), ['page' => 'irs']);
        } else if ($page == 'khs'){
            $khs = KHS::all();

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

            return view('/verifikasi/khs', compact('user', 'mahasiswa', 'dosenwali','operator', 'data', 'angkatanAktif', 'khs'), ['page' => 'khs']);
        } else if ($page == 'pkl'){
            $pkl = PKL::all();

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

            return view('/verifikasi/pkl', compact('user', 'mahasiswa', 'dosenwali', 'operator', 'data', 'angkatanAktif', 'pkl'), ['page' => 'pkl']);
        } else if ($page == 'skripsi'){
            $skripsi = Skripsi::all();

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

            return view('/verifikasi/skripsi', compact('user', 'mahasiswa', 'dosenwali', 'operator', 'data', 'angkatanAktif', 'skripsi'), ['page' => 'skripsi']);
        } else if ($page == 'progresstudi'){
            $irs = IRS::all();
            $khs = KHS::all();
            $pkl = PKL::all();
            $skripsi = Skripsi::all();

            // Combine data for IRS
            $dataIrs = collect($mahasiswa)->map(function ($mahasiswa) use ($irs, $user) {
                $matchingIRS = $irs->filter(function ($item) use ($mahasiswa, $user) {
                    if ($user->role == 'dosenwali') {
                        return $item['nim'] == $mahasiswa['nim'] && $mahasiswa['dosenwali'] == $user->dosenwali->nama;
                    } elseif ($user->role == 'operator' || $user->role == 'departemen') {
                        return $item['nim'] == $mahasiswa['nim'];
                    }
                    return false;
                });

                return ['mahasiswa' => $mahasiswa, 'irs' => $matchingIRS];
            });

            // Combine data for KHS
            $dataKhs = collect($mahasiswa)->map(function ($mahasiswa) use ($khs, $user) {
                $matchingKHS = $khs->filter(function ($item) use ($mahasiswa, $user) {
                    if ($user->role == 'dosenwali') {
                        return $item['nim'] == $mahasiswa['nim'] && $mahasiswa['dosenwali'] == $user->dosenwali->nama;
                    } elseif ($user->role == 'operator' || $user->role == 'departemen') {
                        return $item['nim'] == $mahasiswa['nim'];
                    }
                    return false;
                });

                return ['mahasiswa' => $mahasiswa, 'khs' => $matchingKHS];
            });

            // Combine data for PKL
            $dataPkl = collect($mahasiswa)->map(function ($mahasiswa) use ($pkl, $user) {
                $matchingPKL = $pkl->filter(function ($item) use ($mahasiswa, $user) {
                    if ($user->role == 'dosenwali') {
                        return $item['nim'] == $mahasiswa['nim'] && $mahasiswa['dosenwali'] == $user->dosenwali->nama;
                    } elseif ($user->role == 'operator' || $user->role == 'departemen') {
                        return $item['nim'] == $mahasiswa['nim'];
                    }
                    return false;
                });

                return ['mahasiswa' => $mahasiswa, 'pkl' => $matchingPKL];
            });

            // Combine data for Skripsi
            $dataSkripsi = collect($mahasiswa)->map(function ($mahasiswa) use ($skripsi, $user) {
                $matchingSkripsi = $skripsi->filter(function ($item) use ($mahasiswa, $user) {
                    if ($user->role == 'dosenwali') {
                        return $item['nim'] == $mahasiswa['nim'] && $mahasiswa['dosenwali'] == $user->dosenwali->nama;
                    } elseif ($user->role == 'operator' || $user->role == 'departemen') {
                        return $item['nim'] == $mahasiswa['nim'];
                    }
                    return false;
                });

                return ['mahasiswa' => $mahasiswa, 'skripsi' => $matchingSkripsi];
            });

            
            return view('progresstudi/progresstudi', compact('user', 'mahasiswa', 'angkatanAktif', 'departemen', 'operator', 'dosenwali', 'dataIrs', 'dataKhs', 'dataPkl', 'dataSkripsi'), ['page'=>'progresstudi']);
        } else if ($page == 'rekapmhs'){
    
            return view('rekapmhs/mahasiswa', compact('user', 'mahasiswa', 'dosenwali', 'operator', 'angkatanAktif'), ['page'=>'rekapmhs']);
        }
    }

    public function progresstudi()
    {
        $user = Auth::user();
        $angkatanAktif = $this->getAngkatan();
        $angkatanAktif = array_reverse($angkatanAktif);
        $operator = $user->operator;
        $dosenwali = $user->dosenwali; 
        $departemen = $user->departemen;
        $mahasiswa = Mahasiswa::all();
        $irs = IRS::all();
        $khs = KHS::all();
        $pkl = PKL::all();
        $skripsi = Skripsi::all();

        // Combine data for IRS
        $dataIrs = collect($mahasiswa)->map(function ($mahasiswa) use ($irs, $user) {
            $matchingIRS = $irs->filter(function ($item) use ($mahasiswa, $user) {
                if ($user->role == 'dosenwali') {
                    return $item['nim'] == $mahasiswa['nim'] && $mahasiswa['dosenwali'] == $user->dosenwali->nama;
                } elseif ($user->role == 'operator' || $user->role == 'departemen') {
                    return $item['nim'] == $mahasiswa['nim'];
                }
                return false;
            });

            return ['mahasiswa' => $mahasiswa, 'irs' => $matchingIRS];
        });

        // Combine data for KHS
        $dataKhs = collect($mahasiswa)->map(function ($mahasiswa) use ($khs, $user) {
            $matchingKHS = $khs->filter(function ($item) use ($mahasiswa, $user) {
                if ($user->role == 'dosenwali') {
                    return $item['nim'] == $mahasiswa['nim'] && $mahasiswa['dosenwali'] == $user->dosenwali->nama;
                } elseif ($user->role == 'operator' || $user->role == 'departemen') {
                    return $item['nim'] == $mahasiswa['nim'];
                }
                return false;
            });

            return ['mahasiswa' => $mahasiswa, 'khs' => $matchingKHS];
        });

        // Combine data for PKL
        $dataPkl = collect($mahasiswa)->map(function ($mahasiswa) use ($pkl, $user) {
            $matchingPKL = $pkl->filter(function ($item) use ($mahasiswa, $user) {
                if ($user->role == 'dosenwali') {
                    return $item['nim'] == $mahasiswa['nim'] && $mahasiswa['dosenwali'] == $user->dosenwali->nama;
                } elseif ($user->role == 'operator' || $user->role == 'departemen') {
                    return $item['nim'] == $mahasiswa['nim'];
                }
                return false;
            });

            return ['mahasiswa' => $mahasiswa, 'pkl' => $matchingPKL];
        });

        // Combine data for Skripsi
        $dataSkripsi = collect($mahasiswa)->map(function ($mahasiswa) use ($skripsi, $user) {
            $matchingSkripsi = $skripsi->filter(function ($item) use ($mahasiswa, $user) {
                if ($user->role == 'dosenwali') {
                    return $item['nim'] == $mahasiswa['nim'] && $mahasiswa['dosenwali'] == $user->dosenwali->nama;
                } elseif ($user->role == 'operator' || $user->role == 'departemen') {
                    return $item['nim'] == $mahasiswa['nim'];
                }
                return false;
            });

            return ['mahasiswa' => $mahasiswa, 'skripsi' => $matchingSkripsi];
        });

        return view('progresstudi/progresstudi', compact('user', 'mahasiswa', 'angkatanAktif', 'departemen', 'operator', 'dosenwali', 'dataIrs', 'dataKhs', 'dataPkl', 'dataSkripsi'), ['page'=>'progresstudi']);
    }

    public function rekapmhs()
    {
        $user = Auth::user();
        $angkatanAktif = $this->getAngkatan();
        $angkatanAktif = array_reverse($angkatanAktif);
        $operator = $user->operator;
        $dosenwali = $user->dosenwali; 
        $departemen = $user->departemen;
        if ($user->role == 'dosenwali') {
            $mahasiswa = Mahasiswa::where('dosenwali', $dosenwali->nama)->get();
        } else {
            $mahasiswa = Mahasiswa::all();
        }

        return view('rekapmhs/mahasiswa', compact('user', 'angkatanAktif', 'departemen', 'operator', 'dosenwali', 'mahasiswa'), ['page' => 'rekapmhs']);
    }

    public function rekappkl()
    {
        $user = Auth::user();
        $angkatanAktif = $this->getAngkatan();
        $angkatanAktif = array_reverse($angkatanAktif);
        $operator = $user->operator;
        $dosenwali = $user->dosenwali; 
        $departemen = $user->departemen;
        $mahasiswa = Mahasiswa::all();
        $pkl = PKL::all();

        $rekapPKL = [];

        // Inisialisasi array untuk setiap angkatan
        foreach ($angkatanAktif as $angkatan) {
            $rekapPKL[$angkatan] = [
                'sudah' => [],
                'belum' => []
            ];
        }

        foreach ($mahasiswa as $mhs) {
            $pklMahasiswa = $pkl->where('nim', $mhs->nim)->first();
        
            $data = [
                'nim' => $mhs->nim,
                'nama' => $mhs->nama,
                'email' => $mhs->email,
                'alamat' => $mhs->alamat,
                'kabkota' => $mhs->kabkota,
                'provinsi' => $mhs->provinsi,
                'notelp' => $mhs->notelp,
                'angkatan' => $mhs->angkatan,
                'status' => $mhs->status,
                'dosenwali' => $mhs->dosenwali,
                'jalurmasuk' => $mhs->jalurmasuk,
                'foto' => $mhs->foto,
                'semester' => null,
                'status_pkl' => null,
                'nilai' => null,
            ];
        
            if ($pklMahasiswa) {
                $data['semester'] = $pklMahasiswa->semester;
                $data['status_pkl'] = $pklMahasiswa->status_pkl;
                $data['nilai'] = $pklMahasiswa->nilai;
            }
        
            // Filter for Dosen Wali
            if ($user->role =='dosenwali' && $mhs->dosenwali == $dosenwali->nama) {
                if ($pklMahasiswa && $pklMahasiswa->status_pkl == 'lulus') {
                    $rekapPKL[$mhs->angkatan]['sudah'][] = $data;
                } else {
                    $rekapPKL[$mhs->angkatan]['belum'][] = $data;
                }
            }
            // For other roles, include all students
            elseif ($user->role != 'dosenwali') {
                if ($pklMahasiswa && $pklMahasiswa->status_pkl == 'lulus') {
                    $rekapPKL[$mhs->angkatan]['sudah'][] = $data;
                } else {
                    $rekapPKL[$mhs->angkatan]['belum'][] = $data;
                }
            }
        }

        return view('rekapmhs/pkl', compact('user', 'rekapPKL', 'angkatanAktif', 'departemen', 'operator', 'dosenwali'), ['page' => 'rekappkl', 'data' => 'rekap']);
    }

    public function rekapskripsi()
    {
        $user = Auth::user();
        $angkatanAktif = $this->getAngkatan();
        $angkatanAktif = array_reverse($angkatanAktif);
        $operator = $user->operator;
        $dosenwali = $user->dosenwali; 
        $departemen = $user->departemen;
        $mahasiswa = Mahasiswa::all();
        $skripsi = Skripsi::all(); 

        $rekapSkripsi = [];

        // Inisialisasi array untuk setiap angkatan
        foreach ($angkatanAktif as $angkatan) {
            $rekapSkripsi[$angkatan] = [
                'sudah' => [],
                'belum' => []
            ];
        }

        foreach ($mahasiswa as $mhs) {
            $skripsiMahasiswa = $skripsi->where('nim', $mhs->nim)->first();
        
            $data = [
                'nim' => $mhs->nim,
                'nama' => $mhs->nama,
                'email' => $mhs->email,
                'alamat' => $mhs->alamat,
                'kabkota' => $mhs->kabkota,
                'provinsi' => $mhs->provinsi,
                'notelp' => $mhs->notelp,
                'angkatan' => $mhs->angkatan,
                'status' => $mhs->status,
                'dosenwali' => $mhs->dosenwali,
                'jalurmasuk' => $mhs->jalurmasuk,
                'foto' => $mhs->foto,
                'semester' => null,
                'status_skripsi' => null,
                'nilai' => null,
            ];
        
            if ($skripsiMahasiswa) {
                $data['semester'] = $skripsiMahasiswa->semester;
                $data['status_skripsi'] = $skripsiMahasiswa->status_skripsi;
                $data['nilai'] = $skripsiMahasiswa->nilai;
            }
        
            // Filter for Dosen Wali
            if ($user->role == 'dosenwali' && $mhs->dosenwali == $dosenwali->nama) {
                if ($skripsiMahasiswa && $skripsiMahasiswa->status_skripsi == 'lulus') {
                    $rekapSkripsi[$mhs->angkatan]['sudah'][] = $data;
                } else {
                    $rekapSkripsi[$mhs->angkatan]['belum'][] = $data;
                }
            }
            // For other roles, include all students
            elseif ($user->role != 'dosenwali') {
                if ($skripsiMahasiswa && $skripsiMahasiswa->status_skripsi == 'lulus') {
                    $rekapSkripsi[$mhs->angkatan]['sudah'][] = $data;
                } else {
                    $rekapSkripsi[$mhs->angkatan]['belum'][] = $data;
                }
            }
        }

        return view('rekapmhs/skripsi', compact('user', 'rekapSkripsi', 'angkatanAktif', 'departemen', 'operator', 'dosenwali'), ['page' => 'rekapskripsi', 'data' => 'rekap']);
    }

    public function rekapstatus()
    {
        $user = Auth::user();
        $angkatanAktif = $this->getAngkatan();
        $angkatanAktif = array_reverse($angkatanAktif);
        $operator = $user->operator;
        $dosenwali = $user->dosenwali; 
        $departemen = $user->departemen;
        if ($user->role == 'dosenwali') {
            $mahasiswa = Mahasiswa::where('dosenwali', $dosenwali->nama)->get();
        } else {
            $mahasiswa = Mahasiswa::all();
        }

        $rekapStatus = [];

        foreach ($angkatanAktif as $angkatan) {
            $rekapStatus[$angkatan] = [
                'aktif' => [],
                'cuti' => [],
                'mangkir' => [],
                'undur diri' => [],
                'lulus' => [],
                'meninggal dunia' => [],
            ];
        }

        foreach ($mahasiswa as $mhs) {
            $data = [
                'nim' => $mhs->nim,
                'nama' => $mhs->nama,
                'email' => $mhs->email,
                'alamat' => $mhs->alamat,
                'kabkota' => $mhs->kabkota,
                'provinsi' => $mhs->provinsi,
                'notelp' => $mhs->notelp,
                'angkatan' => $mhs->angkatan,
                'status' => $mhs->status,
                'dosenwali' => $mhs->dosenwali,
                'jalurmasuk' => $mhs->jalurmasuk,
                'foto' => $mhs->foto,
            ];

            if ($user->role == 'dosenwali' && $mhs->dosenwali == $dosenwali->nama) {
                if ($mhs->status == 'aktif') {
                    $rekapStatus[$mhs->angkatan]['aktif'][] = $data;
                } elseif ($mhs->status == 'cuti') {
                    $rekapStatus[$mhs->angkatan]['cuti'][] = $data;
                } elseif ($mhs->status == 'mangkir') {
                    $rekapStatus[$mhs->angkatan]['mangkir'][] = $data;
                } elseif ($mhs->status == 'undur diri') {
                    $rekapStatus[$mhs->angkatan]['undur diri'][] = $data;
                } elseif ($mhs->status == 'lulus') {
                    $rekapStatus[$mhs->angkatan]['lulus'][] = $data;
                } elseif ($mhs->status == 'do') {
                    $rekapStatus[$mhs->angkatan]['do'][] = $data;
                } elseif ($mhs->status == 'meninggal dunia') {
                    $rekapStatus[$mhs->angkatan]['meninggal dunia'][] = $data;
                }
            } else {
                if ($mhs->status == 'aktif') {
                    $rekapStatus[$mhs->angkatan]['aktif'][] = $data;
                } elseif ($mhs->status == 'cuti') {
                    $rekapStatus[$mhs->angkatan]['cuti'][] = $data;
                } elseif ($mhs->status == 'mangkir') {
                    $rekapStatus[$mhs->angkatan]['mangkir'][] = $data;
                } elseif ($mhs->status == 'undur diri') {
                    $rekapStatus[$mhs->angkatan]['undur diri'][] = $data;
                } elseif ($mhs->status == 'lulus') {
                    $rekapStatus[$mhs->angkatan]['lulus'][] = $data;
                } elseif ($mhs->status == 'do') {
                    $rekapStatus[$mhs->angkatan]['do'][] = $data;
                } elseif ($mhs->status == 'meninggal dunia') {
                    $rekapStatus[$mhs->angkatan]['meninggal_dunia'][] = $data;
                }
            }
        }

        return view('rekapmhs/status', compact('user', 'rekapStatus', 'angkatanAktif', 'departemen', 'operator', 'dosenwali'), ['page' => 'rekapskripsi', 'data' => 'rekap']);
    }


    public function exportPDFRekapPKL()
    {
        $user = Auth::user();
        $angkatanAktif = $this->getAngkatan();
        $angkatanAktif = array_reverse($angkatanAktif);
        $operator = $user->operator;
        $dosenwali = $user->dosenwali; 
        $departemen = $user->departemen;
        $mahasiswa = Mahasiswa::all();
        $pkl = PKL::all();

        $rekapPKL = [];
        // Inisialisasi array untuk setiap angkatan
        foreach ($angkatanAktif as $angkatan) {
            $rekapPKL[$angkatan] = [
                'sudah' => [],
                'belum' => []
            ];
        }
        foreach ($mahasiswa as $mhs) {
            $pklMahasiswa = $pkl->where('nim', $mhs->nim)->first();
        
            $data = [
                'nim' => $mhs->nim,
                'nama' => $mhs->nama,
                'email' => $mhs->email,
                'alamat' => $mhs->alamat,
                'kabkota' => $mhs->kabkota,
                'provinsi' => $mhs->provinsi,
                'notelp' => $mhs->notelp,
                'angkatan' => $mhs->angkatan,
                'status' => $mhs->status,
                'dosenwali' => $mhs->dosenwali,
                'jalurmasuk' => $mhs->jalurmasuk,
                'foto' => $mhs->foto,
                'semester' => null,
                'status_pkl' => null,
                'nilai' => null,
            ];
        
            if ($pklMahasiswa) {
                $data['semester'] = $pklMahasiswa->semester;
                $data['status_pkl'] = $pklMahasiswa->status_pkl;
                $data['nilai'] = $pklMahasiswa->nilai;
            }
        
            // Filter for Dosen Wali
            if ($user->role =='dosenwali' && $mhs->dosenwali == $dosenwali->nama) {
                if ($pklMahasiswa && $pklMahasiswa->status_pkl == 'lulus') {
                    $rekapPKL[$mhs->angkatan]['sudah'][] = $data;
                } else {
                    $rekapPKL[$mhs->angkatan]['belum'][] = $data;
                }
            }
            // For other roles, include all students
            elseif ($user->role != 'dosenwali') {
                if ($pklMahasiswa && $pklMahasiswa->status_pkl == 'lulus') {
                    $rekapPKL[$mhs->angkatan]['sudah'][] = $data;
                } else {
                    $rekapPKL[$mhs->angkatan]['belum'][] = $data;
                }
            }
        }

        $pdf = Pdf::loadView('cetak/rekappkl', compact('rekapPKL','angkatanAktif'));

        return $pdf->download('rekap-pkl.pdf');
    }

    public function exportPDFRekapSkripsi()
    {
        $user = Auth::user();
        $angkatanAktif = $this->getAngkatan();
        $angkatanAktif = array_reverse($angkatanAktif);
        $operator = $user->operator;
        $dosenwali = $user->dosenwali; 
        $departemen = $user->departemen;
        $mahasiswa = Mahasiswa::all();
        $skripsi = Skripsi::all(); // Assuming Skripsi is the model for skripsi data

        $rekapSkripsi = [];

        // Inisialisasi array untuk setiap angkatan
        foreach ($angkatanAktif as $angkatan) {
            $rekapSkripsi[$angkatan] = [
                'sudah' => [],
                'belum' => []
            ];
        }

        foreach ($mahasiswa as $mhs) {
            $skripsiMahasiswa = $skripsi->where('nim', $mhs->nim)->first();

            $data = [
                'nim' => $mhs->nim,
                'nama' => $mhs->nama,
                'email' => $mhs->email,
                'alamat' => $mhs->alamat,
                'kabkota' => $mhs->kabkota,
                'provinsi' => $mhs->provinsi,
                'notelp' => $mhs->notelp,
                'angkatan' => $mhs->angkatan,
                'status' => $mhs->status,
                'dosenwali' => $mhs->dosenwali,
                'jalurmasuk' => $mhs->jalurmasuk,
                'foto' => $mhs->foto,
                'semester' => null,
                'status_skripsi' => null,
                'nilai' => null,
            ];

            if ($skripsiMahasiswa) {
                $data['semester'] = $skripsiMahasiswa->semester;
                $data['status_skripsi'] = $skripsiMahasiswa->status_skripsi;
                $data['nilai'] = $skripsiMahasiswa->nilai;
            }

            // Filter for Dosen Wali
            if ($user->role =='dosenwali' && $mhs->dosenwali == $dosenwali->nama) {
                if ($skripsiMahasiswa && $skripsiMahasiswa->status_skripsi == 'lulus') {
                    $rekapSkripsi[$mhs->angkatan]['sudah'][] = $data;
                } else {
                    $rekapSkripsi[$mhs->angkatan]['belum'][] = $data;
                }
            }
            // For other roles, include all students
            elseif ($user->role != 'dosenwali') {
                if ($skripsiMahasiswa && $skripsiMahasiswa->status_skripsi == 'lulus') {
                    $rekapSkripsi[$mhs->angkatan]['sudah'][] = $data;
                } else {
                    $rekapSkripsi[$mhs->angkatan]['belum'][] = $data;
                }
            }
        }

        $pdf = Pdf::loadView('cetak/rekapskripsi', compact('rekapSkripsi', 'angkatanAktif'));

        return $pdf->download('rekap-skripsi.pdf');
    }
    
    public function exportPDFRekapStatus()
    {
        $user = Auth::user();
        $angkatanAktif = $this->getAngkatan();
        $angkatanAktif = array_reverse($angkatanAktif);
        $operator = $user->operator;
        $dosenwali = $user->dosenwali; 
        $departemen = $user->departemen;
        $mahasiswa = Mahasiswa::all(); 

        $rekapStatus = [];

        foreach ($angkatanAktif as $angkatan) {
            $rekapStatus[$angkatan] = [
                'aktif' => [],
                'cuti' => [],
                'mangkir' => [],
                'undur diri' => [],
                'lulus' => [],
                'do' => [],
                'meninggal dunia' => [],
            ];
        }

        foreach ($mahasiswa as $mhs) {
            $data = [
                'nim' => $mhs->nim,
                'nama' => $mhs->nama,
                'email' => $mhs->email,
                'alamat' => $mhs->alamat,
                'kabkota' => $mhs->kabkota,
                'provinsi' => $mhs->provinsi,
                'notelp' => $mhs->notelp,
                'angkatan' => $mhs->angkatan,
                'status' => $mhs->status,
                'dosenwali' => $mhs->dosenwali,
                'jalurmasuk' => $mhs->jalurmasuk,
                'foto' => $mhs->foto,
            ];

            if ($user->role == 'dosenwali' && $mhs->dosenwali == $dosenwali->nama) {
                if ($mhs->status == 'aktif') {
                    $rekapStatus[$mhs->angkatan]['aktif'][] = $data;
                } elseif ($mhs->status == 'cuti') {
                    $rekapStatus[$mhs->angkatan]['cuti'][] = $data;
                } elseif ($mhs->status == 'mangkir') {
                    $rekapStatus[$mhs->angkatan]['mangkir'][] = $data;
                } elseif ($mhs->status == 'undur diri') {
                    $rekapStatus[$mhs->angkatan]['undur diri'][] = $data;
                } elseif ($mhs->status == 'lulus') {
                    $rekapStatus[$mhs->angkatan]['lulus'][] = $data;
                } elseif ($mhs->status == 'do') {
                    $rekapStatus[$mhs->angkatan]['do'][] = $data;
                } elseif ($mhs->status == 'meninggal dunia') {
                    $rekapStatus[$mhs->angkatan]['meninggal dunia'][] = $data;
                }
            } else {
                if ($mhs->status == 'aktif') {
                    $rekapStatus[$mhs->angkatan]['aktif'][] = $data;
                } elseif ($mhs->status == 'cuti') {
                    $rekapStatus[$mhs->angkatan]['cuti'][] = $data;
                } elseif ($mhs->status == 'mangkir') {
                    $rekapStatus[$mhs->angkatan]['mangkir'][] = $data;
                } elseif ($mhs->status == 'undur diri') {
                    $rekapStatus[$mhs->angkatan]['undur diri'][] = $data;
                } elseif ($mhs->status == 'lulus') {
                    $rekapStatus[$mhs->angkatan]['lulus'][] = $data;
                } elseif ($mhs->status == 'do') {
                    $rekapStatus[$mhs->angkatan]['do'][] = $data;
                } elseif ($mhs->status == 'meninggal dunia') {
                    $rekapStatus[$mhs->angkatan]['meninggal_dunia'][] = $data;
                }
            }
        }

        $pdf = Pdf::loadView('cetak/rekapstatus', compact('user', 'rekapStatus', 'angkatanAktif', 'departemen', 'operator', 'dosenwali'), ['page' => 'rekapskripsi', 'data' => 'rekap']);

        return $pdf->download('rekap-status.pdf');
    }

    public function exportPDFRekapMahasiswa($angkatan, $status)
    {
        $user = Auth::user();
        $angkatanAktif = $this->getAngkatan();
        $angkatanAktif = array_reverse($angkatanAktif);
        $operator = $user->operator;
        $dosenwali = $user->dosenwali; 
        $departemen = $user->departemen;

        if ($user->role == 'dosenwali') {
            $mahasiswa = Mahasiswa::where('dosenwali', $dosenwali->nama)->get();
        } else {
            $mahasiswa = Mahasiswa::all();
        }

        $pdf = Pdf::loadView('cetak/rekapmhs', compact('user', 'angkatanAktif', 'departemen', 'operator', 'dosenwali', 'mahasiswa', 'angkatan', 'status'), ['page' => 'rekapmhs']);

        $pdf->setPaper('landscape');

        return $pdf->download('rekap-mahasiswa.pdf');
    }


    public function listsudahpkl($angkatan)
    {
        $user = Auth::user();
        $angkatanAktif = $this->getAngkatan();
        $angkatanAktif = array_reverse($angkatanAktif);
        $operator = $user->operator;
        $dosenwali = $user->dosenwali; 
        $departemen = $user->departemen;
        $mahasiswa = Mahasiswa::all();
        $pkl = PKL::all();

        $rekapPKL = [];

        foreach ($mahasiswa as $mhs) {
            $pklMahasiswa = $pkl->where('nim', $mhs->nim)->first();

            if ($pklMahasiswa && $pklMahasiswa->status_pkl == 'lulus' && $mhs->angkatan == $angkatan) {
                // Filter for Dosen Wali
                if ($user->role=='dosenwali' && $mhs->dosenwali == $dosenwali->nama) {
                    $rekapPKL[] = [
                        'nim' => $mhs->nim,
                        'nama' => $mhs->nama,
                        'angkatan' => $mhs->angkatan,
                        'semester' => $pklMahasiswa->semester,
                        'nilai' => $pklMahasiswa->nilai,
                        'status_pkl' => $pklMahasiswa->status_pkl,
                    ];
                }
                // For other roles, include all students
                elseif ($user->role != 'dosenwali') {
                    $rekapPKL[] = [
                        'nim' => $mhs->nim,
                        'nama' => $mhs->nama,
                        'angkatan' => $mhs->angkatan,
                        'semester' => $pklMahasiswa->semester,
                        'nilai' => $pklMahasiswa->nilai,
                        'status_pkl' => $pklMahasiswa->status_pkl,
                    ];
                }
            }
        }

        return view('listmhs/pkl', compact('user', 'rekapPKL', 'angkatanAktif', 'departemen', 'operator', 'dosenwali', 'angkatan'), ['page' => 'rekappkl','page2' => 'pkl', 'data' => 'list', 'listStatus' => 'sudah']);
    }

    public function listbelumpkl($angkatan)
    {
        $user = Auth::user();
        $angkatanAktif = $this->getAngkatan();
        $angkatanAktif = array_reverse($angkatanAktif);
        $operator = $user->operator;
        $dosenwali = $user->dosenwali; 
        $departemen = $user->departemen;
        $mahasiswa = Mahasiswa::all();
        $pkl = PKL::all();

        $rekapPKL = [];

        foreach ($mahasiswa as $mhs) {
            $pklMahasiswa = $pkl->where('nim', $mhs->nim)->first();

            if ((!$pklMahasiswa || $pklMahasiswa->status_pkl !== 'lulus') && $mhs->angkatan == $angkatan) {
                // Filter for Dosen Wali
                if ($user->role=='dosenwali' && $mhs->dosenwali == $dosenwali->nama) {
                    $rekapPKL[] = [
                        'nim' => $mhs->nim,
                        'nama' => $mhs->nama,
                        'angkatan' => $mhs->angkatan,
                        'semester' => null,
                        'nilai' => null,
                        'status_pkl' => null,
                    ];
                }
                // For other roles, include all students
                elseif ($user->role != 'dosenwali') {
                    $rekapPKL[] = [
                        'nim' => $mhs->nim,
                        'nama' => $mhs->nama,
                        'angkatan' => $mhs->angkatan,
                        'semester' => null,
                        'nilai' => null,
                        'status_pkl' => null,
                    ];
                }
            }
        }

        return view('listmhs/pkl', compact('user', 'rekapPKL', 'angkatanAktif', 'departemen', 'operator', 'dosenwali', 'angkatan'), ['page' => 'rekappkl','page2' => 'pkl', 'data' => 'list', 'listStatus' => 'belum']);
    }

    public function listsudahskripsi($angkatan)
    {
        $user = Auth::user();
        $angkatanAktif = $this->getAngkatan();
        $angkatanAktif = array_reverse($angkatanAktif);
        $operator = $user->operator;
        $dosenwali = $user->dosenwali; 
        $departemen = $user->departemen;
        $mahasiswa = Mahasiswa::all();
        $skripsi = Skripsi::all(); // Assuming Skripsi is the model for skripsi data

        $rekapSkripsi = [];

        foreach ($mahasiswa as $mhs) {
            $skripsiMahasiswa = $skripsi->where('nim', $mhs->nim)->first();

            if ($skripsiMahasiswa && $skripsiMahasiswa->status_skripsi == 'lulus' && $mhs->angkatan == $angkatan) {
                // Filter for Dosen Wali
                if ($user->role=='dosenwali' && $mhs->dosenwali == $dosenwali->nama) {
                    $rekapSkripsi[] = [
                        'nim' => $mhs->nim,
                        'nama' => $mhs->nama,
                        'angkatan' => $mhs->angkatan,
                        'semester' => $skripsiMahasiswa->semester,
                        'nilai' => $skripsiMahasiswa->nilai,
                        'status_skripsi' => $skripsiMahasiswa->status_skripsi,
                    ];
                }
                // For other roles, include all students
                elseif ($user->role != 'dosenwali') {
                    $rekapSkripsi[] = [
                        'nim' => $mhs->nim,
                        'nama' => $mhs->nama,
                        'angkatan' => $mhs->angkatan,
                        'semester' => $skripsiMahasiswa->semester,
                        'nilai' => $skripsiMahasiswa->nilai,
                        'status_skripsi' => $skripsiMahasiswa->status_skripsi,
                    ];
                }
            }
        }

        return view('listmhs/skripsi', compact('user', 'rekapSkripsi', 'angkatanAktif', 'departemen', 'operator', 'dosenwali', 'angkatan'), ['page' => 'rekapskripsi','page2' => 'skripsi', 'data' => 'list', 'listStatus' => 'sudah']);
    }

    public function listbelumskripsi($angkatan)
    {
        $user = Auth::user();
        $angkatanAktif = $this->getAngkatan();
        $angkatanAktif = array_reverse($angkatanAktif);
        $operator = $user->operator;
        $dosenwali = $user->dosenwali; 
        $departemen = $user->departemen;
        $mahasiswa = Mahasiswa::all();
        $skripsi = Skripsi::all(); // Assuming Skripsi is the model for skripsi data

        $rekapSkripsi = [];

        foreach ($mahasiswa as $mhs) {
            $skripsiMahasiswa = $skripsi->where('nim', $mhs->nim)->first();

            if ((!$skripsiMahasiswa || $skripsiMahasiswa->status_skripsi !== 'lulus') && $mhs->angkatan == $angkatan) {
                // Filter for Dosen Wali
                if ($user->role=='dosenwali' && $mhs->dosenwali == $dosenwali->nama) {
                    $rekapSkripsi[] = [
                        'nim' => $mhs->nim,
                        'nama' => $mhs->nama,
                        'angkatan' => $mhs->angkatan,
                        'semester' => null,
                        'nilai' => null,
                        'status_skripsi' => null,
                    ];
                }
                // For other roles, include all students
                elseif ($user->role != 'dosenwali') {
                    $rekapSkripsi[] = [
                        'nim' => $mhs->nim,
                        'nama' => $mhs->nama,
                        'angkatan' => $mhs->angkatan,
                        'semester' => null,
                        'nilai' => null,
                        'status_skripsi' => null,
                    ];
                }
            }
        }

        return view('listmhs/skripsi', compact('user', 'rekapSkripsi', 'angkatanAktif', 'departemen', 'operator', 'dosenwali', 'angkatan'), ['page' => 'rekapskripsi','page2' => 'skripsi', 'data' => 'list', 'listStatus' => 'belum']);
    }

    public function liststatus($angkatan, $listStatus)
    {
        $user = Auth::user();
        $angkatanAktif = $this->getAngkatan();
        $angkatanAktif = array_reverse($angkatanAktif);
        $operator = $user->operator;
        $dosenwali = $user->dosenwali;
        $departemen = $user->departemen;

        // Filter mahasiswa berdasarkan angkatan dan status
        if ($user->role == 'dosenwali') {
            $mahasiswa = Mahasiswa::where('dosenwali', $dosenwali->nama)
                ->where('angkatan', $angkatan)
                ->where('status', $listStatus)
                ->get();
        } else {
            $mahasiswa = Mahasiswa::where('angkatan', $angkatan)
                ->where('status', $listStatus)
                ->get();
        }

        $rekapStatus = [];

        foreach ($angkatanAktif as $angktn) {
            $rekapStatus[$angktn] = [
                'aktif' => [],
                'cuti' => [],
                'mangkir' => [],
                'undur diri' => [],
                'lulus' => [],
                'do' => [],
                'meninggal dunia' => [],
            ];
        }

        foreach ($mahasiswa as $mhs) {
            $data = [
                'nim' => $mhs->nim,
                'nama' => $mhs->nama,
                'email' => $mhs->email,
                'alamat' => $mhs->alamat,
                'kabkota' => $mhs->kabkota,
                'provinsi' => $mhs->provinsi,
                'notelp' => $mhs->notelp,
                'angkatan' => $mhs->angkatan,
                'status' => $mhs->status,
                'dosenwali' => $mhs->dosenwali,
                'jalurmasuk' => $mhs->jalurmasuk,
                'foto' => $mhs->foto,
            ];

            if ($user->role == 'dosenwali' && $mhs->dosenwali == $dosenwali->nama) {
                $rekapStatus[$mhs->angkatan][$mhs->status][] = $data;
            } else {
                $rekapStatus[$mhs->angkatan][$mhs->status][] = $data;
            }
        }

        return view('listmhs/status', compact('user', 'rekapStatus', 'angkatanAktif', 'departemen', 'operator', 'dosenwali', 'listStatus', 'angkatan'), ['page' => 'rekapskripsi', 'page2' => 'status', 'data' => 'list']);
    }

    public function exportPDFListPKL($angkatan, $listStatus)
    {
        $user = Auth::user();
        $angkatanAktif = $this->getAngkatan();
        $angkatanAktif = array_reverse($angkatanAktif);
        $operator = $user->operator;
        $dosenwali = $user->dosenwali; 
        $departemen = $user->departemen;
        
        // Filter mahasiswa based on the role
        if ($user->role=='dosenwali') {
            $mahasiswa = Mahasiswa::where('angkatan', $angkatan)
                ->where('dosenwali', $dosenwali->nama)
                ->get();
        } else {
            $mahasiswa = Mahasiswa::where('angkatan', $angkatan)->get();
        }

        $pkl = PKL::all();

        $rekapPKL = [];

        // Inisialisasi array untuk setiap angkatan
        foreach ($angkatanAktif as $angkatanItem) {
            $rekapPKL[$angkatanItem] = [
                'sudah' => [],
                'belum' => []
            ];
        }
        
        foreach ($mahasiswa as $mhs) {
            $pklMahasiswa = $pkl->where('nim', $mhs->nim)->first();

            $data = [
                'nim' => $mhs->nim,
                'nama' => $mhs->nama,
                'email' => $mhs->email,
                'alamat' => $mhs->alamat,
                'kabkota' => $mhs->kabkota,
                'provinsi' => $mhs->provinsi,
                'notelp' => $mhs->notelp,
                'angkatan' => $mhs->angkatan,
                'status' => $mhs->status,
                'dosenwali' => $mhs->dosenwali,
                'jalurmasuk' => $mhs->jalurmasuk,
                'foto' => $mhs->foto,
                'semester' => null,
                'status_pkl' => null,
                'nilai' => null,
            ];

            if ($pklMahasiswa) {
                $data['semester'] = $pklMahasiswa->semester;
                $data['status_pkl'] = $pklMahasiswa->status_pkl;
                $data['nilai'] = $pklMahasiswa->nilai;
            }

            if ($pklMahasiswa && $pklMahasiswa->status_pkl == 'lulus') {
                $rekapPKL[$mhs->angkatan]['sudah'][] = $data;
            } else {
                $rekapPKL[$mhs->angkatan]['belum'][] = $data;
            }
        }

        $pdf = Pdf::loadView('cetak/listpkl', compact('rekapPKL', 'angkatanAktif', 'listStatus', 'angkatan'));

        return $pdf->download('rekap-pkl.pdf');
    }

    public function exportPDFListSkripsi($angkatan, $listStatus)
    {
        $user = Auth::user();
        $angkatanAktif = $this->getAngkatan();
        $angkatanAktif = array_reverse($angkatanAktif);
        $operator = $user->operator;
        $dosenwali = $user->dosenwali; 
        $departemen = $user->departemen;

        // Filter mahasiswa based on the role
        if ($user->role == 'dosenwali') {
            $mahasiswa = Mahasiswa::where('angkatan', $angkatan)
                ->where('dosenwali', $dosenwali->nama)
                ->get();
        } else {
            $mahasiswa = Mahasiswa::where('angkatan', $angkatan)->get();
        }

        $skripsi = Skripsi::all();

        $rekapSkripsi = [];

        // Inisialisasi array untuk setiap angkatan
        foreach ($angkatanAktif as $angkatanItem) {
            $rekapSkripsi[$angkatanItem] = [
                'sudah' => [],
                'belum' => []
            ];
        }

        foreach ($mahasiswa as $mhs) {
            $skripsiMahasiswa = $skripsi->where('nim', $mhs->nim)->first();

            $data = [
                'nim' => $mhs->nim,
                'nama' => $mhs->nama,
                'email' => $mhs->email,
                'alamat' => $mhs->alamat,
                'kabkota' => $mhs->kabkota,
                'provinsi' => $mhs->provinsi,
                'notelp' => $mhs->notelp,
                'angkatan' => $mhs->angkatan,
                'status' => $mhs->status,
                'dosenwali' => $mhs->dosenwali,
                'jalurmasuk' => $mhs->jalurmasuk,
                'foto' => $mhs->foto,
                'semester' => null,
                'status_skripsi' => null,
                'nilai' => null,
            ];

            if ($skripsiMahasiswa) {
                $data['semester'] = $skripsiMahasiswa->semester;
                $data['status_skripsi'] = $skripsiMahasiswa->status_skripsi;
                $data['nilai'] = $skripsiMahasiswa->nilai;
            }

            if ($skripsiMahasiswa && $skripsiMahasiswa->status_skripsi == 'lulus') {
                $rekapSkripsi[$mhs->angkatan]['sudah'][] = $data;
            } else {
                $rekapSkripsi[$mhs->angkatan]['belum'][] = $data;
            }
        }

        $pdf = Pdf::loadView('cetak/listskripsi', compact('rekapSkripsi', 'angkatanAktif', 'listStatus', 'angkatan'));

        return $pdf->download('rekap-skripsi.pdf');
    }

    public function exportPDFListStatus($angkatan, $listStatus)
    {
        $user = Auth::user();
        $angkatanAktif = $this->getAngkatan();
        $angkatanAktif = array_reverse($angkatanAktif);
        $operator = $user->operator;
        $dosenwali = $user->dosenwali;
        $departemen = $user->departemen;

        // Filter mahasiswa berdasarkan angkatan dan status
        if ($user->role == 'dosenwali') {
            $mahasiswa = Mahasiswa::where('dosenwali', $dosenwali->nama)
                ->where('angkatan', $angkatan)
                ->where('status', $listStatus)
                ->get();
        } else {
            $mahasiswa = Mahasiswa::where('angkatan', $angkatan)
                ->where('status', $listStatus)
                ->get();
        }

        $rekapStatus = [];

        foreach ($angkatanAktif as $angkatan) {
            $rekapStatus[$angkatan] = [
                'aktif' => [],
                'cuti' => [],
                'mangkir' => [],
                'undur diri' => [],
                'lulus' => [],
                'do' => [],
                'meninggal dunia' => [],
            ];
        }

        foreach ($mahasiswa as $mhs) {
            $data = [
                'nim' => $mhs->nim,
                'nama' => $mhs->nama,
                'email' => $mhs->email,
                'alamat' => $mhs->alamat,
                'kabkota' => $mhs->kabkota,
                'provinsi' => $mhs->provinsi,
                'notelp' => $mhs->notelp,
                'angkatan' => $mhs->angkatan,
                'status' => $mhs->status,
                'dosenwali' => $mhs->dosenwali,
                'jalurmasuk' => $mhs->jalurmasuk,
                'foto' => $mhs->foto,
            ];

            if ($user->role == 'dosenwali' && $mhs->dosenwali == $dosenwali->nama) {
                $rekapStatus[$mhs->angkatan][$mhs->status][] = $data;
            } else {
                $rekapStatus[$mhs->angkatan][$mhs->status][] = $data;
            }
        }

        $pdf = Pdf::loadView('cetak/liststatus', compact('rekapStatus', 'angkatanAktif', 'listStatus', 'angkatan'));

        return $pdf->download('list-status.pdf');
    }
}