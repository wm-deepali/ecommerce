<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('enquiry_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('enquiry_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();

            $table->integer('quantity');
            $table->decimal('price', 10, 2);

            $table->decimal('total', 10, 2)->nullable();

            $table->json('options')->nullable(); // for customization later

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enquiry_items');
    }
};