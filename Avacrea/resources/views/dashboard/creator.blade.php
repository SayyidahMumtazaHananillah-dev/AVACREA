<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light only">
    <title>AVACREA - OC Creator Studio</title>
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
        .canvas-layer {
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            height: 94%;
            width: auto;
            max-width: none;
            object-fit: contain;
            pointer-events: none;
            user-select: none;
        }
    </style>
</head>
<body style="background-color: #FFF8F0 !important; color-scheme: light;" class="text-space-indigo h-screen w-screen overflow-hidden flex flex-col font-sans select-none">

    <!-- Top Navbar -->
    <header class="h-16 px-8 flex items-center justify-between border-b border-space-indigo/10 bg-[#FFF8F0] z-20 shrink-0">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
            <div class="w-10 h-10 rounded-2xl bg-princeton-orange flex items-center justify-center shadow-md shadow-princeton-orange/30 group-hover:scale-105 transition">
                <i class="fa-solid fa-wand-magic-sparkles text-white text-lg"></i>
            </div>
            <div>
                <h1 class="text-xl font-black tracking-wider text-space-indigo">AVACREA</h1>
                <p class="text-[10px] text-princeton-orange font-bold tracking-widest uppercase">OC Studio Online</p>
            </div>
        </a>

        <button type="button" onclick="resetCanvas()" class="px-5 py-2 rounded-full bg-white border-2 border-space-indigo/15 hover:border-princeton-orange text-space-indigo font-extrabold text-xs shadow-sm transition active:scale-95">
            OC baru
        </button>
    </header>

    <!-- Main Studio Workspace -->
    <main class="flex-1 flex flex-col lg:flex-row gap-6 px-6 md:px-10 py-5 overflow-hidden">

        <!-- KOLOM KIRI: Preview Canvas -->
        <section class="w-full lg:w-[36%] h-full flex flex-col justify-between gap-4 shrink-0">
            <div class="relative flex-1 w-full bg-white rounded-[2rem] border-[3px] border-space-indigo p-3 shadow-lg flex items-center justify-center overflow-hidden">
                <div id="previewBg" style="background-color: #9DD9D2;" class="relative w-full h-full rounded-[1.4rem] overflow-hidden flex items-end justify-center transition-colors duration-300">
                    
                    <div class="absolute -top-6 -left-6 w-36 h-36 rounded-full bg-white/25 pointer-events-none"></div>

                    <!-- LAYER Z-INDEX RENDAH (Rambut Belakang di belakang badan) -->
                    <div id="canvas-back-layers" class="absolute inset-0 z-[5] pointer-events-none"></div>

                    <!-- LAYER TUBUH DASAR (Base Color & Lineart) -->
                    <img src="{{ $baseAssets['color'] }}" alt="Base Color" id="layer-skin" class="canvas-layer z-10">
                    <img src="{{ $baseAssets['lineart'] }}" alt="Base Lineart" class="canvas-layer z-20">

                    <!-- LAYER Z-INDEX TINGGI (Baju, Mata, Mulut, Poni, Aksesori di depan badan) -->
                    <div id="canvas-front-layers" class="absolute inset-0 z-30 pointer-events-none"></div>

                    <!-- Badge Info -->
                    <div id="activeBadgeInfo" class="absolute top-3 right-3 z-40 bg-space-indigo/85 backdrop-blur-sm text-floral-white px-3 py-1 rounded-full text-[10px] font-bold tracking-wide shadow">
                        Base Model
                    </div>

                    <!-- Tombol Quick Randomize -->
                    <button type="button" 
                            onclick="randomizeOc()" 
                            title="Acak Karakter"
                            class="absolute bottom-3.5 right-3.5 z-40 w-11 h-11 rounded-2xl bg-jasmine hover:bg-amber-300 text-space-indigo border-2 border-space-indigo/20 shadow-lg flex items-center justify-center text-xl hover:rotate-12 active:scale-90 transition-all">
                        <i class="fa-solid fa-dice"></i>
                    </button>
                </div>
            </div>

            <!-- Form Simpan -->
            <form action="{{ route('creator.save') }}" method="POST" class="flex flex-col gap-3 shrink-0">
                @csrf
                <input type="hidden" name="oc_payload" id="ocPayloadInput">

                <input type="text" 
                       name="name" 
                       id="ocNameInput"
                       placeholder="Nama OC" 
                       required
                       class="w-full px-5 py-3.5 rounded-2xl bg-white border-2 border-space-indigo/20 focus:border-princeton-orange focus:outline-none text-sm font-bold text-space-indigo placeholder-space-indigo/40 shadow-sm transition">

                <div class="grid grid-cols-4 gap-2.5">
                    <button type="submit" class="py-3 px-2 rounded-2xl bg-princeton-orange hover:bg-orange-600 text-white font-extrabold text-xs tracking-wide shadow-md shadow-princeton-orange/30 active:scale-95 transition">
                        Save
                    </button>
                    <button type="button" onclick="alert('Fitur Download PNG segera hadir!')" class="py-3 px-2 rounded-2xl bg-space-indigo hover:bg-space-indigo/90 text-white font-extrabold text-xs tracking-wide shadow-md active:scale-95 transition">
                        Download
                    </button>
                    <button type="button" onclick="alert('Link share disalin!')" class="py-3 px-2 rounded-2xl bg-pearl-aqua hover:bg-[#8bcac3] text-space-indigo font-extrabold text-xs tracking-wide shadow-md active:scale-95 transition">
                        Share
                    </button>
                    <button type="button" onclick="randomizeOc()" class="py-3 px-2 rounded-2xl bg-space-indigo hover:bg-space-indigo/90 text-white font-extrabold text-xs tracking-wide shadow-md active:scale-95 transition">
                        Randomize
                    </button>
                </div>
            </form>
        </section>

        <!-- KOLOM KANAN: Panel Kustomisasi -->
        <section class="w-full lg:w-[64%] h-full bg-space-indigo rounded-[2rem] p-6 flex flex-col gap-5 shadow-2xl overflow-hidden">
            
            <!-- Pill Tabs Kategori dari Database -->
            <div class="flex flex-wrap items-center gap-2 shrink-0" id="categoryTabsContainer">
                @foreach($categories as $index => $cat)
                    <button type="button" 
                            onclick="selectCategory('{{ $cat['id'] }}')"
                            data-cat-id="{{ $cat['id'] }}"
                            class="category-pill px-4 py-2 rounded-full text-xs font-extrabold tracking-wide transition-all duration-200 {{ $index === 0 ? 'bg-princeton-orange text-white shadow-md shadow-princeton-orange/30' : 'bg-white/10 text-floral-white/80 hover:bg-white/20 hover:text-white border border-white/10' }}">
                        {{ $cat['name'] }}
                        @if(count($cat['assets']) > 0)
                            <span class="ml-1 px-1.5 py-0.2 rounded-full bg-black/20 text-[10px]">{{ count($cat['assets']) }}</span>
                        @endif
                    </button>
                @endforeach
            </div>

            <!-- Palet Pilihan Warna -->
            <div class="flex flex-wrap items-center gap-3 shrink-0 pb-1">
                <span class="text-xs font-bold text-floral-white/90 mr-1">Warna</span>
                <div class="flex flex-wrap items-center gap-2.5" id="colorSwatchesContainer">
                    @foreach($colors as $cIndex => $color)
                        <button type="button"
                                onclick="selectColor('{{ $color['hex'] }}', this)"
                                title="{{ $color['name'] }}"
                                style="background-color: {{ $color['hex'] }};"
                                class="color-swatch w-7 h-7 rounded-full transition-transform hover:scale-115 focus:outline-none {{ $cIndex === 3 ? 'ring-2 ring-white ring-offset-2 ring-offset-space-indigo scale-110' : 'border-2 border-white/30' }}">
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Grid Pilihan Item (Hanya menampilkan item asli dari DB, tanpa kotak dummy) -->
            <div class="flex-1 bg-[#FFF8F0] rounded-[1.5rem] p-5 overflow-y-auto no-scrollbar shadow-inner">
                <div id="assetGridContainer" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                    <!-- Di-render dinamis oleh JS -->
                </div>
            </div>

        </section>

    </main>

    @if(session('success'))
        <div id="toastAlert" class="fixed bottom-6 right-6 z-50 bg-space-indigo text-jasmine border-2 border-princeton-orange px-6 py-3.5 rounded-2xl shadow-2xl flex items-center gap-3 font-bold text-xs animate-bounce">
            <i class="fa-solid fa-circle-check text-pearl-aqua text-base"></i>
            <span>{{ session('success') }}</span>
        </div>
        <script>setTimeout(() => document.getElementById('toastAlert')?.remove(), 3500);</script>
    @endif

    <script>
        const categoriesData = @json($categories);
        const availableColors = @json($colors);

        // Urutan tumpukan layer
        const zOrderMap = {
            back_hair: 5,
            clothes: 25,
            right_eye: 26,
            left_eye: 27,
            nose: 28,
            mouth: 29,
            bangs: 30,
            acc_1: 31,
            acc_2: 32,
            acc_3: 33
        };

        const ocState = {
            activeCategory: categoriesData.length > 0 ? categoriesData[0].id : 'background',
            selections: {}
        };

        // Inisialisasi pilihan awal kosong (null) untuk semua kategori
        categoriesData.forEach(cat => {
            ocState.selections[cat.id] = {
                asset: null,
                color: cat.id === 'background' ? '#9DD9D2' : '#392F5A'
            };
        });

        function getActiveCategoryObj() {
            return categoriesData.find(c => c.id === ocState.activeCategory);
        }

        function selectCategory(catId) {
            ocState.activeCategory = catId;

            document.querySelectorAll('.category-pill').forEach(btn => {
                if (btn.dataset.catId === catId) {
                    btn.className = 'category-pill px-4 py-2 rounded-full text-xs font-extrabold tracking-wide transition-all duration-200 bg-princeton-orange text-white shadow-md shadow-princeton-orange/30';
                } else {
                    btn.className = 'category-pill px-4 py-2 rounded-full text-xs font-extrabold tracking-wide transition-all duration-200 bg-white/10 text-floral-white/80 hover:bg-white/20 hover:text-white border border-white/10';
                }
            });

            renderAssetGrid();
            updateBadgeInfo();
        }

        function selectColor(hexColor, btnElement) {
            const cat = ocState.activeCategory;
            if (!ocState.selections[cat]) return;

            ocState.selections[cat].color = hexColor;

            document.querySelectorAll('.color-swatch').forEach(el => {
                el.classList.remove('ring-2', 'ring-white', 'ring-offset-2', 'ring-offset-space-indigo', 'scale-110');
                el.classList.add('border-2', 'border-white/30');
            });
            btnElement.classList.remove('border-2', 'border-white/30');
            btnElement.classList.add('ring-2', 'ring-white', 'ring-offset-2', 'ring-offset-space-indigo', 'scale-110');

            renderCanvasLayers();
        }

        function selectAssetItem(assetObj) {
            const cat = ocState.activeCategory;
            ocState.selections[cat].asset = assetObj;

            renderAssetGrid();
            renderCanvasLayers();
            updateBadgeInfo();
        }

        function renderAssetGrid() {
            const grid = document.getElementById('assetGridContainer');
            const catObj = getActiveCategoryObj();
            if (!catObj) return;

            const currentSel = ocState.selections[catObj.id];
            const assets = catObj.assets || [];
            let html = '';

            // Slot 1: Tombol Kosong / Lepas Item (selalu ada)
            const isNoneSelected = currentSel.asset === null;
            html += `
                <button type="button" onclick='selectAssetItem(null)'
                        title="Kosongkan / Lepas"
                        class="aspect-square rounded-2xl bg-white border-2 ${isNoneSelected ? 'border-princeton-orange ring-2 ring-princeton-orange/30' : 'border-space-indigo/10 hover:border-space-indigo/30'} flex flex-col items-center justify-center gap-1.5 transition-all shadow-sm group">
                    <i class="fa-solid fa-ban text-2xl ${isNoneSelected ? 'text-princeton-orange' : 'text-space-indigo/30 group-hover:text-space-indigo/60'}"></i>
                    <span class="text-[10px] font-bold text-space-indigo/40">Kosong</span>
                </button>
            `;

            // Render HANYA aset asli yang ada di database (kalau kosong ya tidak render kotak ungu lagi)
            assets.forEach(asset => {
                const isSelected = currentSel.asset && currentSel.asset.id === asset.id;
                const assetJson = JSON.stringify(asset).replace(/'/g, "&#39;");

                let extraImgs = '';
                if (asset.extra_colors && asset.extra_colors.length > 0) {
                    asset.extra_colors.forEach((url, idx) => {
                        extraImgs += `<img src="${url}" class="absolute inset-0 w-full h-full object-contain" style="z-index: ${10 + idx};">`;
                    });
                }

                html += `
                    <button type="button" onclick='selectAssetItem(${assetJson})'
                            class="relative aspect-square rounded-2xl bg-white border-[3px] ${isSelected ? 'border-princeton-orange shadow-md scale-[1.02]' : 'border-space-indigo/10 hover:border-princeton-orange/50'} overflow-hidden transition-all shadow-sm flex items-center justify-center p-2 group">
                        
                        <div class="relative w-full h-full flex items-center justify-center">
                            ${extraImgs}
                            <img src="${asset.color1_url}" class="absolute inset-0 w-full h-full object-contain z-20 group-hover:scale-105 transition-transform">
                            <img src="${asset.lineart_url}" class="absolute inset-0 w-full h-full object-contain z-30 group-hover:scale-105 transition-transform">
                        </div>

                        <span class="absolute bottom-1.5 right-1.5 z-40 bg-space-indigo/85 text-white text-[9px] font-mono font-bold px-2 py-0.5 rounded-full">
                            ${asset.name}
                        </span>
                    </button>
                `;
            });

            grid.innerHTML = html;
        }

        function renderCanvasLayers() {
            // 1. Update warna background kanvas
            const bgSel = ocState.selections['background'];
            document.getElementById('previewBg').style.backgroundColor = bgSel ? bgSel.color : '#9DD9D2';

            const backContainer = document.getElementById('canvas-back-layers');
            const frontContainer = document.getElementById('canvas-front-layers');
            let backHtml = '';
            let frontHtml = '';

            // 2. Susun semua layer aktif dari tiap kategori
            Object.keys(ocState.selections).forEach(catSlug => {
                if (catSlug === 'background' || catSlug === 'skin') return;

                const item = ocState.selections[catSlug].asset;
                if (!item) return;

                const zBase = zOrderMap[catSlug] || 25;
                let layerGroup = '';

                // Render Extra Colors (jika ada)
                if (item.extra_colors && item.extra_colors.length > 0) {
                    item.extra_colors.forEach((url, idx) => {
                        layerGroup += `<img src="${url}" class="canvas-layer" style="z-index: ${zBase};">`;
                    });
                }

                // Render Color 1 + Lineart
                layerGroup += `<img src="${item.color1_url}" class="canvas-layer" style="z-index: ${zBase};">`;
                layerGroup += `<img src="${item.lineart_url}" class="canvas-layer" style="z-index: ${zBase + 1};">`;

                if (catSlug === 'back_hair') {
                    backHtml += layerGroup;
                } else {
                    frontHtml += layerGroup;
                }
            });

            backContainer.innerHTML = backHtml;
            frontContainer.innerHTML = frontHtml;

            document.getElementById('ocPayloadInput').value = JSON.stringify(ocState.selections);
        }

        function updateBadgeInfo() {
            const catObj = getActiveCategoryObj();
            if (!catObj) return;
            const item = ocState.selections[catObj.id].asset;
            document.getElementById('activeBadgeInfo').innerText = item 
                ? `${catObj.name} • ${item.name}` 
                : `${catObj.name} (${catObj.assets.length} item)`;
        }

        function randomizeOc() {
            categoriesData.forEach(cat => {
                const randomColorObj = availableColors[Math.floor(Math.random() * availableColors.length)];
                ocState.selections[cat.id].color = randomColorObj.hex;

                if (cat.assets && cat.assets.length > 0) {
                    const randomAsset = cat.assets[Math.floor(Math.random() * cat.assets.length)];
                    ocState.selections[cat.id].asset = randomAsset;
                }
            });

            renderAssetGrid();
            renderCanvasLayers();
            document.getElementById('activeBadgeInfo').innerText = 'Randomized!';
        }

        function resetCanvas() {
            document.getElementById('ocNameInput').value = '';
            categoriesData.forEach(cat => {
                ocState.selections[cat.id].asset = null;
                ocState.selections[cat.id].color = cat.id === 'background' ? '#9DD9D2' : '#392F5A';
            });
            renderAssetGrid();
            renderCanvasLayers();
            updateBadgeInfo();
        }

        // Inisialisasi awal
        renderAssetGrid();
        renderCanvasLayers();
        updateBadgeInfo();
    </script>
</body>
</html>