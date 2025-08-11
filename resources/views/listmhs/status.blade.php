@extends('layouts/main')

@section('css_navbar')
    <link rel="stylesheet" href="/css/navbar.css">
@endsection

@section('css_menu')
    <link rel="stylesheet" href="/css/menu.css">
@endsection

@section('css')
    <link rel="stylesheet" href="/css/rekap.css">
@endsection

@section('navbar')
    @include('partials/navbar')
@endsection

@section('menu')
    @include('menu/menu')
@endsection

@section('content')
<div class="container d-flex justify-content-end mt-4 kembali">
    <a class="d-flex" href="/rekap/mahasiswa/{{ $page2 }}">
        <div class="geser">
            <i class="bi bi-arrow-left-short"></i>
        </div>
        kembali
    </a>
</div>
<div class="container mt-3">
    <div class="container">
    </div>
    <div class="card mb-4">
        <div class="card-header justify-content-center align-items-center">
            <div class="container text-center w-50"> Daftar Mahasiswa {{ ucwords($listStatus) }} Informatika Fakultas Sains dan Matematika UNDIP Semarang
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered text-center">
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Alamat</th>
                        <th>Kabupaten/Kota</th>
                        <th>Provinsi</th>
                        <th>No Telp</th>
                        <th>Angkatan</th>
                        <th>Status</th>
                        <th>Dosen Wali</th>
                        <th>Jalur Masuk</th>
                    </tr>
                    @foreach ($rekapStatus as $angktn => $statusList)
                        @foreach ($statusList[$listStatus] as $mahasiswa)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $mahasiswa['nim'] }}</td>
                                <td>{{ $mahasiswa['nama'] }}</td>
                                <td>{{ $mahasiswa['email'] }}</td>
                                <td>{{ $mahasiswa['alamat'] }}</td>
                                <td>{{ $mahasiswa['kabkota'] }}</td>
                                <td>{{ $mahasiswa['provinsi'] }}</td>
                                <td>{{ $mahasiswa['notelp'] }}</td>
                                <td>{{ $mahasiswa['angkatan'] }}</td>
                                <td>{{ $mahasiswa['status'] }}</td>
                                <td>{{ $mahasiswa['dosenwali'] }}</td>
                                <td>{{ $mahasiswa['jalurmasuk'] }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </table>
            </div>
            <div class="d-flex justify-content-end align-items-center">
                <a href="/cetak/list/status/{{ $angkatan }}/{{ $listStatus }}" class="btn-cetak">Cetak</a>
            </div>
        </div>
    </div>
</div>
@endsection

