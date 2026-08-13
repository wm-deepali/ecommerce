<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('smtp_settings', function (Blueprint $table) {
            $table->boolean('order_cancelled')->default(true)->after('order_delivered');
            $table->boolean('payment_received')->default(true)->after('order_cancelled');
            $table->boolean('coupon')->default(false)->after('payment_received');
            $table->boolean('welcome')->default(true)->after('coupon');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('smtp_settings', function (Blueprint $table) {
            $table->dropColumn([
                'order_cancelled',      // add
                'payment_received',     // add
                'coupon',               // add
                'welcome',
            ]);
        });
    }
};
