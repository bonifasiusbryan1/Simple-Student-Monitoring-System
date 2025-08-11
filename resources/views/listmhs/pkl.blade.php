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
    <link rel="stylesheet" href="/css/rekap.css">
@endsection

@section('js_popup')
    <script src="/js/popup.js"></script>
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
<div class="container d-flex justify-content-end mt-4 kembali">
    <a class="d-flex" href="/rekap/mahasiswa/{{ $page2 }}">
        <div class="geser">
            <i class="bi bi-arrow-left-short"></i>
        </div>
        kembali
    </a>
</div>
<div class="container mt-3">
    <div class="container ">
        
    </div>
    <div class="card mb-4">
        <div class="card-header justify-content-center align-items-center">
            <div class="container text-center w-50"> Daftar 
                @if ($listStatus == 'sudah')
                    Sudah
                @elseif ($listStatus == 'belum')
                    Belum
                @endif
                Lulus PKL Mahasiswa Informatika Fakultas Sains dan Matematika UNDIP Semarang
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                @if ($listStatus == 'sudah')
                    <table class="table table-bordered text-center">
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Angkatan</th>
                            <th>Semester PKL</th>
                            <th>Nilai</th>
                        </tr>
                        @foreach ($rekapPKL as $index => $mahasiswa)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $mahasiswa['nim'] }}</td>
                                <td>{{ $mahasiswa['nama'] }}</td>
                                <td>{{ $mahasiswa['angkatan'] }}</td>
                                <td>{{ $mahasiswa['semester'] }}</td>
                                <td>{{ $mahasiswa['nilai'] }}</td>
                            </tr>
                        @endforeach
                    </table>
                @elseif ($listStatus == 'belum')
                    <table class="table table-bordered text-center">
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Angkatan</th>
                        </tr>
                        @foreach ($rekapPKL as $index => $mahasiswa)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $mahasiswa['nim'] }}</td>
                                <td>{{ $mahasiswa['nama'] }}</td>
                                <td>{{ $mahasiswa['angkatan'] }}</td>
                            </tr>
                        @endforeach
                    </table>
                @endif

                <div class="d-flex justify-content-end align-items-center">
                    <a href="/cetak/list/pkl/{{ $angkatan }}/{{ $listStatus }}" class="btn-cetak">Cetak</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection