<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cart_items', function (Blueprint $table) {

            // Drop the old single variant reference — replaced by 4
            // type-specific variant ids below (matches the 4 independent
            // variant sets: price / image / stock / sku).
            if (Schema::hasColumn('cart_items', 'variant_id')) {
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

            // All selected attribute values (selectable, variant-backed or
            // not) — snapshot for display in cart/checkout, independent of
            // the variant ids above which only drive price/stock/image/sku.
            // Shape: [{attribute_id, attribute, value_id, value}, ...]
            $table->json('selected_attributes')->nullable()->after('sku_variant_id');
        });
    }

    public function down(): void
    {
        Schema::table('cart_items', function (Blueprint $table) {
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