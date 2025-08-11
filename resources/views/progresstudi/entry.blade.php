@extends('layouts/main')

@section('css_navbar')
    <link rel="stylesheet" href="/css/navbar.css">
@endsection

@section('css_popup')
    <link rel="stylesheet" href="/css/popup.css">
@endsection

@section('css_menu')
    <link rel="stylesheet" href="/css/menu.css">
@endsection

@section('css')
    <link rel="stylesheet" href="/css/entryprogresstudi.css">
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
<div class="container p-0 d-flex justify-content-between text-wrap mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-center">
            Entry Progres Studi Mahasiswa
        </div>
        <div class="card-body">
            <h5 class="text-center">Data Akun Mahasiswa</h5>
            <div class="container border-0 p-0 mt-2 mb-2">
                <form action="/cari/akunmahasiswa" method="GET">
                    <div class="col-sm-3">
                        <input type="search" id="search" name="search" class="form-control" placeholder="Pencarian">
                    </div>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr class="text-center">
                        <th>NIM/Username</th>
                        <th>Nama</th>
                        <th>Angkatan</th>
                        <th>Dosen Wali</th>
                        <th>Entry</th>
                    </tr>
                    @foreach($mahasiswa as $mhs)
                        <tr>
                            <td class="text-center">{{ $mhs->nim }}</td>
                            <td>{{ $mhs->nama }}</td>
                            <td class="text-center">{{ $mhs->angkatan }}</td>
                            <td>{{ $mhs->dosenwali }}</td>
                            <td>
                                <a href="/entry/irs/{{ $mhs->nim }}">IRS</a>
                                @if(count($semesterList[$mhs->nim]) > 1)
                                    <a href="/entry/khs/{{ $mhs->nim }}">KHS</a>
                                @endif
                                @if($semesterPKL[$mhs->nim] != null)
                                    <a href="/entry/pkl/{{ $mhs->nim }}">PKL</a>
                                @endif
                                @if($semesterSkripsi[$mhs->nim] != null)
                                    <a href="/entry/skripsi/{{ $mhs->nim }}">Skripsi</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            @if(request('search'))
                <a href="/generate/akunmahasiswa" class="btn-custom-back">Kembali</a>
            @endif
        </div>
    </div>
</div>
@endsection