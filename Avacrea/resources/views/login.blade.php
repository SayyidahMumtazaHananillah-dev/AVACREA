@extends('layouts.auth')

@section('title', 'AVACREA - Masuk')

@section('content')
<div class="w-full max-w-sm mx-auto">
    <!-- Header Form -->
    <div class="text-center mb-7">
        <h2 class="text-2xl font-black text-space-indigo tracking-tight">Selamat datang kembali</h2>
        <p class="text-xs font-medium text-space-indigo/70 mt-1">Masuk untuk lanjut membuat karakter OC kamu.</p>
    </div>

    <!-- Alert Error Validasi Login -->
    @if($errors->any())
        <div class="mb-4 p-3 rounded-xl bg-rose-100 border border-rose-300 text-rose-700 text-xs font-bold text-center">
            {{ $errors->first() }}
        </div>
    @endif

    <!-- Form Login -->
    <form action="{{ route('login.post') }}" method="POST" class="flex flex-col gap-4">
        @csrf

        <!-- Input Email -->
        <div>
            <label for="email" class="block text-xs font-extrabold text-space-indigo mb-1.5">Email</label>
            <input type="email" 
                   id="email" 
                   name="email" 
                   value="{{ old('email') }}"
                   placeholder="nama@email.com" 
                   required 
                   autofocus
                   class="w-full px-4 py-3 rounded-xl bg-white border border-space-indigo/15 focus:border-princeton-orange focus:outline-none text-xs font-semibold text-space-indigo placeholder-space-indigo/35 shadow-sm transition">
        </div>

        <!-- Input Password -->
        <div>
            <label for="password" class="block text-xs font-extrabold text-space-indigo mb-1.5">Password</label>
            <input type="password" 
                   id="password" 
                   name="password" 
                   placeholder="••••••••" 
                   required
                   class="w-full px-4 py-3 rounded-xl bg-white border border-space-indigo/15 focus:border-princeton-orange focus:outline-none text-xs font-semibold text-space-indigo placeholder-space-indigo/35 shadow-sm transition">
        </div>

        <!-- Tombol Submit Masuk -->
        <button type="submit" class="mt-3 w-full py-3.5 bg-princeton-orange hover:bg-orange-600 text-white font-black text-xs tracking-wide rounded-xl shadow-md shadow-princeton-orange/25 border-b-4 border-amber-800 active:scale-[0.99] transition-all">
            Masuk
        </button>
    </form>

    <!-- Link ke Halaman Register -->
    <p class="text-center text-xs font-semibold text-space-indigo mt-5">
        Belum punya akun?
        <a href="{{ route('register') }}" class="font-extrabold text-brand-orange hover:underline ml-0.5">
            Daftar
        </a>
    </p>
</div>
@endsection