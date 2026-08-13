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
        Schema::create('home_feature_cards', function (Blueprint $table) {
            $table->id();

            $table->string('icon');
            $table->string('title');
            $table->text('content')->nullable();

            $table->string('card_class')->nullable(); // aqf-pastel-peach

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
        Schema::dropIfExists('home_feature_cards');
    }
};
