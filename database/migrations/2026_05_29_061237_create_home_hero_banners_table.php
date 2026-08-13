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
        Schema::create('home_hero_banners', function (Blueprint $table) {

            $table->id();

            $table->string('image');

            $table->string('small_text')->nullable();

            $table->string('title')->nullable();

            $table->string('button_text')->nullable();

            $table->string('button_link')->nullable();

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
        Schema::dropIfExists('home_hero_banners');
    }
};
