<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'image_path',
        'lineart_path',
        'color1_path',
        'extra_colors',
        'shading_path',
    ];

    protected $casts = [
        'extra_colors' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(AssetCategory::class, 'category_id');
    }
}