@extends('layouts.main')

@section('css')
    <link rel="stylesheet" href="/css/login.css">
@endsection

@section('content')
    <div class="container">
        <form action="" method="POST">
            @csrf
            <div class="logo">
                <img src="/asset/img/logo-undip.png" alt="logo undip">
            </div>
            <h1>Universitas Diponegoro</h1>
            <h2>Departemen Informatika</h2>
            <div class="center-span">
                <hr><span>silahkan masuk</span><hr>
            </div>

            @if (session('LoginError'))
                <div class="alert alert-danger">
                    {{ session('LoginError') }}
                </div>
            @endif
            
            <div class="group">
                <i class="bi bi-person"></i>
                <div class="input-group">
                    <input type="text" name="username" id="username" class="input" placeholder="Masukkan NIP/NIM" value="{{ old('username') }}" required>
                    @error('username')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="group">
                <i class="bi bi-lock"></i>
                <div class="input-group">
                    <input type="password" name="password" id="password" class="input" placeholder="Password" value="{{ old('password') }}" required>
                    @error('password')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            
            <div class="forgot">
                <a href="#">Lupa password</a>
            </div>
            
            <button type="submit" class="btn">LOGIN</button>
            
        </form>
    </div>
@endsection