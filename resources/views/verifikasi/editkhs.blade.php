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
    <link rel="stylesheet" href="/css/khs.css">
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
            Verifikasi Kartu Hasil Studi (KHS)
        </div>
        <div class="card-body">
            <form action="/verifikasi/khs/{{ $mahasiswa->nim }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid-m-khs">
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
                        <select name="semester" class="semester mt-2" id="semesterSelect">
                            @if ($mahasiswa->status == 'lulus')
                                @for ($i = 1; $i <= $semesterAktif; $i++)
                                    <option value="{{ $i }}" @if($i == old('semester', $semester)) selected @endif>{{ $i }}</option>
                                @endfor
                            @else
                                @for ($i = 1; $i <= $semesterAktif-1; $i++)
                                    <option value="{{ $i }}" @if($i == old('semester', $semester)) selected @endif>{{ $i }}</option>
                                @endfor
                            @endif
                            
                        </select>
                        @error('semester')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="grid-item">
                        <label for="skss">SKS Semester</label>
                        <input type="text" name="skss" class="skss mt-2" id="skss" value="{{ old('skss', $khs->skss) }}">
                        @error('skss')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="grid-item">
                        <label for="ips">IP Semester</label>
                        <input type="text" name="ips" class="ips mt-2" id="ips" value="{{ old('ips', $khs->ips) }}">
                        @error('ips')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="grid-item">
                        <label for="sksk">SKS Kumulatif</label>
                        <input type="text" name="sksk" class="sksk mt-2" id="sksk" value="{{ old('sksk', $khs->sksk) }}">
                        @error('sksk')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="grid-item">
                        <label for="ipk">IP Kumulatif</label>
                        <input type="text" name="ipk" class="ipk mt-2" id="ipk" value="{{ old('ipk', $khs->ipk) }}">
                        @error('ipk')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div></div>
                    <div class="d-flex justify-content-between align-items-start grid-item-last">
                        <a href="/batalverifikasi/khs/{{ $mahasiswa->nim }}/{{ $khs->semester }}" class="btn-custom-verifikasi">Batalkan Verifikasi</a>
                        <a href="/export/filekhs/{{ $mahasiswa->nim }}/{{ $khs->semester }}" data-download-link id="downloadLink">Download File Upload</a>
                    </div>
                    <!-- Button trigger modal -->
                    <div class="d-flex justify-content-between align-items-start grid-item-last">
                        <button type="button" class="btn-custom-simpan" data-bs-toggle="modal" data-bs-target="#simpan">
                            SIMPAN
                        </button>
                        <a href="/verifikasi/khs" class="btn-custom-batal" >BATAL</a>
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
                                Tetap simpan Perubahan data khs?
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