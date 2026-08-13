<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {

            if (Schema::hasColumn('order_items', 'variant_id')) {
                $table->dropConstrainedForeignId('variant_id');
            }

            $table->foreignId('price_variant_id')
                ->nullable()
                ->after('product_id')
                ->constrained('product_variants')
                ->nullOnDelete();

            $table->foreignId('image_variant_id')
                ->nullable()
                ->after('price_variant_id')
                ->constrained('product_variants')
                ->nullOnDelete();

            $table->foreignId('stock_variant_id')
                ->nullable()
                ->after('image_variant_id')
                ->constrained('product_variants')
                ->nullOnDelete();

            $table->foreignId('sku_variant_id')
                ->nullable()
                ->after('stock_variant_id')
                ->constrained('product_variants')
                ->nullOnDelete();

            // Snapshot of selected attribute values — same shape/purpose as
            // cart_items.selected_attributes, carried forward at order time
            // so it stays accurate even if the product's attributes change later.
            $table->json('selected_attributes')->nullable()->after('sku_variant_id');
        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropConstrainedForeignId('price_variant_id');
            $table->dropConstrainedForeignId('image_variant_id');
            $table->dropConstrainedForeignId('stock_variant_id');
            $table->dropConstrainedForeignId('sku_variant_id');
            $table->dropColumn('selected_attributes');

            $table->foreignId('variant_id')
                ->nullable()
                ->constrained('product_variants')
                ->nullOnDelete();
        });
    }
};