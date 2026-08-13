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
        Schema::create('home_deal_banners', function (Blueprint $table) {
            $table->id();

            $table->string('image');

            $table->string('title')->nullable();

            $table->string('highlight_text')->nullable();

            $table->string('offer_text')->nullable();

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
        Schema::dropIfExists('home_deal_banners');
    }
};
