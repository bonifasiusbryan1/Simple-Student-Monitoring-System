@extends('layouts/main')

@section('css_navbar')
    <link rel="stylesheet" href="/css/navbar.css">
@endsection

@section('css_popup')
    <link rel="stylesheet" href="/css/popup.css">
@endsection

@section('css')
    <link rel="stylesheet" href="/css/dashboard.css">
@endsection

@section('js_popup')
    <script src="/js/popup.js"></script>
@endsection

@section('navbar')
    @include('partials/navbar')
@endsection

@section('content')
@if(session('success'))
    <div class="popup" id="successPopup">
        <div class="alert alert-success fade show" role="alert">
            {{ session('success') }}
        </div>
    </div>
@endif
<div class="container container-profile d-flex justify-content-between mt-4">
    <div class="d-flex justify-content-between align-items-center">
        <div class="fotoprofile">
            @if (file_exists(public_path('asset/fotoprofile/mahasiswa/' . $mahasiswa->foto)))
                <img src="{{ asset('asset/fotoprofile/mahasiswa/' . $mahasiswa->foto) }}" alt="foto profile">
            @else
                <img src="{{ asset('asset/fotoprofile/default/profile.png') }}" alt="foto profile">
            @endif
        </div>
        <div>
            <div class="row mb-1">
                <div class="col text-light">
                    {{ $mahasiswa->nama }}
                </div>
            </div>
            <div class="row">
                <div class="col">
                    NIM : {{ $mahasiswa->nim }}
                </div>
            </div>
        </div>
    </div>
    <a href="/editprofile/{{ auth()->user()->role }}" class="edit-profile mt-2">
        <i class="bi bi-pencil"></i>
        <small>Edit Profile</small>
    </a>
</div>
<div class="container mt-4 p-0">
    <div class="grid">
        <div class="container">
            <div class="akademik">
                <div class="statusAkademik">
                    <i class="bi bi-bank"></i>
                    Informasi Akademik
                </div>
                <div class="grid-informasi">
                    <div class="dosenwali">
                        Dosen Wali :
                        <div class="nama">
                            {{ $mahasiswa->dosenwali }}
                        </div>
                    </div>
                    <div class="angkatan">
                        Angkatan : 
                        <div class="angktn">
                            {{ $mahasiswa->angkatan }}
                        </div>
                    </div>
                    <div class="status">
                        Status : 
                        <div class="stts">
                            {{ strtoupper($mahasiswa->status) }} 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid-menu">
            <a href="/irs/mahasiswa" class="grid-irs">
                <i class="bi bi-card-checklist"></i>
                Isian Rencana Studi (IRS)
            </a>
            @if ($semesterAktif > 1)
                <a href="/khs/mahasiswa" class="grid-khs">
                    <i class="bi bi-award"></i>
                    Kartu Hasil Studi (KHS)
                </a>
            @endif
            @if (count($semesterPKL) != 0)
                <a href="/pkl/mahasiswa" class="grid-pkl">
                    <i class="bi bi-briefcase"></i>
                    Praktik Kerja Lapangan (PKL)
                </a>
            @endif
            @if (count($semesterSkripsi) != 0)
                <a href="/skripsi/mahasiswa" class="grid-skripsi">
                <i class="bi bi-mortarboard"></i>
                Skripsi
            </a>
            @endif
        </div>
    </div>
