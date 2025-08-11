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
    <a class="d-flex" href="/dashboard">
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
            <div class="container text-center w-50"> Rekap Progress Skripsi Mahasiswa Informatika Fakultas Sains dan Matematika UNDIP Semarang
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-center ">
                    <tr>
                        <th class="angkatan" colspan="{{ count($angkatanAktif) * 2 }}">Angkatan</th>
                    </tr>
                    <tr>
                        @foreach($angkatanAktif as $angkatan)
                            <td colspan="2">{{ $angkatan }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        @foreach($angkatanAktif as $angkatan)
                            <td>Sudah</td>
                            <td>Belum</td>
                        @endforeach
                    </tr>
                    <tr>
                        @foreach($angkatanAktif as $angkatan)
                            <td class="p-0">
                                @if(count($rekapSkripsi[$angkatan]['sudah']) > 0)
                                    <a href="/list/skripsi/{{ $angkatan }}/sudah">
                                        {{ count($rekapSkripsi[$angkatan]['sudah']) }}
                                    </a>
                                @else
                                    <div class="p-2">0</div>
                                @endif
                            </td>
                            <td class="p-0">
                                @if(count($rekapSkripsi[$angkatan]['belum']) > 0)
                                    <a href="/list/skripsi/{{ $angkatan }}/belum">
                                        {{ count($rekapSkripsi[$angkatan]['belum']) }}
                                    </a>
                                @else
                                    <div class="p-2">0</div>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                </table>
                <div class="d-flex justify-content-end align-items-center">
                    <a href="/cetak/rekap/skripsi" class="btn-cetak">Cetak</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection