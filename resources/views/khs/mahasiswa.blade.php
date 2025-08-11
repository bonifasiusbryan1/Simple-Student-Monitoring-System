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

@section('js')
    <script src="/js/khs.js"></script>   
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
            Kartu Hasil Studi (KHS)
        </div>
        <div class="card-body">
            <form action="/khs/{{ auth()->user()->role }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="status d-flex justify-content-end mb-2">
                    <div class="statusText" id="statusText"></div>
                </div>
                <div class="grid-m-khs">
                    <div class="grid-item">
                        <label for="semester">Semester</label>
                        <select name="semester" class="semester mt-2" id="semesterSelect">
                            @if($mahasiswa->status =='lulus')
                                @for ($i = 1; $i <= $semesterAktif; $i++)
                                    <option value="{{ $i }}" @if($i == old('semester')) selected @endif>{{ $i }}</option>
                                @endfor
                            @else 
                                @for ($i = 1; $i <= $semesterAktif-1 ; $i++)
                                    <option value="{{ $i }}" @if($i == old('semester')) selected @endif>{{ $i }}</option>
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
                        <label for="skss">Jumlah SKS Semester</label>
                        <input type="text" name="skss" class="skss mt-2" id="skss" value="{{ old('skss') }}">
                        @error('skss')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="grid-item">
                        <label for="sksk">Jumlah SKS Kumulatif</label>
                        <input type="text" name="sksk" class="sksk mt-2" id="sksk" value="{{ old('sksk') }}">
                        @error('sksk')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="grid-item">
                        <label for="ips">IP Semester</label>
                        <input type="text" name="ips" class="ips mt-2" id="ips" value="{{ old('ips') }}">
                        @error('ips')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="grid-item">
                        <label for="ipk">IP Kumulatif</label>
                        <input type="text" name="ipk" class="ipk mt-2" id="ipk" value="{{ old('ipk') }}">
                        @error('ipk')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="grid-item">
                        <label for="filekhs">Upload Bukti File KHS</label>
                        <input type="file" name="filekhs" class="filekhs mt-2" id="filekhsInput">
                        @error('filekhs')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <!-- Button trigger modal -->
                    <div class="d-flex justify-content-between align-items-end grid-item-m">
                        <button type="button" class="btn-custom-simpan" data-bs-toggle="modal" data-bs-target="#simpan">
                            SIMPAN
                        </button>
                        <a href="/dashboard" class="btn-custom-batal" >BATAL</a>
                        <a href="/export/filekhs/{{ $mahasiswa->nim }}/1" data-download-link id="downloadLink">Download File Upload</a>
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
                                Tetap simpan perubahan data khs anda?
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

<script>
    var khsData = {!! $khs->toJson() !!};
    var mahasiswaNim = {{ $mahasiswa->nim }}
</script>

@endsection

