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
    <link rel="stylesheet" href="/css/skripsi.css">
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
            Skripsi
        </div>
        <div class="card-body">
            <form action="/skripsi/{{ auth()->user()->role }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid-identitas">
                    <div class="grid-item">
                        <label for="nama">Nama </label>
                        <div class="approved mt-2">{{ $mahasiswa->nama }}</div>
                    </div>
                    <div class="grid-item">
                        <label for="nim">NIM </label>
                        <div class="approved mt-2">{{ $mahasiswa->nim }}</div>
                    </div>
                </div>
                <div class="grid-m-skripsi">
                    <div class="grid-item">
                        <label for="semester">Semester</label>
                        <select name="semester" class="semester mt-2" id="semesterSelect">
                            @foreach ($semesterSkripsi as $semester)
                                <option value="{{ $semester }}" {{ old('semester', optional($skripsi)->semester) == $semester ? 'selected' : '' }}>
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
                    <div class="grid-item" id="nilai">
                        <label for="nilai">Nilai skripsi</label>
                        <input type="text" name="nilai" class="nilai mt-2" value="{{$skripsi ? $skripsi->nilai : old('nilai') }}">
                        @error('nilai')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="grid-item" id="tglsidang">
                        <label for="tglsidang">Tanggal Sidang</label>
                        <input type="date" name="tglsidang" class="tglsidang mt-2" value="{{$skripsi ? $skripsi->tglsidang : old('tglsidang') }}">
                        @error('tglsidang')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="grid-item" id="fileskripsi">
                        <label for="fileskripsi">Upload File Skripsi</label>
                        <input type="file" name="fileskripsi" class="fileskripsi mt-2">
                        @error('fileskripsi')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <!-- Button trigger modal -->
                    <div class="d-flex justify-content-between align-items-end grid-item-m">
                        <button type="button" class="btn-custom-simpan-op" data-bs-toggle="modal" data-bs-target="#simpan">
                            SIMPAN
                        </button>
                        <a href="/dashboard" class="btn-custom-batal-op" >BATAL</a>
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
                                Tetap simpan perubahan data skripsi anda?
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