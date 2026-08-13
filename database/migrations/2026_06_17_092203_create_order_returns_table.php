<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_returns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('order_item_id')->constrained()->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('return_reason_id')->nullable()->constrained()->nullOnDelete();
            $table->text('details')->nullable();
            $table->enum('type', ['return', 'exchange'])->default('return');
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed'])->default('pending');
            $table->text('admin_note')->nullable();

            // ── Refund info ──────────────────────────────────────────────────
            $table->enum('refund_method', ['upi', 'qr', 'bank'])->nullable();

            // UPI
            $table->string('upi_id')->nullable();

            // QR Code (stored path)
            $table->string('qr_image')->nullable();

            // Bank details
            $table->string('bank_name')->nullable();
            $table->string('account_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->string('bank_branch')->nullable();
            $table->enum('account_type', ['savings', 'current', 'salary'])->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_returns');
    }
};