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
    <div class="card mb-5">
        <div class="card-header d-flex justify-content-center">
            <div class="fotoprofile">
                <img src="{{ asset('asset/fotoprofile/dosenwali/' . $dosenwali->foto) }}" alt="foto profile">
            </div>
        </div>
        <div class="card-body">
            <div class="grid">
                <div class="grid-item">
                    <label for="nama">Nama</label>
                    <div class="nama mt-2">{{ $dosenwali->nama }}</div>
                </div>
                <div class="grid-item">
                    <label for="nim">NIP</label>
                    <div class="nim mt-2">{{ $dosenwali->nip }}</div>
                </div>
                <div class="grid-item">
                    <label for="email">Email</label>
                    <div class="email mt-2">{{ $dosenwali->email }}</div>
                </div>
                <div class="grid-item">
                    <label for="notelp">Nomor Telepon</label>
                    <div class="notelp mt-2">{{ $dosenwali->notelp }}</div>
                </div>
                <div class="grid-item">
                    <label for="alamat">Alamat</label>
                    <div class="alamat mt-2">{{ $dosenwali->alamat }}</div>
                </div>
                <div class="grid-item">
                    <label for="kabkota">Kabupaten/Kota</label>
                    <div class="kabkota mt-2">{{ $dosenwali->kabkota }}</div>
                </div>
                <div class="grid-item">
                    <label for="provinsi">Provinsi</label>
                    <div class="provinsi mt-2">{{ $dosenwali->provinsi }}</div>
                </div>
                <div class="d-flex justify-content-between align-items-center grid-item-last grid-item-nm">
                    <a href="/gantipassword" class="custom-gantipassword">GANTI PASSWORD</a> 
                    <a href="/editprofile/dosenwali" class="custom-simpan">EDIT PROFILE</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection