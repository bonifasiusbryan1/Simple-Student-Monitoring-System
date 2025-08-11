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
                <img src="{{ asset('asset/fotoprofile/dosenwali/' . $dosenwali->foto) }}" alt="foto profile">
            </div>
            <div>
                <div class="row mb-1">
                    <div class="col text-light">
                        {{ $dosenwali->nama }}
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        NIP : {{ $dosenwali->nip }}
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
        <div class="grid-menu">
            <a href="/verifikasi/irs" class="grid-irs">
                <i class="bi bi-card-checklist"></i>
                Verifikasi IRS
            </a>
            <a href="/verifikasi/khs" class="grid-khs">
                <i class="bi bi-award"></i>
                Verifikasi KHS
            </a>
            <a href="/verifikasi/pkl" class="grid-pkl">
                <i class="bi bi-briefcase"></i>
                Verifikasi PKL
            </a>
            <a href="/verifikasi/skripsi" class="grid-skripsi">
                <i class="bi bi-mortarboard"></i>
                Verifikasi Skripsi
            </a>
            <a href="/progresstudi" class="grid-progresstudi">
                <i class="bi bi-bar-chart-line"></i>
                Progress Studi Mahasiswa
            </a>
            <a href="/rekap/mahasiswa" class="grid-progresstudi">
                <i class="bi bi-card-heading"></i>
                Rekap Mahasiswa
            </a>
            <a href="/rekap/mahasiswa/pkl" class="grid-progresstudi">
                <i class="bi bi-bookmarks"></i>
                Rekap PKL Mahasiswa
            </a>
            <a href="/rekap/mahasiswa/skripsi" class="grid-progresstudi">
                <i class="bi bi-clipboard2-data"></i>
                Rekap Skripsi Mahasiswa
            </a>
            <a href="/rekap/mahasiswa/status" class="grid-progresstudi">
                <i class="bi bi-card-heading"></i>
                Rekap Status Mahasiswa
            </a>
        </div>
    </div>
@endsection