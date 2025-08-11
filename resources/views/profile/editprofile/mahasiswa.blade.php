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
    <a class="d-flex" @if ($user->role == 'mahasiswa') href="/dashboard" @elseif($user->role == 'operator') href="/generate/akunmahasiswa" @endif>
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
            <form @if ($user->role == 'mahasiswa') action="/editprofile/mahasiswa" @elseif($user->role == 'operator') href="/editprofile/mahasiswa/{{ $mahasiswa->nim }}" @endif method="POST" enctype="multipart/form-data">
                @csrf
                <div class="@if(!$mahasiswaBaru) grid-m @else grid-mb @endif">
                    <div class="grid-item">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" class="nama mt-2" value="{{ old('nama', $mahasiswa->nama) }}">
                        @error('nama')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="grid-item">
                        <label for="nim">NIM
                            <span class="text-danger">*tidak dapat diubah</span>
                        </label>
                        <div class="nim mt-2">{{ $mahasiswa->nim }}</div>
                    </div>
                    <div class="grid-item">
                        <label for="email">Email</label>
                        <input type="text" name="email" class="email mt-2" value="{{ old('email', $mahasiswa->email) }}">
                        @error('email')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="grid-item">
                        @if($user->role == 'mahasiswa')
                            <label for="dosenwali">Dosen Wali 
                                <span class="text-danger">*tidak dapat diubah</span>
                            </label>
                            <div class="dosenwali mt-2">{{ $mahasiswa->dosenwali }}</div>
                        @elseif($user->role == 'operator')
                            <label for="dosenwali">Dosen Wali</label>
                            <select name="dosenwali" class="dosenwali mt-2">
                                <option value="Nurdin Bahtiar, S.Si., M.T." {{ $mahasiswa->dosenwali == 'Nurdin Bahtiar, S.Si., M.T.' ? 'selected' : '' }}>Nurdin Bahtiar, S.Si., M.T.</option>
                                <option value="Guruh Aryotejo, S.Kom., M.Sc." {{ $mahasiswa->dosenwali == 'Guruh Aryotejo, S.Kom., M.Sc.' ? 'selected' : '' }}>Guruh Aryotejo, S.Kom., M.Sc.</option>
                            </select>
                        @endif
                        @error('dosenwali')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="grid-item">
                        @if($user->role == 'mahasiswa')
                            <label for="angkatan">Angkatan 
                                <span class="text-danger">*tidak dapat diubah</span>
                            </label>
                            <div class="angkatan mt-2">{{ $mahasiswa->angkatan }}</div>
                        @elseif($user->role == 'operator')
                            <label for="angkatan">Angkatan</label>
                            <input type="text" name="angkatan" class="angkatan mt-2" value="{{ old('angkatan', $mahasiswa->angkatan) }}">
                        @endif
                        @error('angkatan')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="grid-item">
                        <label for="notelp">Nomor Telepon</label>
                        <input type="text" name="notelp" class="notelp mt-2" value="{{ old('notelp', $mahasiswa->notelp) }}">
                        @error('notelp')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="grid-item">
                        <label for="alamat">Alamat</label>
                        <input type="text" name="alamat" class="alamat mt-2" value="{{ old('alamat', $mahasiswa->alamat) }}">
                        @error('alamat')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="grid-item">
                        <label for="kabkota">Kabupaten/Kota</label>
                        <input type="text" name="kabkota" class="kabkota mt-2" value="{{ old('kabkota', $mahasiswa->kabkota) }}">
                        @error('kabkota')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="grid-item">
                        <label for="provinsi">Provinsi</label>
                        <input type="text" name="provinsi" class="provinsi mt-2" value="{{ old('provinsi', $mahasiswa->provinsi) }}">
                        @error('provinsi')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="grid-item">
                        @if($user->role == 'mahasiswa')
                            <label for="jalurmasuk">Jalur Masuk
                                @if ($mahasiswa->jalurmasuk !== null)
                                    <span class="text-danger">*tidak dapat diubah</span>
                                @endif
                            </label>
                            @if ($mahasiswa->jalurmasuk === null)
                                <select name="jalurmasuk" class="jalurmasuk mt-2">
                                    <option value="snmptn" {{ $mahasiswa->jalurmasuk == 'snmptn' ? 'selected' : '' }}>SNMPTN</option>
                                    <option value="sbmptn" {{ $mahasiswa->jalurmasuk == 'sbmptn' ? 'selected' : '' }}>SBMPTN</option>
                                    <option value="mandiri" {{ $mahasiswa->jalurmasuk == 'mandiri' ? 'selected' : '' }}>Mandiri</option>
                                </select>
                            @else
                                <div class="jalurmasuk mt-2">{{ strtoupper($mahasiswa->jalurmasuk) }}</div>
                            @endif
                        @elseif($user->role == 'operator')
                            <label for="jalurmasuk">Jalur Masuk</label>
                            <select name="jalurmasuk" class="jalurmasuk mt-2">
                                <option value="snmptn" {{ $mahasiswa->jalurmasuk == 'snmptn' ? 'selected' : '' }}>SNMPTN</option>
                                <option value="sbmptn" {{ $mahasiswa->jalurmasuk == 'sbmptn' ? 'selected' : '' }}>SBMPTN</option>
                                <option value="mandiri" {{ $mahasiswa->jalurmasuk == 'mandiri' ? 'selected' : '' }}>Mandiri</option>
                            </select>
                        @endif
                        @error('jalurmasuk')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="grid-item">
                        @if($user->role == 'mahasiswa')
                            <label for="status">Status  
                                <span class="text-danger">*tidak dapat diubah</span>
                            </label>
                            <div class="status mt-2">{{ strtoupper($mahasiswa->status) }}</div>
                        @elseif($user->role == 'operator')
                            <label for="status">Status</label>
                            <select name="status" class="status mt-2">
                                <option value="aktif" {{ $mahasiswa->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="cuti" {{ $mahasiswa->status == 'cuti' ? 'selected' : '' }}>Cuti</option>
                                <option value="undur diri" {{ $mahasiswa->status == 'undur diri' ? 'selected' : '' }}>Undur Diri</option>
                                <option value="lulus" {{ $mahasiswa->status == 'lulus' ? 'selected' : '' }}>Lulus</option>
                                <option value="do" {{ $mahasiswa->status == 'do' ? 'selected' : '' }}>DO</option>
                                <option value="meninggal dunia" {{ $mahasiswa->status == 'meninggal dunia' ? 'selected' : '' }}>Meninggal Dunia</option>
                            </select>
                        @endif
                        @error('status')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="grid-item">
                        <label for="foto">Update Foto Profile  
                            @if ($mahasiswa->foto)
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
                    @if ($mahasiswaBaru)
                    <div class="grid-item">
                        <label for="password">Password Lama</label>
                        <input type="password" name="password" class="password mt-2" value="{{ old('password') }}">
                        @error('password')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                        @if(session('error'))
                            <div class="text-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                    </div>
                    <div class="grid-item">
                        <label for="passwordbaru">Password Baru</label>
                        <input type="password" name="passwordbaru" class="passwordbaru mt-2" value="{{ old('passwordbaru') }}">
                        @error('passwordbaru')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    @endif
                    <!-- Button trigger modal -->
                    <div class="d-flex justify-content-between align-items-center grid-item-last @if(!$mahasiswaBaru) grid-item-m @else grid-item-mb @endif">
                        <a @if ($user->role == 'mahasiswa') href="/profile/mahasiswa" @elseif($user->role == 'operator') href="/generate/akunmahasiswa" @endif class="btn-custom-batal" >BATAL</a>
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