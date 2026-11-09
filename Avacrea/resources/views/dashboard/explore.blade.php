<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light only">
    <title>AVACREA - Explore & Search</title>
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
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>
<body style="background-color: #FFF8F0 !important; color-scheme: light;" class="text-space-indigo h-screen w-screen overflow-hidden flex flex-col font-sans select-none">

    @include('layouts.navbar')

    <!-- Main Content Area -->
    <main class="flex-1 overflow-y-auto no-scrollbar px-6 md:px-14 py-6 flex flex-col items-center">
        
        <!-- Search Bar Username di Atas -->
        <div class="w-full max-w-2xl mb-8 shrink-0">
            <form action="{{ route('explore') }}" method="GET" class="relative flex items-center">
                <div class="absolute left-5 text-space-indigo/50">
                    <i class="fa-solid fa-magnifying-glass text-lg"></i>
                </div>
                <input type="text" 
                       name="search" 
                       value="{{ $search ?? '' }}"
                       placeholder="Cari username creator atau nama OC..." 
                       class="w-full pl-14 pr-32 py-4 rounded-3xl bg-white border-2 border-space-indigo/15 focus:border-princeton-orange focus:outline-none shadow-md text-space-indigo placeholder-space-indigo/40 text-sm font-semibold transition">
                <button type="submit" class="absolute right-3 px-6 py-2.5 bg-princeton-orange hover:bg-orange-600 text-white font-bold text-xs rounded-2xl shadow-md transition active:scale-95">
                    Cari
                </button>
            </form>
        </div>

        <!-- Judul & Status Galeri -->
        <div class="w-full max-w-7xl flex items-center justify-between mb-5 px-2 shrink-0">
            <h2 class="text-lg font-black uppercase tracking-wider text-space-indigo flex items-center gap-2.5">
                <i class="fa-solid fa-compass text-princeton-orange text-xl"></i>
                <span>Jelajahi OC Komunitas ({{ count($ocs) }})</span>
            </h2>
            @if(!empty($search))
                <a href="{{ route('explore') }}" class="text-xs font-bold text-princeton-orange hover:underline">
                    Reset Filter
                </a>
            @endif
        </div>

        <!-- Grid 5 Shaf (20 OC: 5 Baris x 4 Kolom di Layar Lebar) -->
        <div class="w-full max-w-7xl pb-16">
            @if(count($ocs) > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($ocs as $oc)
                        <div onclick="openOcDetail({{ json_encode($oc) }})" 
                             class="group relative bg-white border-2 border-space-indigo/10 rounded-3xl overflow-hidden shadow-md hover:shadow-2xl hover:border-princeton-orange transition-all duration-300 cursor-pointer flex flex-col aspect-square">
                            
                            <!-- Thumbnail Area -->
                            <div class="w-full flex-1 flex items-center justify-center p-4 bg-gradient-to-b from-[#FFF8F0] to-pearl-aqua/15 overflow-hidden">
                                <img src="{{ $oc['thumbnail'] }}" 
                                     alt="{{ $oc['name'] }}" 
                                     class="h-full w-auto object-contain transition-transform duration-500 group-hover:scale-110 drop-shadow-md">
                            </div>

                            <!-- Floating Creator Badge -->
                            <div class="absolute top-3 left-3 bg-space-indigo/80 backdrop-blur-md text-jasmine px-3 py-1 rounded-full text-[11px] font-bold shadow flex items-center gap-1.5 border border-pearl-aqua/20">
                                <i class="fa-solid fa-user-circle text-xs text-pearl-aqua"></i>
                                <span>{{ '@' . $oc['creator'] }}</span>
                            </div>

                            <!-- Footer Card: Nama OC -->
                            <div class="p-3.5 bg-white border-t border-space-indigo/5 flex items-center justify-between">
                                <div>
                                    <h3 class="text-sm font-black text-space-indigo truncate group-hover:text-princeton-orange transition">
                                        {{ $oc['name'] }}
                                    </h3>
                                    <p class="text-[11px] font-bold text-space-indigo/60">
                                        {{ $oc['role'] }}
                                    </p>
                                </div>
                                <div class="w-8 h-8 rounded-xl bg-pearl-aqua/20 text-space-indigo flex items-center justify-center group-hover:bg-princeton-orange group-hover:text-white transition">
                                    <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="w-full py-20 rounded-3xl border-2 border-dashed border-space-indigo/20 flex flex-col items-center justify-center text-center p-8 bg-white/40">
                    <i class="fa-solid fa-circle-question text-4xl text-space-indigo/40 mb-3"></i>
                    <h3 class="text-lg font-bold text-space-indigo">Tidak ditemukan OC dengan keyword tersebut</h3>
                    <p class="text-xs text-space-indigo/60 mt-1">Coba gunakan nama creator atau nama OC lain.</p>
                </div>
            @endif
        </div>
    </main>

    <!-- Bottom Navbar -->
    @include('layouts.bottom-navbar')

    <!-- MODAL DETAIL OC: Mengambil Setengah Halaman untuk Gambar + Sisi Kanan Biodata Lengkap -->
    <div id="ocModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 md:p-8 bg-space-indigo/70 backdrop-blur-md">
        
        <!-- Modal Card Container (Hampir Seluruh Layar, Dibagi 2 Kolom) -->
        <div class="relative w-full max-w-5xl h-[85vh] bg-[#FFF8F0] rounded-3xl border-2 border-space-indigo/20 shadow-2xl overflow-hidden flex flex-col md:flex-row">
            
            <!-- Tombol Close Modal di Kanan Atas -->
            <button onclick="closeOcDetail()" class="absolute top-4 right-4 z-30 w-11 h-11 rounded-full bg-space-indigo text-white hover:bg-princeton-orange flex items-center justify-center shadow-lg transition">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>

            <!-- SISI KIRI: Gambar OC Mengambil Setengah Halaman (50%) -->
            <div class="relative w-full md:w-1/2 h-1/2 md:h-full bg-gradient-to-tr from-pearl-aqua/30 via-[#FFF8F0] to-jasmine/20 flex items-end justify-center p-6 border-b md:border-b-0 md:border-r border-space-indigo/10 overflow-hidden">
                <!-- Background Glow Ring -->
                <div class="absolute w-80 h-80 rounded-full border-2 border-dashed border-princeton-orange/30 animate-spin pointer-events-none" style="animation-duration: 40s;"></div>

                <!-- Gambar OC Besar Utuh Tanpa Terpotong -->
                <img id="modalOcImage" 
                     src="" 
                     alt="OC Preview" 
                     class="relative z-10 max-h-[92%] w-auto object-contain drop-shadow-[0_20px_25px_rgba(57,47,90,0.3)]">
            </div>

            <!-- SISI KANAN: Biodata OC + Username Pembuat (50%) -->
            <div class="w-full md:w-1/2 h-1/2 md:h-full p-8 md:p-10 flex flex-col justify-between overflow-y-auto no-scrollbar bg-white">
                <div>
                    <!-- Tag Creator & Role -->
                    <div class="flex items-center gap-3 mb-4">
                        <div class="flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-space-indigo text-jasmine text-xs font-bold shadow">
                            <i class="fa-solid fa-user-astronaut text-pearl-aqua"></i>
                            <span id="modalOcCreator">@username</span>
                        </div>
                        <span id="modalOcRole" class="px-3.5 py-1.5 rounded-full bg-pearl-aqua/30 text-space-indigo text-xs font-black">
                            Role
                        </span>
                    </div>

                    <!-- Nama OC -->
                    <h3 id="modalOcName" class="text-3xl md:text-4xl font-black text-space-indigo tracking-tight leading-tight mb-2">
                        Nama OC
                    </h3>

                    <div class="flex items-center gap-2 text-xs font-bold text-princeton-orange mb-6">
                        <i class="fa-solid fa-id-badge"></i>
                        <span id="modalOcAge">Usia: -</span>
                    </div>

                    <!-- Kotak Cerita / Biodata -->
                    <div class="p-5 rounded-2xl bg-[#FFF8F0] border border-space-indigo/10 shadow-inner mb-6">
                        <h4 class="text-xs font-black uppercase tracking-wider text-space-indigo/60 mb-2 flex items-center gap-2">
                            <i class="fa-solid fa-scroll text-princeton-orange"></i>
                            Deskripsi & Kisah Karakter
                        </h4>
                        <p id="modalOcBio" class="text-sm font-medium text-space-indigo/80 leading-relaxed">
                            Deskripsi biodata...
                        </p>
                    </div>
                </div>

                <!-- Aksi Interaksi Komunitas (Like / Favorite) -->
                <div class="pt-4 border-t border-space-indigo/10 flex items-center gap-3">
                    <button class="flex-1 py-3.5 bg-princeton-orange hover:bg-orange-600 text-white font-black text-sm rounded-2xl shadow-lg shadow-princeton-orange/30 flex items-center justify-center gap-2 transition active:scale-95">
                        <i class="fa-solid fa-heart"></i>
                        <span>Sukai Karya</span>
                    </button>
                    <button class="px-5 py-3.5 bg-pearl-aqua/30 hover:bg-pearl-aqua/50 text-space-indigo font-bold text-sm rounded-2xl transition">
                        <i class="fa-solid fa-share-nodes"></i>
                    </button>
                </div>
            </div>

        </div>
    </div>

    <!-- Script Kontrol Modal Biodata OC -->
    <script>
        function openOcDetail(oc) {
            document.getElementById('modalOcImage').src = oc.thumbnail;
            document.getElementById('modalOcName').innerText = oc.name;
            document.getElementById('modalOcCreator').innerText = '@' + oc.creator;
            document.getElementById('modalOcRole').innerText = oc.role;
            document.getElementById('modalOcAge').innerText = 'Estimasi Umur: ' + oc.age;
            document.getElementById('modalOcBio').innerText = oc.bio;

            document.getElementById('ocModal').classList.remove('hidden');
        }

        function closeOcDetail() {
            document.getElementById('ocModal').classList.add('hidden');
        }

        // Tutup modal jika user menekan tombol ESC di keyboard
        window.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeOcDetail();
        });
    </script>
</body>
</html>