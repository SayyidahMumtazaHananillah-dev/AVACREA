<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light only">

    <title>AVACREA - Profil Creator</title>

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

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

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

<body
    style="background-color: #F4D06F !important; color-scheme: light;"
    class="text-space-indigo h-screen w-screen overflow-hidden flex flex-col font-sans select-none">

    {{-- Navbar --}}
    @include('layouts.navbar')


    {{-- Main Content --}}
    <main class="flex-1 overflow-y-auto no-scrollbar px-6 md:px-14 py-8 flex flex-col items-center">

        {{-- Profile Header --}}
        <div class="flex flex-col items-center text-center mb-8 shrink-0">

            {{-- Foto Profil --}}
            <div class="relative group cursor-pointer mb-3">

                <div class="w-24 h-24 md:w-28 md:h-28 rounded-full p-1.5 bg-white shadow-xl shadow-space-indigo/10 border-2 border-white">

                    <div class="w-full h-full rounded-full bg-space-indigo flex items-center justify-center overflow-hidden border-2 border-white">

                        @if($user->image)

                            <img
                                src="{{ asset('storage/' . $user->image) }}"
                                alt="Foto Profil {{ $user->name }}"
                                class="w-full h-full object-cover"
                            >

                        @else

                            <span class="text-3xl md:text-4xl font-black text-jasmine">
                                {{ strtoupper(substr($user->name ?? 'A', 0, 1)) }}
                            </span>

                        @endif

                    </div>
                </div>

                {{-- Icon Kamera --}}
                <div class="absolute bottom-1 right-1 w-8 h-8 rounded-full bg-princeton-orange text-white flex items-center justify-center shadow-md border-2 border-white">
                    <i class="fa-solid fa-camera text-xs"></i>
                </div>

            </div>


            {{-- Nama User --}}
            <h2 class="text-2xl md:text-3xl font-black tracking-tight text-space-indigo leading-tight">
                {{ $user->name }}
            </h2>

            {{-- Username --}}
            <p class="text-xs md:text-sm font-bold text-princeton-orange mt-0.5 tracking-wide">
                {{ '@' . $user->username }}
            </p>

        </div>


        {{-- Section Daftar OC --}}
        <div class="w-full max-w-7xl">

            <div class="flex items-center justify-between mb-4 px-2">

                <h3 class="text-base font-extrabold uppercase tracking-wider text-space-indigo/80 flex items-center gap-2">

                    <i class="fa-solid fa-layer-group text-princeton-orange"></i>

                    Daftar OC Kamu ({{ $ocs->count() }})

                </h3>

            </div>


            {{-- Jika User Memiliki OC --}}
            @if($ocs->count() > 0)

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 pb-12">

                    @foreach($ocs as $oc)

                        <div class="relative group bg-white border-2 border-space-indigo/10 rounded-3xl overflow-hidden shadow-lg shadow-space-indigo/5 hover:shadow-2xl hover:border-princeton-orange/60 transition-all duration-300 flex flex-col aspect-square">


                            {{-- Gambar OC --}}
                            <div class="relative w-full flex-1 flex items-center justify-center overflow-hidden bg-gradient-to-b from-[#FFF8F0] to-pearl-aqua/15 p-4">

                                <img
                                    src="{{ $oc->thumbnail ?? asset('Assets/Character/Base/base color.png') }}"
                                    alt="{{ $oc->name }}"
                                    class="h-full w-auto object-contain transition-transform duration-500 group-hover:scale-110 drop-shadow-md"
                                >

                                {{-- Home Active --}}
                                @if(!empty($oc->is_active))

                                    <div class="absolute top-3 left-3 bg-princeton-orange text-[#FFF8F0] text-[10px] font-black tracking-wider uppercase px-2.5 py-1 rounded-full shadow">

                                        Home Active

                                    </div>

                                @endif

                            </div>


                            {{-- Menu Titik Tiga --}}
                            <div class="absolute top-3 right-3 z-30">

                                <button
                                    type="button"
                                    onclick="toggleDropdown(event, 'menu-{{ $oc->id }}')"
                                    class="w-9 h-9 rounded-2xl bg-[#FFF8F0]/90 backdrop-blur-md border border-space-indigo/10 hover:bg-space-indigo hover:text-jasmine flex items-center justify-center text-space-indigo shadow-md transition-all">

                                    <i class="fa-solid fa-ellipsis-vertical text-sm"></i>

                                </button>


                                {{-- Dropdown --}}
                                <div
                                    id="menu-{{ $oc->id }}"
                                    class="hidden absolute right-0 mt-2 w-48 bg-space-indigo text-[#FFF8F0] rounded-2xl p-2 shadow-2xl border border-pearl-aqua/20 z-40 text-left">

                                    <a
                                        href="#edit"
                                        class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold hover:bg-white/10 transition text-floral-white">

                                        <i class="fa-solid fa-pen text-jasmine"></i>

                                        <span>Edit Avatar</span>

                                    </a>


                                    <button
                                        type="button"
                                        class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold hover:bg-white/10 transition text-floral-white">

                                        <i class="fa-solid fa-star text-pearl-aqua"></i>

                                        <span>Jadikan Thumbnail Home</span>

                                    </button>


                                    <hr class="border-pearl-aqua/10 my-1">


                                    <button
                                        type="button"
                                        class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold hover:bg-rose-500/20 text-rose-300 transition">

                                        <i class="fa-solid fa-trash-can"></i>

                                        <span>Hapus Avatar</span>

                                    </button>

                                </div>

                            </div>


                            {{-- Nama dan Deskripsi OC --}}
                            <div class="absolute bottom-0 inset-x-0 bg-space-indigo/90 backdrop-blur-md text-[#FFF8F0] p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-300 ease-out z-20 flex flex-col justify-center">

                                <p class="text-sm font-black truncate text-jasmine tracking-wide">
                                    {{ $oc->name }}
                                </p>

                                <p class="text-[11px] text-pearl-aqua/90 line-clamp-1">
                                    {{ $oc->description ?? 'Tidak ada deskripsi' }}
                                </p>

                            </div>

                        </div>

                    @endforeach

                </div>


            {{-- Jika User Belum Memiliki OC --}}
            @else

                <div class="w-full min-h-[380px] rounded-3xl border-2 border-dashed border-space-indigo/20 flex flex-col items-center justify-center text-center p-8 bg-white/40 shadow-sm">

                    <div class="w-20 h-20 rounded-3xl bg-pearl-aqua/30 flex items-center justify-center text-space-indigo text-3xl mb-4 shadow-inner">

                        <i class="fa-solid fa-ghost"></i>

                    </div>


                    <h4 class="text-xl font-extrabold text-space-indigo tracking-tight">

                        Belum Ada OC Terdaftar

                    </h4>


                    <p class="text-xs text-space-indigo/70 max-w-sm mt-1 mb-6">

                        Kamu belum menyimpan karakter original sama sekali.
                        Mulai petualangan kreatifmu sekarang!

                    </p>


                    <button
                        type="button"
                        class="px-8 py-3.5 bg-princeton-orange hover:bg-orange-600 text-[#FFF8F0] font-black text-sm tracking-wider rounded-2xl shadow-xl shadow-princeton-orange/30 hover:scale-105 active:scale-95 transition-all duration-200 border-b-4 border-amber-800 flex items-center gap-3">

                        <i class="fa-solid fa-plus-circle text-base"></i>

                        <span>Bikin avatar sekarang!</span>

                    </button>

                </div>

            @endif

        </div>

    </main>

    <!-- Bottom Navbar -->
    @include('layouts.bottom-navbar')

    {{-- Dropdown Script --}}
    <script>

        function toggleDropdown(event, menuId) {

            event.stopPropagation();

            document.querySelectorAll('[id^="menu-"]').forEach(menu => {

                if (menu.id !== menuId) {
                    menu.classList.add('hidden');
                }

            });

            const targetMenu = document.getElementById(menuId);

            if (targetMenu) {
                targetMenu.classList.toggle('hidden');
            }

        }


        window.addEventListener('click', () => {

            document.querySelectorAll('[id^="menu-"]').forEach(menu => {
                menu.classList.add('hidden');
            });

        });

    </script>

</body>
</html>
