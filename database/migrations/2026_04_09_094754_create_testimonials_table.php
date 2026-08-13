<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();

            $table->enum('type', ['text', 'reel']);

            $table->string('name');
            $table->text('feedback')->nullable();

            $table->integer('rating')->nullable();

            $table->string('photo')->nullable();

            $table->string('reel_file')->nullable();
            $table->string('reel_url')->nullable();

            $table->boolean('status')->default(1);

            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
