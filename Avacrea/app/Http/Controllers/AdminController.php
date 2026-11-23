<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categoryFilter = $request->input('category');

        $categories = AssetCategory::all();

        $assets = Asset::with('category')
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhereHas('category', fn($q) => $q->where('name', 'like', "%{$search}%"));
            })
            ->when($categoryFilter, function ($query, $categoryFilter) {
                $query->where('category_id', $categoryFilter);
            })
            ->latest()
            ->get();

        return view('admin.index', compact('assets', 'categories', 'search', 'categoryFilter'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id'    => 'required|exists:asset_categories,id',
            'lineart'        => 'required|image|mimes:png|max:5120',
            'color_1'        => 'required|image|mimes:png|max:5120',
            'extra_colors'   => 'nullable|array',
            'extra_colors.*' => 'image|mimes:png|max:5120',
            'shading'        => 'nullable|image|mimes:png|max:5120',
        ]);

        $category = AssetCategory::findOrFail($request->category_id);

        $countInCat = Asset::where('category_id', $category->id)->count();
        $nextNumber = $countInCat + 1;
        $autoName = "{$nextNumber}_{$category->slug}";

        $folderPath = "Assets/Character/{$category->slug}";
        $destination = public_path($folderPath);

        if (!File::exists($destination)) {
            File::makeDirectory($destination, 0755, true);
        }

        // 1. Lineart (Wajib)
        $lineartFile = "{$autoName}_lineart.png";
        $request->file('lineart')->move($destination, $lineartFile);
        $lineartPath = "{$folderPath}/{$lineartFile}";

        // 2. Color 1 (Wajib)
        $color1File = "{$autoName}_color1.png";
        $request->file('color_1')->move($destination, $color1File);
        $color1Path = "{$folderPath}/{$color1File}";

        // 3. Extra Colors (Dinamis)
        $extraColorPaths = [];
        if ($request->hasFile('extra_colors')) {
            foreach ($request->file('extra_colors') as $index => $file) {
                $colorNum = $index + 2;
                $extraFileName = "{$autoName}_color{$colorNum}.png";
                $file->move($destination, $extraFileName);
                $extraColorPaths[] = "{$folderPath}/{$extraFileName}";
            }
        }

        // 4. Shading (Opsional)
        $shadingPath = null;
        if ($request->hasFile('shading')) {
            $shadingFile = "{$autoName}_shading.png";
            $request->file('shading')->move($destination, $shadingFile);
            $shadingPath = "{$folderPath}/{$shadingFile}";
        }

        Asset::create([
            'category_id'  => $category->id,
            'name'         => $autoName,
            'image_path'   => $color1Path,
            'lineart_path' => $lineartPath,
            'color1_path'  => $color1Path,
            'extra_colors' => $extraColorPaths,
            'shading_path' => $shadingPath,
        ]);

        $totalColors = 1 + count($extraColorPaths);
        $shadingInfo = $shadingPath ? ' + 1 Shading' : '';
        return back()->with('success', "Item {$autoName} berhasil ditambahkan (1 Lineart + {$totalColors} Colour{$shadingInfo})!");
    }

    public function update(Request $request, $id)
    {
        $asset = Asset::findOrFail($id);

        $request->validate([
            'name'           => 'required|string|max:100',
            'category_id'    => 'required|exists:asset_categories,id',
            'lineart'        => 'nullable|image|mimes:png|max:5120',
            'color_1'        => 'nullable|image|mimes:png|max:5120',
            'extra_colors'   => 'nullable|array',
            'extra_colors.*' => 'image|mimes:png|max:5120',
            'shading'        => 'nullable|image|mimes:png|max:5120',
        ]);

        $category = $asset->category;
        $folderPath = "Assets/Character/{$category->slug}";
        $destination = public_path($folderPath);

        $asset->name = $request->name;

        $asset->category_id = $request->category_id;

        if ($request->hasFile('lineart')) {
            if ($asset->lineart_path && File::exists(public_path($asset->lineart_path))) {
                File::delete(public_path($asset->lineart_path));
            }
            $lineartFile = "{$asset->name}_lineart_" . time() . ".png";
            $request->file('lineart')->move($destination, $lineartFile);
            $asset->lineart_path = "{$folderPath}/{$lineartFile}";
        }

        if ($request->hasFile('color_1')) {
            if ($asset->color1_path && File::exists(public_path($asset->color1_path))) {
                File::delete(public_path($asset->color1_path));
            }
            $color1File = "{$asset->name}_color1_" . time() . ".png";
            $request->file('color_1')->move($destination, $color1File);
            $asset->color1_path = "{$folderPath}/{$color1File}";
            $asset->image_path  = $asset->color1_path;
        }

        if ($request->hasFile('extra_colors')) {
            $currentExtras = $asset->extra_colors ?? [];
            $startNum = count($currentExtras) + 2;

            foreach ($request->file('extra_colors') as $index => $file) {
                $colorNum = $startNum + $index;
                $extraFileName = "{$asset->name}_color{$colorNum}_" . time() . ".png";
                $file->move($destination, $extraFileName);
                $currentExtras[] = "{$folderPath}/{$extraFileName}";
            }
            $asset->extra_colors = $currentExtras;
        }

        if ($request->hasFile('shading')) {
            if ($asset->shading_path && File::exists(public_path($asset->shading_path))) {
                File::delete(public_path($asset->shading_path));
            }
            $shadingFile = "{$asset->name}_shading_" . time() . ".png";
            $request->file('shading')->move($destination, $shadingFile);
            $asset->shading_path = "{$folderPath}/{$shadingFile}";
        }

        $asset->save();

        return back()->with('success', "Item {$asset->name} berhasil diperbarui!");
    }

    public function destroy($id)
    {
        $asset = Asset::findOrFail($id);

        $allPaths = array_merge(
            [$asset->lineart_path, $asset->color1_path, $asset->shading_path],
            $asset->extra_colors ?? []
        );

        foreach ($allPaths as $path) {
            if ($path && File::exists(public_path($path))) {
                File::delete(public_path($path));
            }
        }

        $asset->delete();

        return back()->with('success', 'Item aset berhasil dihapus!');
    }
}