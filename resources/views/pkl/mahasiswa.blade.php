@extends('layouts/main')

@section('css_navbar')
    <link rel="stylesheet" href="/css/navbar.css">
@endsection

@section('css_menu')
    <link rel="stylesheet" href="/css/menu.css">
@endsection

@section('css')
    <link rel="stylesheet" href="/css/pkl.css">
@endsection

@section('navbar')
    @include('partials/navbar')
@endsection

@section('menu')
    @include('menu/menu')
@endsection

@section('content')
<div class="container p-0 mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-center">
            Praktik Kerja Lapangan (PKL)
        </div>
        <div class="card-body">
            <form action="/pkl/{{ auth()->user()->role }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="status d-flex justify-content-end mb-2">
                    <div class="statusText @if(!$pkl) red @elseif($pkl &&$pkl->status != 1) orange @else green @endif" id="statusText" data-status="{{ $pkl ? $pkl->status : '' }}">
                        @if (!$pkl)
                            Belum upload
                        @elseif ($pkl->status == 0)
                            Belum disetujui
                        @elseif ($pkl->status == 1)
                            Sudah disetujui
                        @endif
                    </div>
                </div>
                <div class="grid-m-pkl">
                    <div class="grid-item">
                        <label for="semester">Semester</label>
                        <select name="semester" class="semester mt-2 @if ($pkl && $pkl->status == 1) approved @endif" id="semesterSelect" @if($pkl && $pkl->status == 1) disabled @endif>
                            @foreach ($semesterPKL as $semester)
                                <option value="{{ $semester }}" {{ old('semester', optional($pkl)->semester) == $semester ? 'selected' : '' }}>
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
                        <label for="nilai">Nilai PKL</label>
                        <input type="text" name="nilai" class="nilai mt-2 @if ($pkl && $pkl->status == 1)
                        approved
                        @endif" value="{{ $pkl ? $pkl->nilai : old('nilai') }}"  @if($pkl && $pkl->status == '1') disabled @endif>
                        @error('nilai')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="grid-item" id="filepkl">
                        <label for="filepkl">Upload File Bukti PKL</label>
                        <input type="file" name="filepkl" class="filepkl mt-2 @if ($pkl && $pkl->status == 1)
                        approved
                        @endif" @if($pkl && $pkl->status == '1') disabled @endif>
                        @error('filepkl')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <!-- Button trigger modal -->
                    <div class="d-flex justify-content-between align-items-end grid-item-m">
                        <button type="button" class="btn-custom-simpan @if($pkl && $pkl->status == '1') d-none @endif" data-bs-toggle="modal" data-bs-target="#simpan">
                            SIMPAN
                        </button>
                        <a href="/dashboard" class="btn-custom-batal" >BATAL</a>
                        @if($pkl)
                            <a href="/export/filepkl/{{ $mahasiswa->nim }}" data-download-link id="downloadLink">Download File Upload</a>
                        @endif
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
                                Tetap simpan perubahan data pkl anda?
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
