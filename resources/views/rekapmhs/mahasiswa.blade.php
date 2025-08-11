@extends('layouts/main')

@section('css_navbar')
    <link rel="stylesheet" href="/css/navbar.css">
@endsection

@section('css_menu')
    <link rel="stylesheet" href="/css/menu.css">
@endsection

@section('css')
    <link rel="stylesheet" href="/css/rekapmhs.css">
@endsection

@section('js')
    <script src="/js/rekapmhs.js"></script>   
@endsection

@section('navbar')
    @include('partials/navbar')
@endsection

@section('menu')
    @include('menu/menu')
@endsection

@section('content')
<div class="container mt-4">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-center">
            Rekap Mahasiswa
        </div>
        <div class="card-body">
            <div class="grid-rekapmhs">
                <div class="grid-angkatan">
                    <div class="d-flex align-items-center pl-4">
                        <label for="angkatan">
                            Pilih Angkatan :
                        </label>
                    </div>
                    <select id="angkatanSelect" name="angkatan" class="angkatan mt-2">
                        <option value="semua">Semua Angkatan</option>
                        @foreach ($angkatanAktif as $tahun)
                            <option value="{{ $tahun }}">Angkatan {{ $tahun }}</option>
                        </option>
                        @endforeach
                    </select>
                    @error('angkatan')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="grid-pilih-status">
                    <div></div>
                    <div class="d-flex align-items-center pl-4">
                        <label for="pilihstatus">
                            Pilih Status :
                        </label>
                    </div>
                    <select id="pilihstatusSelect" name="pilihstatus" class="pilihstatus mt-2">
                        <option value="semua">Semua Status</option>
                        <option value="aktif">Aktif</option>
                        <option value="cuti">Cuti</option>
                        <option value="mangkir">Mangkir</option>
                        <option value="undur diri">Undur Diri</option>
                        <option value="lulus">Lulus</option>
                        <option value="do">DO</option>
                        <option value="meninggal dunia">Meninggal Dunia</option>
                    </select>
                    @error('pilihmenu')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <hr>
            <div class="container border-0 p-0 mt-2 mb-2">
                <form action="/rekap/cari/{{ $page }}" method="GET">
                    <div class="col-sm-3">
                        <input type="search" id="search" name="search" class="form-control" placeholder="Cari Nama/NIM">
                    </div>
                </form>
            </div>
            <div class="table-responsive" data-menu="irs">
                <table class="table table-bordered text-center">
                    <tr data-list>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Alamat</th>
                        <th>Kabupaten/Kota</th>
                        <th>Provinsi</th>
                        <th>No Telp</th>
                        <th>Angkatan</th>
                        <th>Status</th>
                        <th>Dosen Wali</th>
                        <th>Jalur Masuk</th>
                    </tr>
                    @foreach ($mahasiswa as $mhs)
                        <tr data-angkatan="{{ $mhs->angkatan }}" data-status="{{ $mhs->status }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $mhs->nim }}</td>
                            <td>{{ $mhs->nama }}</td>
                            <td>{{ $mhs->email }}</td>
                            <td>{{ $mhs->alamat }}</td>
                            <td>{{ $mhs->kabkota }}</td>
                            <td>{{ $mhs->provinsi }}</td>
                            <td>{{ $mhs->notelp }}</td>
                            <td>{{ $mhs->angkatan }}</td>
                            <td>{{ $mhs->status }}</td>
                            <td>{{ $mhs->dosenwali }}</td>
                            <td>{{ $mhs->jalurmasuk }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div id="mahasiswanull" class="mahasiswanull">ops.. tidak ada mahasiswa yang tersedia</div>
            <div class="d-flex @if(request('search'))justify-content-between @else justify-content-end @endif align-items-center">
                @if(request('search'))
                    <a href="/rekap/mahasiswa" class="btn-custom-back">Kembali</a>
                @endif
                <a href="#" id="btnCetak" class="btn-cetak">Cetak</a>
            </div>            
        </div>
    </div>
</div>
@endsection