</div>
<div class="container mt-4 p-0 text-center">
    <label for="semester" class="mb-3">Semester</label>
    <div class="grid-semester">
        @foreach ($semesterData as $i => $data)
            @php
                $semester = $data['semester'];
                $class = $data['class'];
                
                $irsData = $irs ? $irs->where('semester', $semester)->first() : null;
                $khsData = $khs ? $khs->where('semester', $semester)->first() : null;
                $pklData = $pkl? $pkl->where('semester', $semester)->where('status', '1')->first() : null;
                $skripsiData = $skripsi ? $skripsi->where('semester', $semester)->where('status', '1')->first() : null;
            @endphp

            @if ($class == 'red')
                <div class="grid-item {{ $class }}">{{ $i }}</div>
            @else
                <button class="grid-item {{ $class }}" data-bs-target="#irs{{ $i }}" data-bs-toggle="modal">{{ $i }}</button>
            @endif

            {{-- IRS Modal --}}
            <div class="modal fade" id="irs{{ $i }}" aria-hidden="true" aria-labelledby="irsLabel" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header text-center p-2 pl-5">
                            <h1 class="modal-title fs-5" id="irsLabel">IRS</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="smt-modal">
                                {{ $irsData ? $irsData->semester : '' }}
                            </div>
                            <div class="irs-modal mt-4 mb-2">
                                {{ $irsData ? $irsData->jumlahsks : '' }} SKS
                            </div>
                            <a href="/irs/mahasiswa" class="modal-detail">Detail IRS</a>
                        </div>
                        <div class="modal-footer p-2">
                            @if($khsData)
                                <button class="btn-custom-lihat" data-bs-target="#khs{{ $i }}" data-bs-toggle="modal">Lihat KHS</button>
                            @endif
                            @if($pklData)
                                <button class="btn-custom-lihat" data-bs-target="#pkl{{ $i }}" data-bs-toggle="modal">Lihat PKL</button>
                            @endif
                            @if($skripsiData)
                                <button class="btn-custom-lihat" data-bs-target="#skripsi{{ $i }}" data-bs-toggle="modal">Lihat Skripsi</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            {{-- KHS Modal --}}
            <div class="modal fade" id="khs{{ $i }}" aria-hidden="true" aria-labelledby="khsLabel" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header text-center p-2">
                            <h1 class="modal-title fs-5 ml-5" id="khsLabel">KHS</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="smt-modal">
                                {{ $khsData ? $khsData->semester : '' }}
                            </div>
                            <table class="table table-sm table-borderless mt-5 mb-4">
                                <tr>
                                    <td>SKS Semester</td>
                                    <td>:</td>
                                    <td>{{ $khsData ? $khsData->skss : '' }} SKS</td>
                                </tr>
                                <tr>
                                    <td>IP Semester</td>
                                    <td>:</td>
                                    <td>{{ $khsData ? $khsData->ips : '' }}</td>
                                </tr>
                                <tr>
                                    <td>SKS Kumulatif</td>
                                    <td>:</td>
                                    <td>{{ $khsData ? $khsData->skss : '' }}</td>
                                </tr>
                                <tr>
                                    <td>IP Kumulatif</td>
                                    <td>:</td>
                                    <td>{{ $khsData ? $khsData->ipk : '' }}</td>
                                </tr>
                            </table>
                            <a href="/khs/mahasiswa" class="modal-detail">Detail KHS</a>
                        </div>
                        <div class="modal-footer p-2">
                            <button class="btn-custom-lihat" data-bs-target="#irs{{ $i }}" data-bs-toggle="modal">Lihat IRS</button>
                            @if($pklData)
                                <button class="btn-custom-lihat" data-bs-target="#pkl{{ $i }}" data-bs-toggle="modal">Lihat PKL</button>
                            @endif
                            @if($skripsiData)
                                <button class="btn-custom-lihat" data-bs-target="#skripsi{{ $i }}" data-bs-toggle="modal">Lihat Skripsi</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- PKL Modal --}}
            <div class="modal fade" id="pkl{{ $i }}" aria-hidden="true" aria-labelledby="pklLabel" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header text-center p-2 pl-5">
                            <h1 class="modal-title fs-5" id="pklLabel">PKL</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-sm table-borderless mt-5 mb-4">
                                <tr>
                                    <td>Semester PKL</td>
                                    <td>:</td>
                                    <td>{{ $pklData ? $pklData->semester : '' }}</td>
                                </tr>
                                <tr>
                                    <td>Nilai</td>
                                    <td>:</td>
                                    <td>{{ $pklData ? $pklData->nilai : '' }}</td>
                                </tr>
                                <tr>
                                    <td>Status PKL</td>
                                    <td>:</td>
                                    <td>{{ $pklData ? $pklData->status_pkl : '' }}</td>
                                </tr>
                            </table>
                            <a href="/pkl/mahasiswa" class="modal-detail">Detail PKL</a>
                        </div>
                        <div class="modal-footer p-2">
                            <button class="btn-custom-lihat" data-bs-target="#irs{{ $i }}" data-bs-toggle="modal">Lihat IRS</button>
                            @if($khsData)
                                <button class="btn-custom-lihat" data-bs-target="#khs{{ $i }}" data-bs-toggle="modal">Lihat KHS</button>
                            @endif
                            @if($skripsiData)
                                <button class="btn-custom-lihat" data-bs-target="#skripsi{{ $i }}" data-bs-toggle="modal">Lihat Skripsi</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Skripsi Modal --}}
            <div class="modal fade" id="skripsi{{ $i }}" aria-hidden="true" aria-labelledby="skripsiLabel" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header text-center p-2 pl-5">
                            <h1 class="modal-title fs-5" id="skripsiLabel">Skripsi</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-sm table-borderless mt-5 mb-4">
                                <tr>
                                    <td>Semester Skripsi</td>
                                    <td>:</td>
                                    <td>{{ $skripsiData ? $skripsiData->semester : '' }}</td>
                                </tr>
                                <tr>
                                    <td>Nilai</td>
                                    <td>:</td>
                                    <td>{{ $skripsiData ? $skripsiData->nilai : '' }}</td>
                                </tr>
                                <tr>
                                    <td>Status Skripsi</td>
                                    <td>:</td>
                                    <td>{{ $skripsiData ? $skripsiData->status_skripsi : '' }}</td>
                                </tr>
                            </table>
                            <a href="/skripsi/mahasiswa" class="modal-detail">Detail Skripsi</a>
                        </div>
                        <div class="modal-footer p-2">
                            <button class="btn-custom-lihat" data-bs-target="#irs{{ $i }}" data-bs-toggle="modal">Lihat IRS</button>
                            @if($khsData)
                                <button class="btn-custom-lihat" data-bs-target="#khs{{ $i }}" data-bs-toggle="modal">Lihat KHS</button>
                            @endif
                            @if($pklData)
                                <button class="btn-custom-lihat" data-bs-target="#pkl{{ $i }}" data-bs-toggle="modal">Lihat PKL</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection