<?php

namespace App\Http\Controllers;

use App\Models\AssetCategory;
use Illuminate\Http\Request;

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
        $ocs = [];
        return view('dashboard.profile', compact('ocs'));
    }

    public function explore(Request $request)
    {
        $search = $request->input('search');
        $dummyOcs = collect([
            [
                'id' => 1,
                'name' => 'Kaelen Vane',
                'creator' => 'shadow_ninja',
                'age' => '17 tahun',
                'role' => 'Stealth Rogue',
                'bio' => 'Mantan mata-mata distrik timur yang bergerak di kegelapan malam.',
                'thumbnail' => asset('Assets/Character/Base/base color.png')
            ],
        ]);

        $filteredOcs = !empty($search)
            ? $dummyOcs->filter(fn($i) => str_contains(strtolower($i['creator']), strtolower($search)) || str_contains(strtolower($i['name']), strtolower($search)))
            : $dummyOcs;

        return view('dashboard.explore', ['ocs' => $filteredOcs, 'search' => $search]);
    }

    public function creator()
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

        return view('dashboard.creator', compact('categories', 'colors', 'baseAssets'));
    }

    public function saveOc(Request $request)
    {
        return back()->with('success', 'Konfigurasi OC berhasil disimpan (Simulasi)!');
    }

    public function logout(Request $request)
    {
        return redirect()->route('dashboard');
    }
}