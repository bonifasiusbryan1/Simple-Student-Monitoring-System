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
    <link rel="stylesheet" href="/css/verifikasi.css">
@endsection

@section('js_popup')
    <script src="/js/popup.js"></script>
@endsection

@section('js')
    <script src="/js/verifikasi.js"></script>   
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
            Verifikasi Kartu Hasil Studi (KHS)
        </div>
        <div class="card-body">
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
            <hr>
            <div class="container border-0 p-0 mt-2 mb-2">
                <form action="/verifikasi/cari/{{ $page }}" method="GET">
                    <div class="col-sm-3">
                        <input type="search" id="search" name="search" class="form-control" placeholder="Cari Nama/NIM">
                    </div>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered text-center">
                    <tr data-list>
                        <th>Nama</th>
                        <th>NIM</th>
                        <th>Angkatan</th>
                        <th>Semester</th>
                        <th>IP</th>
                        <th>SKS Semester</th>
                        <th>IPK</th>
                        <th>SKS Kumulatif</th>
                        <th>File KHS</th>
                        <th>Verifikasi</th>
                        <th>Edit</th>
                    </tr>
                    @foreach ($data as $item)
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
                                <td>
                                    @if ($mhskhs['status'] == '1')
                                        <a href="/batalverifikasi/khs/{{ $item['mahasiswa']['nim'] }}/{{ $mhskhs['semester'] }}" class="btn-custom-batalverif">Batalkan Verifikasi</a>
                                    @else
                                        <a href="/verifikasi/khs/{{ $item['mahasiswa']['nim'] }}/{{ $mhskhs['semester'] }}" class="btn-custom-verif">Verifikasi</a>
                                    @endif
                                </td>
                                <td>
                                    <a href="/verifikasi/edit/khs/{{ $item['mahasiswa']['nim'] }}/{{ $mhskhs['semester'] }}" class="btn-custom-edit">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </table>
            </div>
            <div id="mahasiswanull" class="mahasiswanull">ops.. tidak ada mahasiswa yang tersedia</div>
            <div class="d-flex justify-content-start align-items-start mt-2">
                @if(request('search'))
                    <a href="/verifikasi/{{ $page }}" class="btn-custom-back">Kembali</a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

