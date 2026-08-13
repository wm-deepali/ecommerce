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
        Schema::create('gallery_images', function (Blueprint $table) {
            $table->id();

            $table->string('title')->nullable();
            $table->string('image');

            $table->enum('column_no', ['1', '2', '3'])->default('1');

            $table->enum('height_class', [
                'h-sm',
                'h-md',
                'h-lg',
                'h-xl'
            ])->default('h-md');

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
        Schema::dropIfExists('gallery_images');
    }
};
