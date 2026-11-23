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
        /* Styling native color wheel agar berbentuk lingkaran rapi */
        input[type="color"].color-wheel-input {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-color: transparent;
            border: none;
            cursor: pointer;
        }
        input[type="color"].color-wheel-input::-webkit-color-swatch-wrapper {
            padding: 0;
        }
        input[type="color"].color-wheel-input::-webkit-color-swatch {
            border-radius: 9999px;
            border: 3px solid #FFF8F0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.35);
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

        <!-- ============================================================== -->
        <!-- KOLOM KIRI: Preview Canvas, Input Nama OC, & 4 Tombol Utama     -->
        <!-- ============================================================== -->
        <section class="w-full lg:w-[36%] h-full flex flex-col justify-between gap-4 shrink-0">
            <div class="relative flex-1 w-full bg-white rounded-[2rem] border-[3px] border-space-indigo p-3 shadow-lg flex items-center justify-center overflow-hidden">
                <div id="previewBg" style="background-color: #9DD9D2;" class="relative w-full h-full rounded-[1.4rem] overflow-hidden flex items-end justify-center transition-colors duration-300">
                    
                    <div class="absolute -top-6 -left-6 w-36 h-36 rounded-full bg-white/25 pointer-events-none"></div>

                    <!-- LAYER Z-INDEX RENDAH (Rambut Belakang) -->
                    <div id="canvas-back-layers" class="absolute inset-0 z-[5] pointer-events-none"></div>

                    <!-- LAYER TUBUH DASAR (Base Color & Lineart) -->
                    <img src="{{ $baseAssets['color'] }}" alt="Base Color" id="layer-skin-color" class="canvas-layer z-10">
                    <img src="{{ $baseAssets['lineart'] }}" alt="Base Lineart" id="layer-skin-lineart" class="canvas-layer z-20">

                    <!-- LAYER Z-INDEX TINGGI (Baju, Mata, Mulut, Poni, Aksesori) -->
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

        <!-- ============================================================== -->
        <!-- KOLOM KANAN: Panel Kustomisasi + Color Wheel & Hex Copy         -->
        <!-- ============================================================== -->
        <section class="w-full lg:w-[64%] h-full bg-space-indigo rounded-[2rem] p-6 flex flex-col gap-4 shadow-2xl overflow-hidden">
            
            <!-- Baris 1: Pill Tabs Kategori -->
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

            <!-- Baris 2: Kontrol Warna Dinamis (Sub-Layer Tabs + Color Wheel + Hex Copy) -->
            <div class="flex flex-wrap items-center justify-between gap-3 bg-white/10 border border-white/10 px-4 py-3 rounded-2xl shrink-0">
                
                <!-- Kiri: Pilihan Target Layer (Lineart, Colour 1, Colour 2, dst.) -->
                <div class="flex flex-wrap items-center gap-2" id="subLayerTabsContainer">
                    <!-- Di-render dinamis sesuai jumlah colour pada item yang aktif -->
                </div>

                <!-- Kanan: Color Wheel + Hex Code + Tombol Copy -->
                <div class="flex items-center gap-2.5 ml-auto">
                    <label for="colorWheelInput" class="flex items-center gap-2 cursor-pointer group" title="Pilih Warna dari Color Wheel">
                        <span class="text-[11px] font-bold text-floral-white/80 group-hover:text-white">Color Wheel</span>
                        <input type="color" 
                               id="colorWheelInput" 
                               value="#9DD9D2"
                               oninput="handleColorWheelChange(this.value)"
                               class="color-wheel-input w-9 h-9 rounded-full shrink-0 transition-transform group-hover:scale-110">
                    </label>

                    <!-- Box Kode Hex + Copy Button -->
                    <div class="flex items-center bg-space-indigo/90 border border-white/20 rounded-xl overflow-hidden shadow-inner">
                        <input type="text" 
                               id="hexCodeInput" 
                               value="#9DD9D2" 
                               maxlength="7"
                               onchange="handleHexTextInput(this.value)"
                               class="w-20 px-2.5 py-1.5 bg-transparent text-xs font-mono font-black text-jasmine uppercase focus:outline-none text-center">
                        
                        <button type="button" 
                                onclick="copyCurrentHex()" 
                                id="copyHexBtn"
                                title="Salin Kode Hex"
                                class="px-2.5 py-1.5 bg-white/10 hover:bg-princeton-orange text-white text-xs transition flex items-center gap-1">
                            <i class="fa-regular fa-copy" id="copyHexIcon"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Baris 3: Grid Pilihan Item -->
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
        const baseSkinColorUrl = "{{ $baseAssets['color'] }}";
        const baseSkinLineartUrl = "{{ $baseAssets['lineart'] }}";

        // Cache hasil gambar PNG yang sudah diwarnai (DataURL) agar ringan saat ganti-ganti warna
        const tintedImageCache = {};

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
            activeSubLayer: 'color1', // 'lineart' | 'color1' | 'extra_0' | 'extra_1' ...
            selections: {}
        };

        // Inisialisasi state warna per kategori (lineart, color1, extras)
        categoriesData.forEach(cat => {
            ocState.selections[cat.id] = {
                asset: null,
                colors: {
                    lineart: '#26232D',
                    color1: cat.id === 'background' ? '#9DD9D2' : (cat.id === 'skin' ? '#E5C69E' : '#FF8811'),
                    extras: [] // Array warna dinamis untuk extra_colors[0], [1], dst.
                }
            };
        });

        function getActiveCategoryObj() {
            return categoriesData.find(c => c.id === ocState.activeCategory);
        }

    // =========================================================================
        // ENGINE PEWARNAAN AKURAT 100% (Source-In Fill + Preserve Alpha)
        // =========================================================================
        function getTintedDataUrl(imgUrl, hexColor) {
            return new Promise((resolve) => {
                if (!hexColor) return resolve(imgUrl);

                const cacheKey = `${imgUrl}__${hexColor.toUpperCase()}`;
                if (tintedImageCache[cacheKey]) {
                    return resolve(tintedImageCache[cacheKey]);
                }

                const img = new Image();
                img.crossOrigin = 'Anonymous';
                img.onload = function () {
                    const canvas = document.createElement('canvas');
                    canvas.width = img.width;
                    canvas.height = img.height;
                    const ctx = canvas.getContext('2d');

                    // 1. Gambar bentuk/siluet PNG asli beserta transparansi & anti-aliasing-nya
                    ctx.drawImage(img, 0, 0);

                    // 2. Ganti seluruh piksel berisi dengan warna hex exact 100% (tanpa menggelapkan)
                    ctx.globalCompositeOperation = 'source-in';
                    ctx.fillStyle = hexColor;
                    ctx.fillRect(0, 0, canvas.width, canvas.height);

                    const resultUrl = canvas.toDataURL('image/png');
                    tintedImageCache[cacheKey] = resultUrl;
                    resolve(resultUrl);
                };
                img.onerror = function () {
                    resolve(imgUrl);
                };
                img.src = imgUrl;
            });
        }
        // =========================================================================
        // NAVIGASI KATEGORI & SUB-LAYER WARNA
        // =========================================================================
        function selectCategory(catId) {
            ocState.activeCategory = catId;
            ocState.activeSubLayer = 'color1'; // Default fokus ke Colour 1 saat pindah kategori

            document.querySelectorAll('.category-pill').forEach(btn => {
                if (btn.dataset.catId === catId) {
                    btn.className = 'category-pill px-4 py-2 rounded-full text-xs font-extrabold tracking-wide transition-all duration-200 bg-princeton-orange text-white shadow-md shadow-princeton-orange/30';
                } else {
                    btn.className = 'category-pill px-4 py-2 rounded-full text-xs font-extrabold tracking-wide transition-all duration-200 bg-white/10 text-floral-white/80 hover:bg-white/20 hover:text-white border border-white/10';
                }
            });

            renderSubLayerControls();
            renderAssetGrid();
            updateBadgeInfo();
        }

        function selectSubLayer(layerKey) {
            ocState.activeSubLayer = layerKey;
            renderSubLayerControls();
        }

        // Render tombol sub-layer sesuai jumlah colour pada item yang dipilih
        function renderSubLayerControls() {
            const container = document.getElementById('subLayerTabsContainer');
            const catId = ocState.activeCategory;
            const sel = ocState.selections[catId];
            if (!sel) return;

            let tabs = [];

            if (catId === 'background') {
                tabs = [{ key: 'color1', label: 'Warna Background' }];
            } else if (catId === 'skin') {
                tabs = [
                    { key: 'color1', label: 'Warna Kulit' },
                    { key: 'lineart', label: 'Lineart' }
                ];
            } else {
                // Untuk item aset: selalu ada Lineart & Colour 1, ditambah Colour 2, 3, dst. sesuai jumlah extra_colors
                tabs = [
                    { key: 'lineart', label: 'Lineart' },
                    { key: 'color1', label: 'Colour 1' }
                ];

                const extraCount = (sel.asset && sel.asset.extra_colors) ? sel.asset.extra_colors.length : 0;
                for (let i = 0; i < extraCount; i++) {
                    // Pastikan array warna extra terisi default jika belum ada
                    if (!sel.colors.extras[i]) {
                        sel.colors.extras[i] = '#F4D06F';
                    }
                    tabs.push({
                        key: `extra_${i}`,
                        label: `Colour ${i + 2}`
                    });
                }
            }

            // Pastikan activeSubLayer valid untuk tab yang tersedia
            if (!tabs.some(t => t.key === ocState.activeSubLayer)) {
                ocState.activeSubLayer = tabs[0].key;
            }

            // Render tombol sub-layer beserta bulatan indikator warnanya
            container.innerHTML = tabs.map(tab => {
                const isActive = ocState.activeSubLayer === tab.key;
                const dotColor = getLayerHexColor(catId, tab.key);

                return `
                    <button type="button" 
                            onclick="selectSubLayer('${tab.key}')"
                            class="flex items-center gap-2 px-3 py-1.5 rounded-xl text-xs font-extrabold transition-all ${isActive ? 'bg-jasmine text-space-indigo shadow' : 'bg-white/10 text-floral-white/80 hover:bg-white/20'}">
                        <span class="w-3.5 h-3.5 rounded-full border border-black/30 shrink-0" style="background-color: ${dotColor};"></span>
                        <span>${tab.label}</span>
                    </button>
                `;
            }).join('');

            // Sinkronkan nilai Color Wheel & Input Hex dengan warna layer aktif
            const activeHex = getLayerHexColor(catId, ocState.activeSubLayer);
            document.getElementById('colorWheelInput').value = activeHex;
            document.getElementById('hexCodeInput').value = activeHex.toUpperCase();
        }

        function getLayerHexColor(catId, layerKey) {
            const colors = ocState.selections[catId].colors;
            if (layerKey === 'lineart') return colors.lineart;
            if (layerKey === 'color1') return colors.color1;
            if (layerKey.startsWith('extra_')) {
                const idx = parseInt(layerKey.split('_')[1], 10);
                return colors.extras[idx] || '#F4D06F';
            }
            return '#FFFFFF';
        }

        function setLayerHexColor(catId, layerKey, hex) {
            const colors = ocState.selections[catId].colors;
            if (layerKey === 'lineart') colors.lineart = hex;
            else if (layerKey === 'color1') colors.color1 = hex;
            else if (layerKey.startsWith('extra_')) {
                const idx = parseInt(layerKey.split('_')[1], 10);
                colors.extras[idx] = hex;
            }
        }

        // =========================================================================
        // HANDLER COLOR WHEEL, INPUT HEX MANUAL, & COPY HEX
        // =========================================================================
        function handleColorWheelChange(hexValue) {
            const formattedHex = hexValue.toUpperCase();
            document.getElementById('hexCodeInput').value = formattedHex;

            setLayerHexColor(ocState.activeCategory, ocState.activeSubLayer, formattedHex);
            renderSubLayerControls();
            renderCanvasLayers();
        }

        function handleHexTextInput(rawValue) {
            let clean = rawValue.trim();
            if (!clean.startsWith('#')) clean = '#' + clean;

            if (/^#[0-9A-Fa-f]{6}$/.test(clean)) {
                const upper = clean.toUpperCase();
                document.getElementById('colorWheelInput').value = upper;
                document.getElementById('hexCodeInput').value = upper;
                setLayerHexColor(ocState.activeCategory, ocState.activeSubLayer, upper);
                renderSubLayerControls();
                renderCanvasLayers();
            } else {
                // Kembalikan ke warna valid sebelumnya jika format hex salah
                const validHex = getLayerHexColor(ocState.activeCategory, ocState.activeSubLayer);
                document.getElementById('hexCodeInput').value = validHex.toUpperCase();
            }
        }

        function copyCurrentHex() {
            const hexText = document.getElementById('hexCodeInput').value;
            navigator.clipboard.writeText(hexText).then(() => {
                const btn = document.getElementById('copyHexBtn');
                const icon = document.getElementById('copyHexIcon');
                btn.classList.add('bg-emerald-500');
                icon.className = 'fa-solid fa-check';

                setTimeout(() => {
                    btn.classList.remove('bg-emerald-500');
                    icon.className = 'fa-regular fa-copy';
                }, 1200);
            });
        }

        // =========================================================================
        // PEMILIHAN ITEM ASET & RENDER KANVAS
        // =========================================================================
        function selectAssetItem(assetObj) {
            const cat = ocState.activeCategory;
            ocState.selections[cat].asset = assetObj;

            // Siapkan slot warna default untuk extra_colors jika item baru punya > 1 warna
            if (assetObj && assetObj.extra_colors) {
                assetObj.extra_colors.forEach((_, idx) => {
                    if (!ocState.selections[cat].colors.extras[idx]) {
                        ocState.selections[cat].colors.extras[idx] = '#F4D06F';
                    }
                });
            }

            renderSubLayerControls();
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

            // Slot 1: Kosong / Lepas
            const isNoneSelected = currentSel.asset === null;
            html += `
                <button type="button" onclick='selectAssetItem(null)'
                        class="aspect-square rounded-2xl bg-white border-2 ${isNoneSelected ? 'border-princeton-orange ring-2 ring-princeton-orange/30' : 'border-space-indigo/10 hover:border-space-indigo/30'} flex flex-col items-center justify-center gap-1.5 transition-all shadow-sm group">
                    <i class="fa-solid fa-ban text-2xl ${isNoneSelected ? 'text-princeton-orange' : 'text-space-indigo/30 group-hover:text-space-indigo/60'}"></i>
                    <span class="text-[10px] font-bold text-space-indigo/40">Kosong</span>
                </button>
            `;

            // Render item asli dari database
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

        async function renderCanvasLayers() {
            // 1. Update warna Background
            const bgSel = ocState.selections['background'];
            document.getElementById('previewBg').style.backgroundColor = bgSel ? bgSel.colors.color1 : '#9DD9D2';

            // 2. Update warna Kulit Dasar (Skin)
            const skinSel = ocState.selections['skin'];
            if (skinSel) {
                const tintedSkinColor = await getTintedDataUrl(baseSkinColorUrl, skinSel.colors.color1);
                const tintedSkinLineart = await getTintedDataUrl(baseSkinLineartUrl, skinSel.colors.lineart);
                document.getElementById('layer-skin-color').src = tintedSkinColor;
                document.getElementById('layer-skin-lineart').src = tintedSkinLineart;
            }

            const backContainer = document.getElementById('canvas-back-layers');
            const frontContainer = document.getElementById('canvas-front-layers');
            let backHtml = '';
            let frontHtml = '';

            // 3. Render & warnai setiap layer item aktif
            for (const catSlug of Object.keys(ocState.selections)) {
                if (catSlug === 'background' || catSlug === 'skin') continue;

                const sel = ocState.selections[catSlug];
                const item = sel.asset;
                if (!item) continue;

                const zBase = zOrderMap[catSlug] || 25;
                let layerGroup = '';

                // Extra Colors (Colour 2, Colour 3, dst.)
                if (item.extra_colors && item.extra_colors.length > 0) {
                    for (let idx = 0; idx < item.extra_colors.length; idx++) {
                        const rawUrl = item.extra_colors[idx];
                        const hex = sel.colors.extras[idx] || '#F4D06F';
                        const tintedUrl = await getTintedDataUrl(rawUrl, hex);
                        layerGroup += `<img src="${tintedUrl}" class="canvas-layer" style="z-index: ${zBase};">`;
                    }
                }

                // Colour 1 (Base Color item)
                const tintedColor1 = await getTintedDataUrl(item.color1_url, sel.colors.color1);
                layerGroup += `<img src="${tintedColor1}" class="canvas-layer" style="z-index: ${zBase};">`;

                // Lineart item
                const tintedLineart = await getTintedDataUrl(item.lineart_url, sel.colors.lineart);
                layerGroup += `<img src="${tintedLineart}" class="canvas-layer" style="z-index: ${zBase + 1};">`;

                if (catSlug === 'back_hair') {
                    backHtml += layerGroup;
                } else {
                    frontHtml += layerGroup;
                }
            }

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

        function getRandomHex() {
            return '#' + Math.floor(Math.random() * 16777215).toString(16).padStart(6, '0').toUpperCase();
        }

        function randomizeOc() {
            categoriesData.forEach(cat => {
                const sel = ocState.selections[cat.id];
                sel.colors.color1 = getRandomHex();
                sel.colors.lineart = '#26232D';

                if (cat.assets && cat.assets.length > 0) {
                    const randomAsset = cat.assets[Math.floor(Math.random() * cat.assets.length)];
                    sel.asset = randomAsset;
                    if (randomAsset.extra_colors) {
                        sel.colors.extras = randomAsset.extra_colors.map(() => getRandomHex());
                    }
                }
            });

            renderSubLayerControls();
            renderAssetGrid();
            renderCanvasLayers();
            document.getElementById('activeBadgeInfo').innerText = 'Randomized!';
        }

        function resetCanvas() {
            document.getElementById('ocNameInput').value = '';
            categoriesData.forEach(cat => {
                ocState.selections[cat.id] = {
                    asset: null,
                    colors: {
                        lineart: '#26232D',
                        color1: cat.id === 'background' ? '#9DD9D2' : (cat.id === 'skin' ? '#E5C69E' : '#FF8811'),
                        extras: []
                    }
                };
            });
            renderSubLayerControls();
            renderAssetGrid();
            renderCanvasLayers();
            updateBadgeInfo();
        }

        // Inisialisasi awal
        renderSubLayerControls();
        renderAssetGrid();
        renderCanvasLayers();
        updateBadgeInfo();
    </script>
</body>
</html>