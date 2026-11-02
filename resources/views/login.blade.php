@extends('layouts.auth')

@section('title', 'Masuk')
@section('hero-small', 'Senang melihatmu lagi')
@section('hero-title', 'Lanjutkan karyamu dari yang terakhir.')

@section('content')
    <svg class="spark" viewBox="0 0 24 24" fill="#FF8811" aria-hidden="true"><path d="M12 0c.6 6.6 4.8 10.8 12 12-7.2 1.2-11.4 5.4-12 12-.6-6.6-4.8-10.8-12-12C7.2 10.8 11.4 6.6 12 0z"/></svg>
    <h1>Masuk</h1>
    <p class="sub">Masukkan email dan password akunmu.</p>

    @if ($errors->any())
        <div class="alert" role="alert">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('login.process') }}">
        @csrf
        <div class="field">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required autofocus autocomplete="email">
        </div>
        <div class="field">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Password kamu" required autocomplete="current-password">
        </div>
        <button type="submit" class="btn">Masuk</button>
    </form>

    <p class="switch">Belum punya akun? <a href="{{ route('register') }}">Daftar</a></p>
@endsection