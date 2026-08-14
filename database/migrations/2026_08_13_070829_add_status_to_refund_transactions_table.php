<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('refund_transactions', function (Blueprint $table) {
            // 'completed' default kept because every refund created so far via
            // OrderReturnController::refund() is an already-confirmed manual
            // transfer (admin enters UTR only after money is actually sent).
            // 'failed' is set later via the mark-failed action if the transfer bounces.
            $table->enum('status', ['completed', 'failed'])
                ->default('completed')
                ->after('order_return_id');
        });
    }

    public function down(): void
    {
        Schema::table('refund_transactions', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};