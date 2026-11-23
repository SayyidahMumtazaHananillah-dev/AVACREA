<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->string('image_path')->nullable()->change();
            $table->string('lineart_path')->after('name');
            $table->string('color1_path')->after('lineart_path');
            // Menyimpan array JSON untuk colour ke-2, ke-3, ke-4, dst. (unlimited)
            $table->json('extra_colors')->nullable()->after('color1_path');
        });
    }

    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropColumn(['lineart_path', 'color1_path', 'extra_colors']);
        });
    }
};