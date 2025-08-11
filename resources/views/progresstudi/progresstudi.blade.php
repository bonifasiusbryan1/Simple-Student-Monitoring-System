@extends('layouts/main')

@section('css_navbar')
    <link rel="stylesheet" href="/css/navbar.css">
@endsection

@section('css_menu')
    <link rel="stylesheet" href="/css/menu.css">
@endsection

@section('css_popup')
    <link rel="stylesheet" href="/css/popup.css">
@endsection

@section('css')
    <link rel="stylesheet" href="/css/progresstudi.css">
@endsection

@section('js_popup')
    <script src="/js/popup.js"></script>
@endsection

@section('js')
    <script src="/js/progresstudi.js"></script>   
@endsection

@section('navbar')
    @include('partials/navbar')
@endsection

@section('menu')
    @include('menu/menu')
@endsection

@section('content')
@if(session('success'))
    <div class="popup" id="successPopup">
        <div class="alert alert-success fade show" role="alert">
            {{ session('success') }}
        </div>
    </div>
@endif
<div class="container mt-4">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-center">
            Progress Studi Mahasiswa
        </div>
        <div class="card-body">
            <div class="grid-progresstudi">
                <div class="grid-angkatan">
                    <div class="d-flex align-items-center pl-4">
                        <label for="angkatan">
                            Pilih Angkatan :
                        </label>
                    </div>
                    <select id="angkatanSelect" name="angkatan" class="angkatan mt-2">
                        <option value="semua">Semua Angkatan</option>
                        @foreach ($angkatanAktif as $tahun)
                            <option value="{{ $tahun }}">Angkatan {{ $tahun }}</option>
                        </option>
                        @endforeach
                    </select>
                    @error('angkatan')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="grid-pilih-menu">
                    <div></div>
                    <div class="d-flex align-items-center pl-4">
                        <label for="pilihmenu">
                            Pilih Menu :
                        </label>
                    </div>
                    <select id="pilihmenuSelect" name="pilihmenu" class="pilihmenu mt-2">
                        <option value="irs">IRS</option>
                        <option value="khs">KHS</option>
                        <option value="pkl">PKL</option>
                        <option value="skripsi">Skripsi</option>
                    </select>
                    @error('pilihmenu')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <hr>
            <div class="container border-0 p-0 mt-2 mb-2">
                <form action="/progresstudi/cari/{{ $page }}" method="GET">
                    <div class="col-sm-3">
                        <input type="search" id="search" name="search" class="form-control" placeholder="Cari Nama/NIM">
                    </div>
                </form>
            </div>
            
            <div class="table-responsive" data-menu="irs">
                <table class="table table-bordered text-center">
                    <tr data-list="irs">
                        <th>Nama</th>
                        <th>NIM</th>
                        <th>Angkatan</th>
                        <th>Semester</th>
                        <th>Jumlah SKS</th>
                        <th>File IRS</th>
                    </tr>
                    @foreach ($dataIrs as $item)
                        @foreach ($item['irs'] as $mhsirs)
                            <tr data-angkatan="{{ $item['mahasiswa']['angkatan'] }}">
                                <td>{{ $item['mahasiswa']['nama'] }}</td>
                                <td>{{ $item['mahasiswa']['nim'] }}</td>
                                <td>{{ $item['mahasiswa']['angkatan'] }}</td>
                                <td>{{ $mhsirs['semester'] }}</td>
                                <td>{{ $mhsirs['jumlahsks'] }}</td>
                                <td>
                                    <a href="/export/fileirs/{{ $item['mahasiswa']['nim'] }}/{{ $mhsirs['semester'] }}" class="download">Download</a>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </table>
            </div>

            {{-- KHS --}}
            <div class="table-responsive" data-menu="khs">
                <table class="table table-bordered text-center">
                    <tr data-list="khs">
                        <th>Nama</th>
                        <th>NIM</th>
                        <th>Angkatan</th>
                        <th>Semester</th>
                        <th>IP</th>
                        <th>SKS Semester</th>
                        <th>IPK</th>
                        <th>SKS Kumulatif</th>
                        <th>File KHS</th>
                    </tr>
                    @foreach ($dataKhs as $item)
                        @foreach ($item['khs'] as $mhskhs)
                            <tr data-angkatan="{{ $item['mahasiswa']['angkatan'] }}">
                                <td>{{ $item['mahasiswa']['nama'] }}</td>
                                <td>{{ $item['mahasiswa']['nim'] }}</td>
                                <td>{{ $item['mahasiswa']['angkatan'] }}
                                <td>{{ $mhskhs['semester'] }}</td>
                                <td>{{ $mhskhs['ips'] }}</td>
                                <td>{{ $mhskhs['skss'] }}</td>
                                <td>{{ $mhskhs['ipk'] }}</td>
                                <td>{{ $mhskhs['sksk'] }}</td>
                                <td>
                                    <a href="/export/filekhs/{{ $item['mahasiswa']['nim'] }}/{{ $mhskhs['semester'] }}" class="download">Download</a>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </table>
            </div>

            {{-- PKL --}}
            <div class="table-responsive" data-menu="pkl">
                <table class="table table-bordered text-center">
                    <tr data-list="pkl">
                        <th>Nama</th>
                        <th>NIM</th>
                        <th>Angkatan</th>
                        <th>Semester</th>
                        <th>Nilai</th>
                        <th>File IRS</th>
                    </tr>
                    @foreach ($dataPkl as $item)
                        @foreach ($item['pkl'] as $mhspkl)
                            <tr data-angkatan="{{ $item['mahasiswa']['angkatan'] }}">
                                <td>{{ $item['mahasiswa']['nama'] }}</td>
                                <td>{{ $item['mahasiswa']['nim'] }}</td>
                                <td>{{ $item['mahasiswa']['angkatan'] }}</td>
                                <td>{{ $mhspkl['semester'] }}</td>
                                <td>{{ $mhspkl['nilai'] }}</td>
                                <td>
                                    <a href="/export/filepkl/{{ $item['mahasiswa']['nim'] }}" class="download">Download</a>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </table>
            </div>

            {{-- Skripsi --}}
            <div class="table-responsive" data-menu="skripsi">
                <table class="table table-bordered text-center">
                    <tr data-list="skripsi">
                        <th>Nama</th>
                        <th>NIM</th>
                        <th>Angkatan</th>
                        <th>Semester</th>
                        <th>Nilai</th>
                        <th>File IRS</th>
                    </tr>
                    @foreach ($dataSkripsi as $item)
                        @foreach ($item['skripsi'] as $mhsskripsi)
                            <tr data-angkatan="{{ $item['mahasiswa']['angkatan'] }}">
                                <td>{{ $item['mahasiswa']['nama'] }}</td>
                                <td>{{ $item['mahasiswa']['nim'] }}</td>
                                <td>{{ $item['mahasiswa']['angkatan'] }}</td>
                                <td>{{ $mhsskripsi['semester'] }}</td>
                                <td>{{ $mhsskripsi['nilai'] }}</td>
                                <td>
                                    <a href="/export/fileskripsi/{{ $item['mahasiswa']['nim'] }}" class="download">Download</a>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </table>
            </div>

            <div id="mahasiswanull" class="mahasiswanull">ops.. tidak ada mahasiswa yang tersedia</div>
            @if(request('search'))
                <a href="/progresstudi" class="btn-custom-back">Kembali</a>
            @endif
        </div>
    </div>
</div>
@endsection

