<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->nullable()->constrained('orders')->nullOnDelete();
            $table->string('order_number')->nullable();
            $table->string('gateway')->default('razorpay'); // razorpay, cod
            $table->string('payment_id')->nullable();       // razorpay payment/order id
            $table->decimal('amount', 12, 2)->default(0);
            $table->string('method')->nullable();           // upi, card, cod, etc.
            $table->string('status');                        // created, captured, failed, refunded, pending
            $table->string('customer_name')->nullable();
            $table->string('customer_email')->nullable();
            $table->text('error_message')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->index(['status', 'gateway']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_logs');
    }
};