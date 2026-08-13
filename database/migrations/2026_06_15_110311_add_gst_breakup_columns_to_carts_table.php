<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('carts', function (Blueprint $table) {

            $table->enum('gst_type', [
                'cgst_sgst',
                'igst'
            ])->nullable()->after('tax_amount');

            $table->decimal('cgst_rate', 5, 2)
                ->default(0)
                ->after('gst_type');

            $table->decimal('sgst_rate', 5, 2)
                ->default(0)
                ->after('cgst_rate');

            $table->decimal('igst_rate', 5, 2)
                ->default(0)
                ->after('sgst_rate');

            $table->decimal('cgst_amount', 10, 2)
                ->default(0)
                ->after('igst_rate');

            $table->decimal('sgst_amount', 10, 2)
                ->default(0)
                ->after('cgst_amount');

            $table->decimal('igst_amount', 10, 2)
                ->default(0)
                ->after('sgst_amount');
        });
    }

    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {

            $table->dropColumn([
                'gst_type',
                'cgst_rate',
                'sgst_rate',
                'igst_rate',
                'cgst_amount',
                'sgst_amount',
                'igst_amount',
            ]);
        });
    }
};