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
    <link rel="stylesheet" href="/css/pkl.css">
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
<div class="container p-0 mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-center">
            Verifikasi Praktik Kerja Lapangan (PKL)
        </div>
        <div class="card-body">
            <form action="/verifikasi/pkl/{{ $mahasiswa->nim }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid-m-pkl">
                    <div class="grid-item">
                        <label for="nama">Nama </label>
                        <div class="approved mt-2">{{ $mahasiswa->nama }}</div>
                    </div>
                    <div class="grid-item">
                        <label for="nim">NIM </label>
                        <div class="approved mt-2">{{ $mahasiswa->nim }}</div>
                    </div>
                    <div class="grid-item">
                        <label for="semester">Semester</label>
                        <select name="semester" class="semester mt-2">
                            @foreach ($semesterPKL as $semester)
                                <option value="{{ $semester }}" {{ old('semester', $pkl->semester) == $semester ? 'selected' : '' }}>
                                    {{ $semester }}
                                </option>
                            @endforeach
                        </select>
                        @error('semester')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="grid-item">
                        <label for="nilai">Nilai PKL</label>
                        <input type="text" name="nilai" class="nilai mt-2" id="nilai" value="{{ old('nilai', $pkl->nilai) }}">
                        @error('nilai')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-between align-items-start grid-item-last">
                        <a href="/batalverifikasi/pkl/{{ $mahasiswa->nim }}" class="btn-custom-verifikasi">Batalkan Verifikasi</a>
                        <a href="/export/filepkl/{{ $mahasiswa->nim }}" data-download-link id="downloadLink">Download File Upload</a>
                    </div>
                    <!-- Button trigger modal -->
                    <div class="d-flex justify-content-between align-items-start grid-item-last">
                        <button type="button" class="btn-custom-simpan" data-bs-toggle="modal" data-bs-target="#simpan">
                            SIMPAN
                        </button>
                        <a href="/verifikasi/pkl" class="btn-custom-batal" >BATAL</a>
                    </div>
                    
                    <!-- Modal -->
                    <div class="modal fade" id="simpan" tabindex="-1" aria-labelledby="simpanLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h1 class="modal-title fs-5" id="simpanLabel">Konfirmasi Perubahan</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Tetap simpan Perubahan data pkl?
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn-custom-modal btn-cm-batal" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class=" btn-custom-modal btn-cm-simpan">Simpan</button>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection