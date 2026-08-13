<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cart_item_addons', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cart_item_id')
                ->constrained('cart_items')
                ->cascadeOnDelete();

            // nullOnDelete (not cascade) so an addon being removed from the
            // product later doesn't wipe out an already-placed cart line —
            // the snapshot columns below keep it usable either way.
            $table->foreignId('addon_id')
                ->nullable()
                ->constrained('product_addons')
                ->nullOnDelete();

            $table->string('detail');           // snapshot of ProductAddon::detail
            $table->decimal('price', 10, 2);    // snapshot of ProductAddon::price (per unit)

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_item_addons');
    }
};