<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('home_brand_section_images', function (Blueprint $table) {

            $table->id();

            $table->foreignId('home_brand_section_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('image');

            $table->integer('sort_order')->default(0);

            $table->boolean('status')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_brand_section_images');
    }
};
