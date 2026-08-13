<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // fabric_care already exists — these three are new, matching
            // the new Content tabs added to admin.products.create/edit.
            if (!Schema::hasColumn('products', 'shipping_delivery')) {
                $table->longText('shipping_delivery')->nullable()->after('fabric_care');
            }
            if (!Schema::hasColumn('products', 'exchange_policy')) {
                $table->longText('exchange_policy')->nullable()->after('shipping_delivery');
            }
            if (!Schema::hasColumn('products', 'customization_assistance')) {
                $table->longText('customization_assistance')->nullable()->after('exchange_policy');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'shipping_delivery',
                'exchange_policy',
                'customization_assistance',
            ]);
        });
    }
};