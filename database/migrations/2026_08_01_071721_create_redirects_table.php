<?php
// database/migrations/xxxx_xx_xx_create_redirects_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('redirects', function (Blueprint $table) {
            $table->id();
            $table->string('from_url');
            $table->string('to_url')->nullable(); // null allowed for 410 Gone
            $table->enum('type', ['301', '302', '410'])->default('301');
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('hits')->default(0);
            $table->string('note')->nullable(); // e.g. "Product renamed"
            $table->timestamps();

            $table->index('from_url');
            $table->index(['type', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('redirects');
    }
};