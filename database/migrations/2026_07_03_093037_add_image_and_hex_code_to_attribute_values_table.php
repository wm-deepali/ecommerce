<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attribute_values', function (Blueprint $table) {

            $table->string('image')->nullable()->after('value');

            $table->string('hex_code', 20)
                ->nullable()
                ->after('image');

        });
    }

    public function down(): void
    {
        Schema::table('attribute_values', function (Blueprint $table) {

            $table->dropColumn([
                'image',
                'hex_code',
            ]);

        });
    }
};