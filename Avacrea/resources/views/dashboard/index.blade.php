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
<!-- Top Navbar -->
    <header class="h-16 px-8 flex items-center justify-between border-b border-[#36210E]/20 bg-[#36210E]/95 backdrop-blur-md z-20 shrink-0">
        <!-- Logo AVACREA -->
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-2xl bg-princeton-orange flex items-center justify-center shadow-md shadow-princeton-orange/30">
                <i class="fa-solid fa-wand-magic-sparkles text-[#F0ECE1] text-lg"></i>
            </div>
            <div>
                <h1 class="text-xl font-black tracking-wider text-[#F0ECE1]">AVACREA</h1>
                <p class="text-[10px] text-princeton-orange font-bold tracking-widest uppercase">OC Studio Online</p>
            </div>
        </a>

        <!-- Tombol Logout di Kanan Atas -->
        <form method="POST" action="{{ route('logout') }}" class="m-0">
            @csrf
            <button type="submit" class="flex items-center gap-2 px-4 py-2 bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/30 text-rose-300 font-bold text-xs rounded-xl shadow-sm hover:scale-105 active:scale-95 transition-all">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Logout</span>
            </button>
        </form>
    </header>

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
    <nav class="h-20 bg-space-indigo px-8 flex items-center justify-around z-30 shadow-2xl border-t border-space-indigo">
        <!-- Home (Active) -->
        <a href="{{ route('dashboard') }}" class="flex flex-col items-center gap-1.5 text-jasmine group">
            <div class="w-11 h-11 rounded-2xl bg-jasmine/20 flex items-center justify-center transition-transform group-hover:scale-110">
                <i class="fa-solid fa-house text-xl"></i>
            </div>
            <span class="text-xs font-bold tracking-wider">Home</span>
        </a>

<!-- Explore & Search -->
<a href="{{ route('explore') }}" class="flex flex-col items-center gap-1.5 text-pearl-aqua/80 hover:text-pearl-aqua group transition">
    <div class="w-11 h-11 rounded-2xl bg-transparent flex items-center justify-center transition-transform group-hover:scale-110">
        <i class="fa-solid fa-compass text-xl"></i>
    </div>
    <span class="text-xs font-semibold tracking-wider">Explore & Search</span>
</a>

      <!-- Account -->
        <a href="{{ route('profile') }}" class="flex flex-col items-center gap-1.5 text-pearl-aqua/80 hover:text-pearl-aqua group transition">
            <div class="w-11 h-11 rounded-2xl bg-transparent flex items-center justify-center transition-transform group-hover:scale-110">
                <i class="fa-solid fa-circle-user text-xl"></i>
            </div>
            <span class="text-xs font-semibold tracking-wider">Account</span>
        </a>

            <!-- Popup Menu Account -->
            <div class="hidden group-hover:block hover:block absolute bottom-16 right-0 w-44 bg-space-indigo border border-pearl-aqua/30 rounded-2xl p-2 shadow-2xl">
<!-- Ganti link Account di navbar bawah index.blade.php menjadi: -->
<a href="{{ route('profile') }}" class="flex flex-col items-center gap-1.5 text-pearl-aqua/80 hover:text-pearl-aqua group transition">
    <div class="w-11 h-11 rounded-2xl bg-transparent flex items-center justify-center transition-transform group-hover:scale-110">
        <i class="fa-solid fa-circle-user text-xl"></i>
    </div>
    <span class="text-xs font-semibold tracking-wider">Account</span>
</a>
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-2 px-3 py-2.5 text-xs text-rose-300 hover:bg-rose-500/20 rounded-xl text-left transition font-semibold">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

</body>
</html>