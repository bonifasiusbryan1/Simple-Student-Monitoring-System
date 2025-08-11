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
    <link rel="stylesheet" href="/css/profile.css">
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
    <a class="d-flex" href="/dashboard">
        <div class="geser">
            <i class="bi bi-arrow-left-short"></i>
        </div>
        kembali
    </a>
</div>
<div class="container mt-3">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-center">
            <div class="fotoprofile">
                @if($mahasiswa->foto == null)
                    <img src="{{ asset('asset/fotoprofile/default/profile.png') }}" alt="foto profile">
                @elseif (file_exists(public_path('asset/fotoprofile/mahasiswa/' . $mahasiswa->foto)))
                    <img src="{{ asset('asset/fotoprofile/mahasiswa/' . $mahasiswa->foto) }}" alt="foto profile">
                @else
                    <img src="{{ asset('asset/fotoprofile/default/profile.png') }}" alt="foto profile">
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="grid-m">
                <div class="grid-item">
                    <label for="nama">Nama</label>
                    <div class="nama mt-2">{{ $mahasiswa->nama }}</div>
                </div>
                <div class="grid-item">
                    <label for="nim">NIM</label>
                    <div class="nim mt-2">{{ $mahasiswa->nim }}</div>
                </div>
                <div class="grid-item">
                    <label for="email">Email</label>
                    <div class="email mt-2">{{ $mahasiswa->email }}</div>
                </div>
                <div class="grid-item">
                    <label for="dosenwali">Dosen Wali</label>
                    <div class="dosenwali mt-2">{{ $mahasiswa->dosenwali }}</div>
                </div>
                <div class="grid-item">
                    <label for="angkatan">Angkatan</label>
                    <div class="angkatan mt-2">{{ $mahasiswa->angkatan }}</div>
                </div>
                <div class="grid-item">
                    <label for="status">Status</label>
                    <div class="status mt-2">{{ strtoupper($mahasiswa->status) }}</div>
                </div>
                <div class="grid-item">
                    <label for="notelp">Nomor Telepon</label>
                    <div class="notelp mt-2">{{ $mahasiswa->notelp }}</div>
                </div>
                <div class="grid-item">
                    <label for="alamat">Alamat</label>
                    <div class="alamat mt-2">{{ $mahasiswa->alamat }}</div>
                </div>
                <div class="grid-item">
                    <label for="kabkota">Kabupaten/Kota</label>
                    <div class="kabkota mt-2">{{ $mahasiswa->kabkota }}</div>
                </div>
                <div class="grid-item">
                    <label for="provinsi">Provinsi</label>
                    <div class="provinsi mt-2">{{ $mahasiswa->provinsi }}</div>
                </div>
                <div class="grid-item">
                    <label for="jalurmasuk">Jalur Masuk</label>
                    <div class="jalurmasuk mt-2">{{ strtoupper($mahasiswa->jalurmasuk) }}</div>
                </div>
                <div class="d-flex justify-content-between align-items-center grid-item-last grid-item-m">
                    @if ($user->role == 'mahasiswa')
                        <a href="/gantipassword" class="custom-gantipassword">GANTI PASSWORD</a> 
                    @endif
                    
                    <a @if ($user->role == 'mahasiswa') href="/editprofile/mahasiswa" @elseif ($user->role == 'operator') href="/editprofile/mahasiswa/{{ $mahasiswa->nim }}" @endif class="custom-simpan">EDIT PROFILE</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection