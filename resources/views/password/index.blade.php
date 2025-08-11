@extends('layouts.main')

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
    <link rel="stylesheet" href="/css/password.css">
@endsection

@section('js_popup')
    <script src="/js/popup.js"></script>
@endsection

@section('js')
    <script src="/js/generate.js"></script>
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
    <div class="container mt-4">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-center">
            <div class="fotoprofile">
                @if ($user->role == 'mahasiswa' && $mahasiswa->foto)
                    <img src="{{ asset('asset/fotoprofile/mahasiswa/' . $mahasiswa->foto) }}" alt="foto profile">
                @elseif ($user->role == 'dosenwali' && $dosenwali->foto)
                    <img src="{{ asset('asset/fotoprofile/dosenwali/' . $dosenwali->foto) }}" alt="foto profile">
                @elseif ($user->role == 'departemen' && $departemen->foto)
                    <img src="{{ asset('asset/fotoprofile/departemen/' . $departemen->foto) }}" alt=" foto profile">
                @elseif ($user->role == 'operator' && $operator->foto)
                    <img src="{{ asset('asset/fotoprofile/operator/' . $operator->foto) }}" alt=" foto profile">
                @else
                    <img src="{{ asset('asset/fotoprofile/default/profile.png') }}" alt="default foto profile">
                @endif
            </div>
            
        </div>
        <div class="card-body">
            <form action="/gantipassword" method="POST">
                @csrf
                <div class="grid-password">
                    <div class="grid-item">
                        <label for="username">Username</label>
                        <input type="text" name="username" class="username mt-2" value="{{ old('username')}}">
                        @error('username')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="grid-item">
                        <label for="password">Password
                        </label>
                        <input type="password" name="password" class="password mt-2" value="{{ old('password')}}">
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
                        <label for="passwordbaru">Password Baru
                        </label>
                        <input type="password" name="passwordbaru" class="passwordbaru mt-2" value="{{ old('passwordbaru')}}">
                        @error('passwordbaru')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="grid-item">
                        <label for="konfpasswordbaru">Konfirmasi Password Baru
                        </label>
                        <input type="password" name="konfpasswordbaru" class="konfpasswordbaru mt-2" value="{{ old('konfpasswordbaru') }}">
                        @error('konfpasswordbaru')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                        @if(session('konfpasswordbaru'))
                            <div class="text-danger">
                                {{ session('konfpasswordbaru') }}
                            </div>
                        @endif
                    </div>

                    <!-- Button trigger modal -->
                    <div class="d-flex justify-content-between align-items-center grid-item-last grid-item-password">
                        <a href="/dashboard" class="btn-custom-batal" >BATAL</a>
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
                                Tetap simpan perubahan password anda?
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