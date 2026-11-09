<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light only">

    <title>Register - AVACREA</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'floral-white': '#FFF8F0',
                        'jasmine': '#F4D06F',
                        'princeton-orange': '#FF8811',
                        'pearl-aqua': '#9DD9D2',
                        'space-indigo': '#392F5A',
                    }
                }
            }
        }
    </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="min-h-screen bg-[#FFF8F0] flex items-center justify-center p-5 font-sans text-[#392F5A]">

    <!-- Background Decoration -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-32 -left-32 w-96 h-96 bg-[#9DD9D2]/40 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-[#F4D06F]/50 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 right-10 w-32 h-32 border-2 border-[#FF8811]/20 rounded-full"></div>
    </div>

    <!-- Register Card -->
    <main class="relative z-10 w-full max-w-md my-8">

        <div class="bg-white/95 backdrop-blur-sm rounded-[32px] p-8 sm:p-10 shadow-[0_20px_60px_rgba(57,47,90,0.12)] border border-white">

            <!-- Logo -->
            <div class="flex items-center justify-center gap-3 mb-8">

                <div class="w-12 h-12 rounded-2xl bg-[#FF8811] flex items-center justify-center shadow-lg shadow-[#FF8811]/30">
                    <i class="fa-solid fa-wand-magic-sparkles text-white text-xl"></i>
                </div>

                <div>
                    <h1 class="text-2xl font-black tracking-wider text-[#392F5A]">
                        AVACREA
                    </h1>

                    <p class="text-[10px] text-[#FF8811] font-bold tracking-[3px] uppercase">
                        OC Studio Online
                    </p>
                </div>

            </div>

            <!-- Heading -->
            <div class="text-center mb-8">

                <span class="inline-block px-4 py-1.5 rounded-full bg-[#9DD9D2]/20 text-[#478E85] text-[10px] font-bold tracking-widest uppercase mb-3">
                    Join Our Community!
                </span>

                <h2 class="text-2xl sm:text-3xl font-black text-[#392F5A]">
                    Buat Akun Baru
                </h2>

                <p class="text-sm text-gray-500 mt-2">
                    Daftar dan mulai simpan semua karakter OC buatanmu.
                </p>

            </div>

            <!-- General Error -->
            @if ($errors->any())
                <div class="mb-5 p-4 rounded-2xl bg-red-50 border border-red-100 flex items-start gap-3">
                    <i class="fa-solid fa-circle-exclamation text-red-500 mt-0.5"></i>

                    <div class="text-xs text-red-600 font-medium">
                        Periksa kembali data yang kamu masukkan.
                    </div>
                </div>
            @endif

            <!-- Register Form -->
            <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data" class="space-y-5">

                @csrf

                <!-- Username -->
                <div>
                    <label for="username" class="block text-xs font-bold text-[#392F5A] mb-2">
                        Username
                    </label>

                    <div class="relative">

                        <i class="fa-solid fa-at absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>

                        <input
                            type="text"
                            id="username"
                            name="username"
                            value="{{ old('username') }}"
                            required
                            minlength="3"
                            maxlength="20"
                            autocomplete="username"
                            placeholder="Buat username"
                            class="w-full pl-11 pr-4 py-3.5 rounded-2xl bg-[#FFF8F0]/60 border border-[#E8E3DC] text-sm text-[#392F5A] placeholder-gray-400 focus:outline-none focus:border-[#FF8811] focus:ring-4 focus:ring-[#FF8811]/10 transition-all"
                        >

                    </div>

                    @error('username')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Full Name -->
                <div>
                    <label for="name" class="block text-xs font-bold text-[#392F5A] mb-2">
                        Nama Lengkap
                    </label>

                    <div class="relative">

                        <i class="fa-regular fa-user absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            autocomplete="name"
                            placeholder="Masukkan nama lengkap"
                            class="w-full pl-11 pr-4 py-3.5 rounded-2xl bg-[#FFF8F0]/60 border border-[#E8E3DC] text-sm text-[#392F5A] placeholder-gray-400 focus:outline-none focus:border-[#FF8811] focus:ring-4 focus:ring-[#FF8811]/10 transition-all"
                        >

                    </div>

                    @error('name')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-xs font-bold text-[#392F5A] mb-2">
                        Email
                    </label>

                    <div class="relative">

                        <i class="fa-regular fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="email"
                            placeholder="nama@email.com"
                            class="w-full pl-11 pr-4 py-3.5 rounded-2xl bg-[#FFF8F0]/60 border border-[#E8E3DC] text-sm text-[#392F5A] placeholder-gray-400 focus:outline-none focus:border-[#FF8811] focus:ring-4 focus:ring-[#FF8811]/10 transition-all"
                        >

                    </div>

                    @error('email')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Profile Image -->
                <div>
                    <label for="image" class="block text-xs font-bold text-[#392F5A] mb-2">
                        Foto Profil
                        <span class="text-gray-400 font-normal">(Opsional)</span>
                    </label>

                    <div class="relative">

                        <input
                            type="file"
                            id="image"
                            name="image"
                            accept=".jpg,.jpeg,.png,.webp"
                            class="w-full text-xs text-gray-500 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#FF8811]/10 file:text-[#FF8811] hover:file:bg-[#FF8811]/20 file:cursor-pointer border border-[#E8E3DC] rounded-2xl p-2 bg-[#FFF8F0]/60"
                        >

                    </div>

                    <p class="text-[10px] text-gray-400 mt-2">
                        Format JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.
                    </p>

                    @error('image')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-xs font-bold text-[#392F5A] mb-2">
                        Password
                    </label>

                    <div class="relative">

                        <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            required
                            minlength="8"
                            autocomplete="new-password"
                            placeholder="Minimal 8 karakter"
                            class="w-full pl-11 pr-4 py-3.5 rounded-2xl bg-[#FFF8F0]/60 border border-[#E8E3DC] text-sm text-[#392F5A] placeholder-gray-400 focus:outline-none focus:border-[#FF8811] focus:ring-4 focus:ring-[#FF8811]/10 transition-all"
                        >

                    </div>

                    @error('password')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-xs font-bold text-[#392F5A] mb-2">
                        Konfirmasi Password
                    </label>

                    <div class="relative">

                        <i class="fa-solid fa-shield-halved absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>

                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            required
                            minlength="8"
                            autocomplete="new-password"
                            placeholder="Ulangi password"
                            class="w-full pl-11 pr-4 py-3.5 rounded-2xl bg-[#FFF8F0]/60 border border-[#E8E3DC] text-sm text-[#392F5A] placeholder-gray-400 focus:outline-none focus:border-[#FF8811] focus:ring-4 focus:ring-[#FF8811]/10 transition-all"
                        >

                    </div>
                </div>

                <!-- Submit -->
                <button
                    type="submit"
                    class="w-full py-4 bg-[#FF8811] hover:bg-[#E87500] text-white font-black text-sm rounded-2xl shadow-lg shadow-[#FF8811]/25 hover:shadow-xl hover:shadow-[#FF8811]/30 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 flex items-center justify-center gap-2"
                >
                    <span>Buat Akun AVACREA</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </button>

            </form>

            <!-- Login Link -->
            <div class="text-center mt-8 pt-6 border-t border-gray-100">

                <p class="text-xs text-gray-500">
                    Sudah punya akun?

                    <a
                        href="{{ route('login') }}"
                        class="text-[#FF8811] font-extrabold hover:text-[#E87500] hover:underline transition"
                    >
                        Masuk sekarang
                    </a>
                </p>

            </div>

        </div>

        <!-- Footer -->
        <p class="text-center text-[10px] text-[#392F5A]/50 font-semibold tracking-widest mt-6">
            © AVACREA — OC STUDIO ONLINE
        </p>

    </main>

</body>
</html>