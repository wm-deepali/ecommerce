<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('awards', function (Blueprint $table) {
            $table->id();

            $table->string('title'); // Award title
            $table->text('description')->nullable(); // Description
            $table->year('year'); // Award year
            $table->string('image')->nullable(); // Image path

            $table->boolean('status')->default(1); // active/inactive

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('awards');
    }
};