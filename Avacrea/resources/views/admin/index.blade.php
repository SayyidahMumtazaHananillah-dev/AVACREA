
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light only">
    <title>AVACREA - Admin Asset Studio</title>
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

<body style="background-color: #FFF8F0 !important; color-scheme: light;" class="text-space-indigo min-h-screen flex flex-col font-sans">

    <!-- Top Navbar Admin -->
    <header class="h-16 px-8 flex items-center justify-between border-b border-[#36210E]/20 bg-[#36210E] text-[#F0ECE1] sticky top-0 z-30 shadow-md">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-2xl bg-princeton-orange flex items-center justify-center shadow">
                <i class="fa-solid fa-shield-halved text-white text-lg"></i>
            </div>
            <div>
                <h1 class="text-xl font-black tracking-wider">AVACREA <span class="text-xs bg-jasmine text-space-indigo px-2 py-0.5 rounded-full ml-1">ADMIN</span></h1>
                <p class="text-[10px] text-pearl-aqua font-bold tracking-widest uppercase">Asset Layer Management</p>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <a href="{{ route('dashboard') }}" class="text-xs font-bold text-pearl-aqua hover:underline">
                Lihat Web User &rarr;
            </a>
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="flex items-center gap-2 px-4 py-2 bg-rose-500/20 hover:bg-rose-500/30 border border-rose-500/40 text-rose-200 font-bold text-xs rounded-xl transition">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </header>

    <!-- Main Container -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-6 md:px-10 py-8">

        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-100 border-2 border-emerald-400 text-emerald-900 font-bold text-sm flex items-center gap-3 shadow-sm">
                <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 rounded-2xl bg-rose-100 border-2 border-rose-400 text-rose-900 text-xs font-bold">
                <p class="mb-1 text-sm"><i class="fa-solid fa-triangle-exclamation mr-1"></i> Gagal menyimpan item:</p>
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Header Action Bar -->
        <div class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4 mb-8">
            <form action="{{ route('admin.dashboard') }}" method="GET" class="flex-1 flex flex-col sm:flex-row gap-3">
                <div class="relative flex-1">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-space-indigo/40"></i>
                    <input type="text"
                           name="search"
                           value="{{ $search ?? '' }}"
                           placeholder="Cari kode item (misal: 1_hair)..."
                           class="w-full pl-11 pr-4 py-3 rounded-2xl bg-white border-2 border-space-indigo/15 focus:border-princeton-orange focus:outline-none text-sm font-semibold">
                </div>

                <select name="category" onchange="this.form.submit()" class="px-4 py-3 rounded-2xl bg-white border-2 border-space-indigo/15 focus:border-princeton-orange focus:outline-none text-sm font-bold text-space-indigo">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ ($categoryFilter ?? '') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }} ({{ $cat->slug }})
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="px-6 py-3 bg-space-indigo hover:bg-space-indigo/90 text-white font-bold text-sm rounded-2xl transition">
                    Cari
                </button>
            </form>

            <button onclick="openAddModal()" class="px-6 py-3.5 bg-princeton-orange hover:bg-orange-600 text-white font-black text-sm rounded-2xl shadow-lg shadow-princeton-orange/30 flex items-center justify-center gap-2.5 transition active:scale-95 border-b-4 border-amber-800">
                <i class="fa-solid fa-plus text-base"></i>
                <span>Tambah Item Aset</span>
            </button>
        </div>

        <!-- Tabel Daftar Aset -->
        <div class="bg-white rounded-3xl border-2 border-space-indigo/10 shadow-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-space-indigo text-floral-white text-xs uppercase tracking-wider">
                            <th class="py-4 px-6">Preview Gabungan</th>
                            <th class="py-4 px-6">Nama Otomatis</th>
                            <th class="py-4 px-6">Kategori</th>
                            <th class="py-4 px-6">Kelengkapan Layer</th>
                            <th class="py-4 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-space-indigo/10 text-sm">
                        @forelse($assets as $asset)
                            <tr class="hover:bg-floral-white/80 transition">

                                <!-- Preview Layer -->
                                <td class="py-3 px-6">
                                    <div class="relative w-20 h-20 rounded-2xl bg-pearl-aqua/20 border border-space-indigo/15 flex items-center justify-center overflow-hidden">
                                        @if($asset->color1_path)
                                            <img src="{{ asset($asset->color1_path) }}" class="absolute inset-0 w-full h-full object-contain z-10">
                                        @endif

                                        @if(!empty($asset->extra_colors))
                                            @foreach($asset->extra_colors as $idx => $extraPath)
                                                <img src="{{ asset($extraPath) }}" class="absolute inset-0 w-full h-full object-contain" style="z-index: {{ 15 + $idx }};">
                                            @endforeach
                                        @endif

                                        @if($asset->shading_path)
                                            <img src="{{ asset($asset->shading_path) }}" class="absolute inset-0 w-full h-full object-contain z-25">
                                        @endif

                                        @if($asset->lineart_path)
                                            <img src="{{ asset($asset->lineart_path) }}" class="absolute inset-0 w-full h-full object-contain z-30">
                                        @endif
                                    </div>
                                </td>

                                <!-- Nama -->
                                <td class="py-4 px-6">
                                    <span class="px-3 py-1.5 rounded-xl bg-jasmine/40 text-space-indigo font-mono font-black text-sm">
                                        {{ $asset->name }}
                                    </span>
                                </td>

                                <!-- Kategori -->
                                <td class="py-4 px-6 font-bold text-space-indigo/80">
                                    {{ $asset->category->name ?? '-' }}
                                </td>

                                <!-- Kelengkapan Layer -->
                                <td class="py-4 px-6">
                                    @php
                                        $extraCount = count($asset->extra_colors ?? []);
                                        $totalColors = 1 + $extraCount;
                                    @endphp

                                    <div class="flex flex-wrap gap-1.5 text-[11px] font-bold">
                                        <span class="px-2.5 py-1 rounded-lg bg-emerald-100 text-emerald-800">
                                            <i class="fa-solid fa-pen-nib mr-1"></i>1 Lineart
                                        </span>

                                        <span class="px-2.5 py-1 rounded-lg bg-sky-100 text-sky-800">
                                            <i class="fa-solid fa-palette mr-1"></i>{{ $totalColors }} Colour
                                        </span>

                                        @if($asset->shading_path)
                                            <span class="px-2.5 py-1 rounded-lg bg-purple-100 text-purple-800">
                                                <i class="fa-solid fa-circle-half-stroke mr-1"></i>1 Shading
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                <!-- Aksi -->
                                <td class="py-4 px-6 text-right">
                                    <div class="flex items-center justify-end gap-2">

                                        <button
                                            type="button"
                                            onclick='openEditModal(@json($asset))'
                                            class="px-3.5 py-2 rounded-xl bg-jasmine hover:bg-amber-300 text-space-indigo font-bold text-xs transition flex items-center gap-1.5">
                                            <i class="fa-solid fa-pen"></i> Edit
                                        </button>

                                        <form action="{{ route('admin.assets.destroy', $asset->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin mau hapus item {{ $asset->name }}?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="px-3.5 py-2 rounded-xl bg-rose-100 hover:bg-rose-200 text-rose-700 font-bold text-xs transition flex items-center gap-1.5">
                                                <i class="fa-solid fa-trash"></i> Hapus
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="5" class="py-16 text-center text-space-indigo/50">
                                    <i class="fa-solid fa-box-open text-4xl mb-3 block"></i>
                                    <p class="font-bold text-base text-space-indigo">Belum ada aset yang diupload</p>
                                    <p class="text-xs mt-1">Klik tombol <b>Tambah Item Aset</b> di kanan atas untuk mulai mengunggah.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- MODAL 1: TAMBAH ITEM -->
    <div id="addModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-space-indigo/70 backdrop-blur-sm">
        <div class="w-full max-w-lg max-h-[90vh] flex flex-col bg-[#FFF8F0] rounded-3xl border-2 border-space-indigo/20 shadow-2xl overflow-hidden">

            <div class="px-6 py-4 bg-space-indigo text-white flex items-center justify-between shrink-0">
                <h3 class="font-black text-base tracking-wide">
                    <i class="fa-solid fa-cloud-arrow-up text-princeton-orange mr-2"></i>
                    Tambah Item Aset Baru
                </h3>
                <button type="button" onclick="closeAddModal()" class="text-white/70 hover:text-white">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form action="{{ route('admin.assets.store') }}" method="POST" enctype="multipart/form-data" class="p-6 flex flex-col gap-4 overflow-y-auto">
                @csrf

                <!-- Pilih Kategori -->
                <div>
                    <label class="block text-xs font-extrabold uppercase tracking-wider text-space-indigo mb-1.5">
                        Kategori Aset *
                    </label>

                    <select name="category_id" required class="w-full px-4 py-3 rounded-2xl bg-white border-2 border-space-indigo/15 focus:border-princeton-orange focus:outline-none text-sm font-bold">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">
                                {{ $cat->name }} &rarr; (Auto: X_{{ $cat->slug }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Lineart -->
                <div class="p-3.5 rounded-2xl bg-white border-2 border-space-indigo/15">
                    <label class="flex items-center justify-between text-xs font-black text-space-indigo mb-1.5">
                        <span class="flex items-center gap-1.5">
                            <i class="fa-solid fa-pen-nib text-space-indigo"></i>
                            1. File Lineart (PNG Transparan)
                        </span>
                        <span class="px-2 py-0.5 rounded bg-rose-100 text-rose-700 text-[10px] font-extrabold">WAJIB</span>
                    </label>

                    <input type="file" name="lineart" accept="image/png" required class="w-full text-xs text-space-indigo file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-space-indigo file:text-white hover:file:bg-space-indigo/90">
                </div>

                <!-- Colour Utama dan Tambahan -->
                <div class="p-3.5 rounded-2xl bg-white border-2 border-space-indigo/15 flex flex-col gap-3">
                    <div>
                        <label class="flex items-center justify-between text-xs font-black text-space-indigo mb-1.5">
                            <span class="flex items-center gap-1.5">
                                <i class="fa-solid fa-palette text-princeton-orange"></i>
                                2. File Colour Utama / Color 1 (PNG)
                            </span>
                            <span class="px-2 py-0.5 rounded bg-rose-100 text-rose-700 text-[10px] font-extrabold">WAJIB</span>
                        </label>

                        <input type="file" name="color_1" accept="image/png" required class="w-full text-xs text-space-indigo file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-princeton-orange file:text-white hover:file:bg-orange-600">
                    </div>

                    <div id="addExtraColorsContainer" class="flex flex-col gap-2.5"></div>

                    <button type="button" onclick="addColorSlot('addExtraColorsContainer')" class="w-full py-2 px-3 rounded-xl border-2 border-dashed border-space-indigo/25 hover:border-princeton-orange hover:bg-floral-white text-space-indigo font-extrabold text-[11px] flex items-center justify-center gap-1.5 transition">
                        <i class="fa-solid fa-plus-circle text-princeton-orange"></i>
                        <span>Tambah Layer Colour (Color 2, 3, dst.)</span>
                    </button>
                </div>

                <!-- Shading -->
                <div class="p-3.5 rounded-2xl bg-white border-2 border-space-indigo/15">
                    <label class="flex items-center justify-between text-xs font-black text-space-indigo mb-1.5">
                        <span class="flex items-center gap-1.5">
                            <i class="fa-solid fa-circle-half-stroke text-purple-600"></i>
                            3. File Shading / Bayangan (PNG Transparan)
                        </span>
                        <span class="px-2 py-0.5 rounded bg-purple-100 text-purple-800 text-[10px] font-extrabold">OPSIONAL</span>
                    </label>

                    <input type="file" name="shading" accept="image/png" class="w-full text-xs text-space-indigo file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-purple-700 file:text-white hover:file:bg-purple-800">
                </div>

                <div class="flex items-center justify-end gap-3 pt-2 shrink-0">
                    <button type="button" onclick="closeAddModal()" class="px-5 py-2.5 rounded-xl bg-zinc-200 hover:bg-zinc-300 text-space-indigo font-bold text-xs">
                        Batal
                    </button>

                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-princeton-orange hover:bg-orange-600 text-white font-black text-xs shadow-lg shadow-princeton-orange/30">
                        Simpan Aset
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 2: EDIT ITEM ASET -->
    <div id="editModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-space-indigo/70 backdrop-blur-sm">
        <div class="w-full max-w-lg max-h-[90vh] flex flex-col bg-[#FFF8F0] rounded-3xl border-2 border-space-indigo/20 shadow-2xl overflow-hidden">

            <div class="px-6 py-4 bg-space-indigo text-white flex items-center justify-between shrink-0">
                <h3 class="font-black text-base tracking-wide">
                    <i class="fa-solid fa-pen-to-square text-jasmine mr-2"></i>
                    Edit Item Aset
                </h3>

                <button type="button" onclick="closeEditModal()" class="text-white/70 hover:text-white">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form id="editForm" method="POST" enctype="multipart/form-data" class="p-6 flex flex-col gap-4 overflow-y-auto">
                @csrf
                @method('PUT')

                <!-- Nama Item -->
                <div>
                    <label class="block text-xs font-extrabold uppercase tracking-wider text-space-indigo mb-1.5">
                        Kode / Nama Item
                    </label>

                    <input type="text" name="name" id="editNameInput" required class="w-full px-4 py-3 rounded-2xl bg-white border-2 border-space-indigo/15 focus:border-princeton-orange focus:outline-none text-sm font-mono font-bold">
                </div>

                <!-- KATEGORI BARU: BISA DIUBAH -->
                <div>
                    <label class="block text-xs font-extrabold uppercase tracking-wider text-space-indigo mb-1.5">
                        Kategori Aset *
                    </label>

                    <select name="category_id" id="editCategoryInput" required class="w-full px-4 py-3 rounded-2xl bg-white border-2 border-space-indigo/15 focus:border-princeton-orange focus:outline-none text-sm font-bold">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">
                                {{ $cat->name }} ({{ $cat->slug }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <p class="text-[11px] font-bold text-princeton-orange">
                    *Biarkan file kosong jika tidak ingin mengganti layer lama.
                </p>

                <!-- Ganti Lineart -->
                <div class="p-3.5 rounded-2xl bg-white border-2 border-space-indigo/15">
                    <label class="flex items-center justify-between text-xs font-black text-space-indigo mb-1.5">
                        <span class="flex items-center gap-1.5">
                            <i class="fa-solid fa-pen-nib text-space-indigo"></i>
                            1. Ganti Lineart (PNG)
                        </span>
                    </label>

                    <input type="file" name="lineart" accept="image/png" class="w-full text-xs text-space-indigo file:mr-3 file:py-1.5 file:px-3.5 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-space-indigo file:text-white">
                </div>

                <!-- Ganti Colour -->
                <div class="p-3.5 rounded-2xl bg-white border-2 border-space-indigo/15 flex flex-col gap-3">
                    <div>
                        <label class="flex items-center justify-between text-xs font-black text-space-indigo mb-1.5">
                            <span class="flex items-center gap-1.5">
                                <i class="fa-solid fa-palette text-princeton-orange"></i>
                                2. Ganti Colour Utama / Color 1 (PNG)
                            </span>
                        </label>

                        <input type="file" name="color_1" accept="image/png" class="w-full text-xs text-space-indigo file:mr-3 file:py-1.5 file:px-3.5 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-princeton-orange file:text-white">
                    </div>

                    <div id="editExtraColorsContainer" class="flex flex-col gap-2.5"></div>

                    <button type="button" onclick="addColorSlot('editExtraColorsContainer')" class="w-full py-2 px-3 rounded-xl border-2 border-dashed border-space-indigo/25 hover:border-princeton-orange hover:bg-floral-white text-space-indigo font-extrabold text-[11px] flex items-center justify-center gap-1.5 transition">
                        <i class="fa-solid fa-plus-circle text-princeton-orange"></i>
                        <span>Tambah Layer Colour Baru</span>
                    </button>
                </div>

                <!-- Ganti Shading -->
                <div class="p-3.5 rounded-2xl bg-white border-2 border-space-indigo/15">
                    <label class="flex items-center justify-between text-xs font-black text-space-indigo mb-1.5">
                        <span class="flex items-center gap-1.5">
                            <i class="fa-solid fa-circle-half-stroke text-purple-600"></i>
                            3. Ganti / Tambah Shading (PNG)
                        </span>

                        <span class="px-2 py-0.5 rounded bg-purple-100 text-purple-800 text-[10px] font-extrabold">
                            OPSIONAL
                        </span>
                    </label>

                    <input type="file" name="shading" accept="image/png" class="w-full text-xs text-space-indigo file:mr-3 file:py-1.5 file:px-3.5 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-purple-700 file:text-white">
                </div>

                <div class="flex items-center justify-end gap-3 pt-2 shrink-0">
                    <button type="button" onclick="closeEditModal()" class="px-5 py-2.5 rounded-xl bg-zinc-200 hover:bg-zinc-300 text-space-indigo font-bold text-xs">
                        Batal
                    </button>

                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-jasmine hover:bg-amber-300 text-space-indigo font-black text-xs shadow-md">
                        Update Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script>
        function addColorSlot(containerId) {
            const container = document.getElementById(containerId);
            const currentCount = container.children.length;
            const colorNumber = currentCount + 2;

            const slot = document.createElement('div');
            slot.className = 'p-3 rounded-xl bg-floral-white border border-pearl-aqua flex flex-col gap-1.5';

            slot.innerHTML = `
                <div class="flex items-center justify-between text-xs font-black text-space-indigo">
                    <span>Layer Colour Tambahan #${colorNumber} (PNG)</span>
                    <button type="button" onclick="this.closest('.p-3').remove()" class="text-rose-500 hover:text-rose-700 text-xs font-bold flex items-center gap-1">
                        <i class="fa-solid fa-trash-can"></i> Hapus
                    </button>
                </div>

                <input type="file" name="extra_colors[]" accept="image/png" required class="w-full text-xs text-space-indigo file:mr-3 file:py-1.5 file:px-3.5 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-pearl-aqua file:text-space-indigo hover:file:bg-[#8bcac3]">
            `;

            container.appendChild(slot);
        }

        // Modal Tambah
        function openAddModal() {
            document.getElementById('addExtraColorsContainer').innerHTML = '';
            document.getElementById('addModal').classList.remove('hidden');
        }

        function closeAddModal() {
            document.getElementById('addModal').classList.add('hidden');
        }

        // Modal Edit
        function openEditModal(asset) {
            document.getElementById('editExtraColorsContainer').innerHTML = '';

            // Isi nama aset
            document.getElementById('editNameInput').value = asset.name;

            // Isi kategori lama secara otomatis
            document.getElementById('editCategoryInput').value = asset.category_id;

            // Atur URL update
            document.getElementById('editForm').action = `/admin/assets/${asset.id}`;

            // Tampilkan modal
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        // Tutup modal jika klik area luar modal
        document.getElementById('addModal').addEventListener('click', function(event) {
            if (event.target === this) closeAddModal();
        });

        document.getElementById('editModal').addEventListener('click', function(event) {
            if (event.target === this) closeEditModal();
        });
    </script>
</body>
</html>
