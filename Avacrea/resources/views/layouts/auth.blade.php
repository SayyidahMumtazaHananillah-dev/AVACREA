<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light only">
    <title>@yield('title', 'AVACREA - OC Studio Online')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'floral-white': '#FFF8F0',
                        'jasmine': '#F4D06F',
                        'princeton-orange': '#FF8811',
                        'brand-orange': '#FF8811',
                        'pearl-aqua': '#9DD9D2',
                        'space-indigo': '#392F5A',
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        /* Efek mesh gradient pastel di panel kiri persis seperti mockup */
        .auth-mesh-bg {
            background-color: #FFF8F0;
            background-image: 
                radial-gradient(at 12% 15%, rgba(244, 208, 111, 0.85) 0px, transparent 55%),
                radial-gradient(at 88% 12%, rgba(157, 217, 210, 0.75) 0px, transparent 50%),
                radial-gradient(at 82% 88%, rgba(255, 136, 17, 0.55) 0px, transparent 55%),
                radial-gradient(at 18% 85%, rgba(244, 208, 111, 0.45) 0px, transparent 55%);
        }
    </style>
</head>
<body style="background-color: #FFF8F0 !important; color-scheme: light;" class="text-space-indigo h-screen w-screen overflow-hidden flex font-sans select-none">

    <!-- PANEL KIRI (62%): Gradient Lembut + Logo AVACREA di Pojok Kiri Atas -->
    <div class="hidden lg:flex lg:w-[62%] h-full auth-mesh-bg relative p-10 flex-col justify-between">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3.5 w-fit group">
            <div class="w-11 h-11 rounded-2xl bg-princeton-orange flex items-center justify-center shadow-md shadow-princeton-orange/30 group-hover:scale-105 transition">
                <i class="fa-solid fa-wand-magic-sparkles text-white text-lg"></i>
            </div>
            <div>
                <h1 class="text-lg font-black tracking-wider text-space-indigo leading-none">AVACREA</h1>
                <p class="text-[9px] text-princeton-orange font-extrabold tracking-widest uppercase mt-1">OC Studio Online</p>
            </div>
        </a>
    </div>

    <!-- PANEL KANAN (38%): Area Form (Login / Register) -->
    <div class="w-full lg:w-[38%] h-full bg-[#FFF8F0] flex flex-col justify-center px-8 sm:px-14 lg:px-12 xl:px-16 overflow-y-auto">
        
        <!-- Logo Mobile (hanya tampil jika layar kecil) -->
        <div class="flex lg:hidden items-center justify-center gap-3 mb-8">
            <div class="w-10 h-10 rounded-2xl bg-princeton-orange flex items-center justify-center shadow-md">
                <i class="fa-solid fa-wand-magic-sparkles text-white text-base"></i>
            </div>
            <div>
                <h1 class="text-lg font-black tracking-wider text-space-indigo leading-none">AVACREA</h1>
                <p class="text-[9px] text-princeton-orange font-extrabold tracking-widest uppercase mt-0.5">OC Studio Online</p>
            </div>
        </div>

        @yield('content')
    </div>

</body>
</html>