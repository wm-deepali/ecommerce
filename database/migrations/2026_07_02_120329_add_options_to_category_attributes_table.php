<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('category_attributes', function (Blueprint $table) {
            $table->boolean('price_dependent')->default(false)->after('used_for_variant');
            $table->boolean('image_dependent')->default(false)->after('price_dependent');
            $table->boolean('stock_dependent')->default(false)->after('image_dependent');
            $table->boolean('sku_dependent')->default(false)->after('stock_dependent');
            $table->boolean('is_selectable')->default(true)->after('sku_dependent');
        });
    }

    public function down()
    {
        Schema::table('category_attributes', function (Blueprint $table) {
            $table->dropColumn([
                'price_dependent',
                'image_dependent',
                'stock_dependent',
                'sku_dependent',
                'is_selectable',
            ]);
        });
    }
};