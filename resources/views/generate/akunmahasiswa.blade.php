@extends('layouts/main')

@section('css_navbar')
    <link rel="stylesheet" href="/css/navbar.css">
@endsection

@section('css_popup')
    <link rel="stylesheet" href="/css/popup.css">
@endsection

@section('css_menu')
    <link rel="stylesheet" href="/css/menu.css">
@endsection

@section('css')
    <link rel="stylesheet" href="/css/generate.css">
@endsection

@section('js_popup')
    <script src="/js/popup.js"></script>
@endsection

@section('js')
    <script type="text/javascript" src="/js/generate.js"></script>
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
<div class="container p-0 d-flex justify-content-between text-wrap mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-center">
            Generate Akun Mahasiswa
        </div>
        <div class="card-body">
            <div class="generate">
                <label for="generateakun">Generate Akun : </label>
                <select onchange="show(this.value)" id="generateakun" name="generateakun" class="generateakun mt-2">
                    <option value="satuakun">Satu Akun</option>
                    <option value="semuaakun">Semua Akun</option>
                </select>
            </div>
            <hr>
            <form action="/generate/akunmahasiswa/satuakun" method="POST">
                @csrf
                <div id="satuakun" class="hidden">
                    <div class="item">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" class="nama mt-2" value="{{ old('nama') }}">
                        @error('nama')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="item">
                        <label for="nim">NIM</label>
                        <input type="text" name="nim" class="nim mt-2" value="{{ old('nim') }}">
                        @error('nim')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="item">
                        <label for="angkatan">Angkatan</label>
                        <input type="text" name="angkatan" class="angkatan mt-2" value="{{ old('angkatan') }}">
                        @error('angkatan')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="item">
                        <label for="dosenwali">Dosen Wali</label>
                        <select id="dosenwali" name="dosenwali" class="dosenwali mt-2">
                            <option value="Guruh Aryotejo, S.Kom., M.Sc.">Guruh Aryotejo, S.Kom., M.Sc.</option>
                            <option value="Nurdin Bahtiar, S.Si., M.T.">Nurdin Bahtiar, S.Si., M.T.</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn-custom-simpan">Simpan</button>
                    </div>
                </div>
            </form>

            <form action="/generate/akunmahasiswa/semuaakun" method="POST" enctype="multipart/form-data">
                @csrf
                <div id="semuaakun" class="hidden">
                    <div class="item">
                        <a href="/exportexcel/mhs">Download Format Excel</a>
                    </div>
                    <!-- Button trigger modal -->
                    <div class="d-flex justify-content-between align-items-start grid-item-last grid-item-m">
                        <button type="button" class="btn-custom-simpan" data-bs-toggle="modal" data-bs-target="#simpan">
                           + Upload File
                        </button>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="simpan" tabindex="-1" aria-labelledby="simpanLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h1 class="modal-title fs-5" id="simpanLabel">Import Data Mahasiswa</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <input type="file" name="akunmhs" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn-custom-modal btn-cm-batal" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class=" btn-custom-modal btn-cm-simpan">Generate Akun</button>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </form>

            <hr>

            <h5 class="text-center">Data Akun Mahasiswa</h5>
            <div class="container border-0 p-0 mt-2 mb-2">
                <form action="/cari/akunmahasiswa" method="GET">
                    <div class="col-sm-3">
                        <input type="search" id="search" name="search" class="form-control" placeholder="Pencarian">
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered text-center">
                    <tr>
                        <th>NIM/Username</th>
                        <th>Nama</th>
                        <th>Angkatan</th>
                        <th>Dosen Wali</th>
                        <th>Aksi</th>
                    </tr>
                    @foreach($mahasiswa as $mhs)
                        <tr>
                            <td>{{ $mhs->nim }}</td>
                            <td>{{ $mhs->nama }}</td>
                            <td>{{ $mhs->angkatan }}</td>
                            <td>{{ $mhs->dosenwali }}</td>
                            <td>
                                <a href="/editprofile/mahasiswa/{{ $mhs->nim }}">Edit</a>
                                <button class="btn-custom btn-custom-reset" data-bs-target="#reset{{ $mhs->nim }}" data-bs-toggle="modal">Reset</button>
                                <button class="btn-custom btn-custom-del" data-bs-target="#hapus{{ $mhs->nim }}" data-bs-toggle="modal">Delete</button>
                            </td>
                        </tr>
                        
                        {{-- Reset Modal per Mahasiswa --}}
                        <div class="modal fade" id="reset{{ $mhs->nim }}" aria-hidden="true" aria-labelledby="resetLabel{{ $mhs->nim }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header text-center ">
                                        <h1 class="modal-title fs-5 text-warning" id="resetLabel{{ $mhs->nim }}"><strong> Konfirmasi Reset Password</strong></h1>
                                        <button type="button" class="btn-close"data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah Anda yakin akan mereset password akun mahasiswa dengan <strong>Nama : {{ $mhs->nama }} dan NIM {{ $mhs->nim }} ? </strong>
                                    </div>
                                    <div class="modal-footer p-2">
                                        <button type="button" class="btn-custom-modal btn-cm-batal" data-bs-dismiss="modal">Batal</button>
                                        <a href="/reset/akunmahasiswa/{{ $mhs->nim }}">Reset</a>
                                    </div>
                                </div>
                            </div>
                        </div>
    
                        {{-- Delete Modal per Mahasiswa--}}
                        <div class="modal fade" id="hapus{{ $mhs->nim }}" aria-hidden="true" aria-labelledby="hapusLabel{{ $mhs->nim }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header text-center ">
                                        <h1 class="modal-title fs-5 text-danger" id="hapusLabel{{ $mhs->nim }}"><strong> Konfirmasi Hapus Akun</strong></h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah Anda yakin akan menghapus akun mahasiswa dengan <strong>Nama : {{ $mhs->nama }} dan NIM {{ $mhs->nim }} ? </strong>
                                    </div>
                                    <div class="modal-footer modal-footer-2 p-2">
                                        <button type="button" class="btn-custom-modal btn-cm-batal" data-bs-dismiss="modal">Batal</button>
                                        <a href="/hapus/akunmahasiswa/{{ $mhs->nim }}">Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </table>
            </div>
            @if(request('search'))
                <a href="/generate/akunmahasiswa" class="btn-custom-back">Kembali</a>
            @endif
        </div>
    </div>
</div>
@endsection