<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light only">
    <title>AVACREA - User Dashboard</title>
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
    <style>
        /* Karakter dibuat ekstra besar, menempel ke dasar navbar bawah */
        .character-layer {
            position: absolute;
            bottom: -20px;
            left: 50%;
            transform: translateX(-50%);
            height: 100%;
            width: auto;
            max-width: none;
            object-fit: contain;
            pointer-events: none;
            user-select: none;
        }
    </style>
</head>
<body style="background-color: #F4D06F !important; color-scheme: light;" class="text-space-indigo h-screen w-screen overflow-hidden flex flex-col font-sans select-none">

<!-- Top Navbar -->
@include('layouts.navbar')

    <!-- Main Workspace -->
    <main class="flex-1 relative flex flex-row items-end justify-between px-6 md:px-16 overflow-hidden">
        
        <!-- Ambient Rings -->
        <div class="absolute -left-10 bottom-0 w-[650px] h-[650px] rounded-full bg-pearl-aqua/20 blur-3xl pointer-events-none"></div>
        <div class="absolute left-8 bottom-6 w-[520px] h-[520px] rounded-full border-2 border-dashed border-pearl-aqua/40 pointer-events-none animate-spin" style="animation-duration: 60s;">
            <div class="w-[420px] h-[420px] m-auto rounded-full border border-jasmine/40"></div>
        </div>

        <!-- SISI KIRI: Avatar Super Besar (Extra Gede & Utuh) -->
        <section class="relative w-8/12 h-full flex items-end justify-center z-10">
            <div class="relative w-full h-full flex items-end justify-center">
                <!-- Layer 1: Base Color -->
                <img src="{{ $baseAssets['color'] }}" 
                     alt="Base Color" 
                     class="character-layer z-10 drop-shadow-[0_25px_35px_rgba(57,47,90,0.22)]">

                <!-- Layer 2: Base Lineart -->
                <img src="{{ $baseAssets['lineart'] }}" 
                     alt="Base Lineart" 
                     class="character-layer z-20">
            </div>
        </section>

        <!-- SISI KANAN: Dua Tombol Aksi Utama (Pop, Lebar, dan Berjarak) -->
        <section class="w-4/12 h-full flex flex-col items-center justify-center gap-10 z-20 pl-2 pr-6">
            
            <!-- Tombol 1: Kustomisasi Avatar -->
            <a href="#kustomisasi" class="w-full max-w-sm py-6 px-8 bg-princeton-orange hover:bg-orange-600 text-[#FFF8F0] font-black text-xl tracking-wider rounded-3xl shadow-2xl shadow-princeton-orange/40 hover:scale-105 active:scale-95 transition-all duration-200 border-b-8 border-amber-800 flex items-center justify-center gap-4">
                <i class="fa-solid fa-paintbrush text-2xl"></i>
                <span>Kustomisasi Avatar</span>
            </a>

            <!-- Tombol 2: Tambah Avatar -->
<!-- Tombol 2: Tambah Avatar (Pearl Aqua) -->
            <button class="w-full max-w-sm py-6 px-8 bg-[#6ed4c8] hover:bg-[#5898ba] text-[#FFF8F0] font-black text-xl tracking-wider rounded-3xl shadow-xl shadow-[#9DD9D2]/35 hover:scale-105 active:scale-95 transition-all duration-200 border-b-8 border-[#365e97] flex items-center justify-center gap-4">
                <i class="fa-solid fa-plus text-2xl font-black"></i>
                <span>Tambah Avatar</span>
            </button>

        </section>
    </main>

<!-- Bottom Navbar -->
@include('layouts.bottom-navbar')

</body>
</html>