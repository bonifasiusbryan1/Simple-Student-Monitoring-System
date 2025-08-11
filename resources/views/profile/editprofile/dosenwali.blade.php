@extends('layouts/main')

@section('css_navbar')
    <link rel="stylesheet" href="/css/navbar.css">
@endsection

@section('css_menu')
    <link rel="stylesheet" href="/css/menu.css">
@endsection

@section('css')
    <link rel="stylesheet" href="/css/editprofile.css">
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
<div class="container mt-3 mb-4">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-center">
            <div class="fotoprofile">
                <img src="{{ asset('asset/fotoprofile/dosenwali/' . $dosenwali->foto) }}" alt="foto profile">
            </div>
        </div>
        <div class="card-body">
            <form action="/editprofile/{{ auth()->user()->role }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid">
                    <div class="grid-item">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" class="nama mt-2" value="{{ old('nama', $dosenwali->nama) }}">
                        @error('nama')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="grid-item">
                        <label for="nim">NIP <span class="text-danger">*tidak dapat diubah</span></label>
                        <div class="nim mt-2">{{ $dosenwali->nip }}</div>
                    </div>
                    <div class="grid-item">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="email mt-2" value="{{ old('email', $dosenwali->email) }}">
                        @error('email')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="grid-item">
                        <label for="notelp">Nomor Telepon</label>
                        <input type="text" name="notelp" class="notelp mt-2" value="{{ old('notelp', $dosenwali->notelp) }}">
                        @error('notelp')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="grid-item">
                        <label for="alamat">Alamat</label>
                        <input type="text" name="alamat" class="alamat mt-2" value="{{ old('alamat', $dosenwali->alamat) }}">
                        @error('alamat')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="grid-item">
                        <label for="kabkota">Kabupaten/Kota</label>
                        <input type="text" name="kabkota" class="kabkota mt-2" value="{{ old('kabkota', $dosenwali->kabkota) }}">
                        @error('kabkota')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="grid-item">
                        <label for="provinsi">Provinsi</label>
                        <input type="text" name="provinsi" class="provinsi mt-2" value="{{ old('provinsi', $dosenwali->provinsi) }}">
                        @error('provinsi')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="grid-item">
                        <label for="foto">Update Foto Profile  
                            @if ($dosenwali->foto)
                                <span class="text-warning">*opsional</span>
                            @endif
                        </label>
                        <input type="file" name="foto" class="foto mt-2">
                        @error('foto')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <!-- Button trigger modal -->
                    <div class="d-flex justify-content-between align-items-start grid-item-last grid-item-nm">
                        <a href="/profile/dosenwali" class="btn-custom-batal" >BATAL</a>
                        <button type="button" class="btn-custom-simpan" data-bs-toggle="modal" data-bs-target="#simpan">
                            SIMPAN
                        </button>
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
                                Tetap simpan Perubahan data profile yang telah dilakukan?
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