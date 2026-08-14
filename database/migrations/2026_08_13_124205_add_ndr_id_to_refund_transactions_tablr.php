<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('refund_transactions', function ($table) {
            $table->foreignId('ndr_id')->nullable()->after('order_return_id')
                ->constrained('ndrs')->nullOnDelete();
        });

        // order_return_id must become nullable — a refund can now originate
        // from an Ndr (RTO/Cancel) instead of an OrderReturn.
        // Using raw SQL to avoid requiring doctrine/dbal for a single column change.
        DB::statement('ALTER TABLE refund_transactions MODIFY COLUMN order_return_id BIGINT UNSIGNED NULL');
    }

    public function down(): void
    {
        Schema::table('refund_transactions', function ($table) {
            $table->dropConstrainedForeignId('ndr_id');
        });

        DB::statement('ALTER TABLE refund_transactions MODIFY COLUMN order_return_id BIGINT UNSIGNED NOT NULL');
    }
};