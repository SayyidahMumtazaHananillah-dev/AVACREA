@extends('layouts.auth')

@section('title', 'AVACREA - Daftar Akun Baru')

@section('content')
<div class="w-full max-w-sm mx-auto">
    <!-- Header Form -->
    <div class="text-center mb-6">
        <h2 class="text-2xl font-black text-space-indigo tracking-tight">Buat akun baru</h2>
        <p class="text-xs font-medium text-space-indigo/70 mt-1">Daftar dan simpan semua OC buatanmu.</p>
    </div>

    <!-- Alert Error Validasi -->
    @if($errors->any())
        <div class="mb-4 p-3 rounded-xl bg-rose-100 border border-rose-300 text-rose-700 text-xs font-bold">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Register -->
    <form action="{{ route('register.post') }}" method="POST" class="flex flex-col gap-3.5">
        @csrf

        <!-- Input Nama -->
        <div>
            <label for="name" class="block text-xs font-extrabold text-space-indigo mb-1">Nama</label>
            <input type="text" 
                   id="name" 
                   name="name" 
                   value="{{ old('name') }}"
                   placeholder="Nama lengkap" 
                   required 
                   autofocus
                   class="w-full px-4 py-3 rounded-xl bg-white border border-space-indigo/15 focus:border-princeton-orange focus:outline-none text-xs font-semibold text-space-indigo placeholder-space-indigo/35 shadow-sm transition">
        </div>

        <!-- Input Username -->
        <div>
            <label for="username" class="block text-xs font-extrabold text-space-indigo mb-1">Username</label>
            <input type="text" 
                   id="username" 
                   name="username" 
                   value="{{ old('username') }}"
                   placeholder="username" 
                   required
                   class="w-full px-4 py-3 rounded-xl bg-white border border-space-indigo/15 focus:border-princeton-orange focus:outline-none text-xs font-semibold text-space-indigo placeholder-space-indigo/35 shadow-sm transition">
        </div>

        <!-- Input Email -->
        <div>
            <label for="email" class="block text-xs font-extrabold text-space-indigo mb-1">Email</label>
            <input type="email" 
                   id="email" 
                   name="email" 
                   value="{{ old('email') }}"
                   placeholder="nama@email.com" 
                   required
                   class="w-full px-4 py-3 rounded-xl bg-white border border-space-indigo/15 focus:border-princeton-orange focus:outline-none text-xs font-semibold text-space-indigo placeholder-space-indigo/35 shadow-sm transition">
        </div>

        <!-- Input Password -->
        <div>
            <label for="password" class="block text-xs font-extrabold text-space-indigo mb-1">Password</label>
            <input type="password" 
                   id="password" 
                   name="password" 
                   placeholder="Minimal 6 karakter" 
                   minlength="6"
                   required
                   class="w-full px-4 py-3 rounded-xl bg-white border border-space-indigo/15 focus:border-princeton-orange focus:outline-none text-xs font-semibold text-space-indigo placeholder-space-indigo/35 shadow-sm transition">
        </div>

        <!-- Tombol Submit Daftar -->
        <button type="submit" class="mt-3 w-full py-3.5 bg-princeton-orange hover:bg-orange-600 text-white font-black text-xs tracking-wide rounded-xl shadow-md shadow-princeton-orange/25 border-b-4 border-amber-800 active:scale-[0.99] transition-all">
            Daftar
        </button>
    </form>

    <!-- Link ke Halaman Login -->
    <p class="text-center text-xs font-semibold text-space-indigo mt-5">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="font-extrabold text-brand-orange hover:underline ml-0.5">
            Masuk
        </a>
    </p>
</div>
@endsection