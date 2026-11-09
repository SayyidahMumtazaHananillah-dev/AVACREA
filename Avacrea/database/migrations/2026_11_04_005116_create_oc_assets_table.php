<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('oc_assets', function (Blueprint $table) {
            $table->id();

            $table->foreignId('oc_id')
                  ->constrained('ocs')
                  ->cascadeOnDelete();

            $table->foreignId('asset_id')
                  ->constrained('assets')
                  ->cascadeOnDelete();

            $table->integer('layer_order')->default(0);

            $table->timestamps();

            $table->unique(['oc_id', 'asset_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('oc_assets');
    }
};