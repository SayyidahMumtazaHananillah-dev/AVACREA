<?php

namespace App\Http\Controllers;

use App\Models\AssetCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Oc;

class DashboardController extends Controller
{
    public function index()
    {
        $baseAssets = [
            'color'   => asset('Assets/Character/Base/base color.png'),
            'lineart' => asset('Assets/Character/Base/base lineart.png'),
        ];

        return view('dashboard.index', compact('baseAssets'));
    }

    public function profile()
    {
        $user = Auth::user() ?? (object) [
            'name'     => 'Guest Creator',
            'username' => 'guest',
            'image'    => null,
        ];

        $ocs = Auth::check()
    ? \App\Models\Oc::where('user_id', Auth::id())->get()
    : collect();

        return view('dashboard.profile', compact('user', 'ocs'));
    }

    public function explore(Request $request)
    {
        $search = $request->input('search');

        $ocs = Oc::with('user')
            ->latest()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'ILIKE', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'ILIKE', "%{$search}%")
                            ->orWhere('username', 'ILIKE', "%{$search}%");
                    });
                });
            })
            ->get()
            ->map(function ($oc) {
                return [
                    'id' => $oc->id,
                    'name' => $oc->name,
                    'creator' => $oc->user->username ?? $oc->user->name ?? 'Unknown',
                    'bio' => $oc->description ?? 'Tidak ada deskripsi.',
                    'thumbnail' => $oc->thumbnail
                        ? asset('storage/' . $oc->thumbnail)
                        : asset('Assets/Character/Base/base color.png'),
                ];
            });

        return view('dashboard.explore', compact('ocs', 'search'));
    }

    public function creator(Request $request)
    {
        // Ambil kategori beserta aset asli yang sudah diupload admin dari database
        $dbCategories = AssetCategory::with('assets')->get();

        $categories = $dbCategories->map(function ($cat) {
            return [
                'id'         => $cat->slug,
                'name'       => $cat->name,
                'allow_none' => !in_array($cat->slug, ['background', 'skin']),
                'assets'     => $cat->assets->map(function ($asset) {
                    return [
                        'id'           => $asset->id,
                        'name'         => $asset->name,
                        'lineart_url'  => asset($asset->lineart_path),
                        'color1_url'   => asset($asset->color1_path),
                        'extra_colors' => collect($asset->extra_colors ?? [])->map(fn($p) => asset($p))->values(),
                    ];
                })->values(),
            ];
        })->values();

        // Palet warna
        $colors = [
            ['id' => 1,  'name' => 'Space Indigo',     'hex' => '#392F5A'],
            ['id' => 2,  'name' => 'Princeton Orange', 'hex' => '#FF8811'],
            ['id' => 3,  'name' => 'Jasmine',          'hex' => '#F4D06F'],
            ['id' => 4,  'name' => 'Pearl Aqua',       'hex' => '#9DD9D2'],
            ['id' => 5,  'name' => 'Floral White',     'hex' => '#FFF8F0'],
            ['id' => 6,  'name' => 'Charcoal',         'hex' => '#26232D'],
            ['id' => 7,  'name' => 'Chestnut',         'hex' => '#6E4730'],
            ['id' => 8,  'name' => 'Coral Rose',       'hex' => '#D1606A'],
            ['id' => 9,  'name' => 'Steel Blue',       'hex' => '#6889B5'],
            ['id' => 10, 'name' => 'Sage Green',       'hex' => '#78B077'],
            ['id' => 11, 'name' => 'Lavender',         'hex' => '#B29CE4'],
            ['id' => 12, 'name' => 'Warm Sand',        'hex' => '#E5C69E'],
        ];

        $baseAssets = [
            'color'   => asset('Assets/Character/Base/base color.png'),
            'lineart' => asset('Assets/Character/Base/base lineart.png'),
        ];

        $editOc = null;

        if ($request->filled('edit')) {
            $editOc = Oc::where('user_id', Auth::id())
                ->findOrFail($request->query('edit'));
        }

        return view('dashboard.creator', compact(
            'categories',
            'colors',
            'baseAssets',
            'editOc'
        ));
    }

    public function saveOc(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'oc_payload' => 'required|json',
            'oc_thumbnail' => 'required|string',
            'oc_id' => 'nullable|integer',
        ]);

        $thumbnail = $validated['oc_thumbnail'];

        if (!preg_match('/^data:image\/png;base64,/', $thumbnail)) {
            return back()->withErrors([
                'oc_thumbnail' => 'Format thumbnail tidak valid.'
            ]);
        }

        $imageData = base64_decode(
            substr($thumbnail, strpos($thumbnail, ',') + 1),
            true
        );

        if ($imageData === false || strlen($imageData) > 5 * 1024 * 1024) {
            return back()->withErrors([
                'oc_thumbnail' => 'Ukuran thumbnail tidak valid atau terlalu besar.'
            ]);
        }

        // Cari OC lama jika sedang mengedit
        $oc = null;

        if (!empty($validated['oc_id'])) {
            $oc = Oc::where('user_id', Auth::id())
                ->findOrFail($validated['oc_id']);
        }

        // Simpan thumbnail baru
        $filename = 'ocs/' . uniqid() . '.png';

        Storage::disk('public')->put($filename, $imageData);

        // Hapus thumbnail lama jika sedang mengedit
        if ($oc && $oc->thumbnail) {
            Storage::disk('public')->delete($oc->thumbnail);
        }

        $data = [
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'configuration' => json_decode($validated['oc_payload'], true),
            'thumbnail' => $filename,
        ];

        if ($oc) {
            // Update OC lama
            $oc->update($data);
            $message = 'OC berhasil diperbarui!';
        } else {
            // Buat OC baru
            $data['user_id'] = Auth::id();
            Oc::create($data);
            $message = 'OC berhasil disimpan!';
        }

        return redirect()->route('profile')->with('success', $message);
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        /** @var \App\Models\User $user */
        $user = \App\Models\User::findOrFail(Auth::id());

        $newImage = $request->file('image')->store('profile', 'public');

        if ($user->image) {
            Storage::disk('public')->delete($user->image);
        }

        $user->image = $newImage;
        $user->save();

        return redirect()->route('profile')
            ->with('success', 'Foto profil berhasil diperbarui!');
    }

    public function logout(Request $request)
    {
        return redirect()->route('dashboard');
    }
}