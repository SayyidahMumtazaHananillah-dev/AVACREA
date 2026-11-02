@extends('layouts.auth')

@section('title', 'Daftar')
@section('hero-small', 'Mulai dari sini')
@section('hero-title', 'Buat akun dan mulai berkarya.')

@section('content')
    <svg class="spark" viewBox="0 0 24 24" fill="#FF8811" aria-hidden="true"><path d="M12 0c.6 6.6 4.8 10.8 12 12-7.2 1.2-11.4 5.4-12 12-.6-6.6-4.8-10.8-12-12C7.2 10.8 11.4 6.6 12 0z"/></svg>
    <h1>Buat akun</h1>
    <p class="sub">Isi data di bawah untuk mendaftar.</p>

    <form method="POST" action="{{ route('register.process') }}" enctype="multipart/form-data">
        @csrf

        <div class="field">
            <label for="image">Foto profil</label>
            <div class="avatar-pick">
                <div class="avatar" id="avatarPreview">
                    <svg viewBox="0 0 24 24" fill="#392F5A" aria-hidden="true"><path d="M12 12a4.5 4.5 0 100-9 4.5 4.5 0 000 9zm0 2c-4.4 0-8 2.2-8 5v2h16v-2c0-2.8-3.6-5-8-5z"/></svg>
                </div>
                <input type="file" id="image" name="image" accept="image/png,image/jpeg,image/webp">
            </div>
            @error('image') <p class="error">{{ $message }}</p> @enderror
        </div>

        <div class="row">
            <div class="field">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="{{ old('username') }}" placeholder="namamu" required autocomplete="username">
                @error('username') <p class="error">{{ $message }}</p> @enderror
            </div>
            <div class="field">
                <label for="role">Role</label>
                <select id="role" name="role" required>
                    <option value="" disabled {{ old('role') ? '' : 'selected' }}>Pilih role</option>
                    <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User</option>
                    <option value="creator" {{ old('role') === 'creator' ? 'selected' : '' }}>Creator</option>
                </select>
                @error('role') <p class="error">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="field">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required autocomplete="email">
            @error('email') <p class="error">{{ $message }}</p> @enderror
        </div>

        <div class="row">
            <div class="field">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Minimal 8 karakter" required autocomplete="new-password">
                @error('password') <p class="error">{{ $message }}</p> @enderror
            </div>
            <div class="field">
                <label for="password_confirmation">Konfirmasi password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" required autocomplete="new-password">
            </div>
        </div>

        <button type="submit" class="btn">Daftar</button>
    </form>

    <p class="switch">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>

    <script>
        document.getElementById('image').addEventListener('change', function (e) {
            const file = e.target.files[0];
            const box = document.getElementById('avatarPreview');
            if (!file) return;
            box.style.backgroundImage = 'url(' + URL.createObjectURL(file) + ')';
            box.innerHTML = '';
        });
    </script>
@endsection