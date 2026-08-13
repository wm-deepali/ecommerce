<?php
// ──────────────────────────────────────────────────────────────────────────────
// MIGRATION: create_refund_transactions_table
// Place in: database/migrations/xxxx_xx_xx_create_refund_transactions_table.php
// ──────────────────────────────────────────────────────────────────────────────

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('refund_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_return_id')->constrained()->cascadeOnDelete();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();

            $table->enum('refund_method', ['neft_rtgs_imps', 'upi']);
            $table->string('upi_id')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('account_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->string('bank_branch')->nullable();
            $table->string('account_type')->nullable();
            $table->string('utr_id');                    // UTR / Reference number
            $table->decimal('amount', 10, 2)->default(0);
            $table->text('remarks')->nullable();
            $table->string('payment_proof')->nullable(); // Storage path

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('refund_transactions');
    }
};
