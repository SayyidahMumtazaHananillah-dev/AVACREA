<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light only">

    <title>Login - AVACREA</title>

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

    <!-- Login Card -->
    <main class="relative z-10 w-full max-w-md">

        <div class="bg-white/95 backdrop-blur-sm rounded-[32px] p-8 sm:p-10 shadow-[0_20px_60px_rgba(57,47,90,0.12)] border border-white">

            <!-- Logo -->
            <div class="flex items-center justify-center gap-3 mb-9">

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
                    Welcome Back!
                </span>

                <h2 class="text-2xl sm:text-3xl font-black text-[#392F5A]">
                    Selamat Datang!
                </h2>

                <p class="text-sm text-gray-500 mt-2">
                    Masuk untuk melanjutkan kreasi karakter OC kamu.
                </p>

            </div>

            <!-- Error Message -->
            @if ($errors->any())
                <div class="mb-5 p-4 rounded-2xl bg-red-50 border border-red-100 flex items-start gap-3">
                    <i class="fa-solid fa-circle-exclamation text-red-500 mt-0.5"></i>

                    <div class="text-xs text-red-600 font-medium">
                        {{ $errors->first() }}
                    </div>
                </div>
            @endif

            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-5 p-4 rounded-2xl bg-green-50 border border-green-100 flex items-start gap-3">
                    <i class="fa-solid fa-circle-check text-green-500 mt-0.5"></i>

                    <div class="text-xs text-green-700 font-medium">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <!-- Login Form -->
            <form action="{{ route('login') }}" method="POST" class="space-y-5">

                @csrf

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
                            autocomplete="current-password"
                            placeholder="Masukkan password"
                            class="w-full pl-11 pr-4 py-3.5 rounded-2xl bg-[#FFF8F0]/60 border border-[#E8E3DC] text-sm text-[#392F5A] placeholder-gray-400 focus:outline-none focus:border-[#FF8811] focus:ring-4 focus:ring-[#FF8811]/10 transition-all"
                        >

                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between text-xs">

                    <label class="flex items-center gap-2 text-gray-500 cursor-pointer">
                        <input
                            type="checkbox"
                            name="remember"
                            value="1"
                            class="w-4 h-4 accent-[#FF8811] rounded"
                        >
                        Ingat saya
                    </label>

                </div>

                <!-- Submit -->
                <button
                    type="submit"
                    class="w-full py-4 bg-[#FF8811] hover:bg-[#E87500] text-white font-black text-sm rounded-2xl shadow-lg shadow-[#FF8811]/25 hover:shadow-xl hover:shadow-[#FF8811]/30 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 flex items-center justify-center gap-2"
                >
                    <span>Masuk ke AVACREA</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </button>

            </form>

            <!-- Register Link -->
            <div class="text-center mt-8 pt-6 border-t border-gray-100">

                <p class="text-xs text-gray-500">
                    Belum punya akun?

                    <a
                        href="{{ route('register') }}"
                        class="text-[#FF8811] font-extrabold hover:text-[#E87500] hover:underline transition"
                    >
                        Daftar sekarang
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