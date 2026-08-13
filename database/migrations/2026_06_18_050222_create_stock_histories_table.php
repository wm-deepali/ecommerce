<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();

            $table->enum('type', ['credit', 'debit']);
            $table->unsignedInteger('quantity');
            $table->integer('stock_before');
            $table->integer('stock_after');

            // order | admin_adjustment | restock | bulk_import | damage | return | initial_stock
            $table->string('reason');

            // Optional link back to whatever caused the change (e.g. an Order)
            $table->string('reference_type')->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();

            // Nullable: customer-triggered debits (orders) have no admin attached.
            // Left as a plain column (no FK) since your admin/user table name may vary —
            // add a foreign key constraint here once you know which table to point at.
            $table->unsignedBigInteger('created_by')->nullable();

            $table->text('note')->nullable();

            $table->timestamps();

            $table->index(['product_id', 'created_at']);
            $table->index(['reference_type', 'reference_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_histories');
    }
};