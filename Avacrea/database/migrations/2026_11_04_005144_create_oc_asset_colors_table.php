<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('oc_asset_colors', function (Blueprint $table) {
            $table->id();

            $table->foreignId('oc_asset_id')
                  ->constrained('oc_assets')
                  ->cascadeOnDelete();

            $table->string('color_target', 50);
            $table->string('color_hex', 7);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('oc_asset_colors');
    }
};