<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('oc_images', function (Blueprint $table) {
            $table->id();

            $table->foreignId('oc_id')
                  ->constrained('ocs')
                  ->cascadeOnDelete();

            $table->string('image_path');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('oc_images');
    }
};