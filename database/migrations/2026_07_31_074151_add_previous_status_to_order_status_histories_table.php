<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_status_histories', function (Blueprint $table) {
            $table->string('previous_status')->nullable()->after('status');
            $table->string('triggered_by')->nullable()->after('remarks'); // e.g. Customer, Razorpay Webhook, Admin (name), System
        });
    }

    public function down(): void
    {
        Schema::table('order_status_histories', function (Blueprint $table) {
            $table->dropColumn(['previous_status', 'triggered_by']);
        });
    }
};