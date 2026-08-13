<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_images', function (Blueprint $table) {
            $table->string('thumb')->nullable()->after('image');
        });

        Schema::table('product_variant_images', function (Blueprint $table) {
            $table->string('thumb')->nullable()->after('image');
        });
    }

    public function down(): void
    {
        Schema::table('product_images', function (Blueprint $table) {
            $table->dropColumn('thumb');
        });

        Schema::table('product_variant_images', function (Blueprint $table) {
            $table->dropColumn('thumb');
        });
    }
};