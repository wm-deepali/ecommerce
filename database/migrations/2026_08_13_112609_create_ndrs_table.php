<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ndrs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')->constrained()->cascadeOnDelete();

            $table->enum('reason', [
                'customer_unavailable',
                'wrong_address',
                'refused_cod',
                'address_unserviceable',
                'requested_reschedule',
                'other',
            ]);

            $table->text('remarks')->nullable();

            // pending          → NDR just raised, awaiting admin action
            // reattempt        → admin scheduled a redelivery attempt
            // delivered        → resolved, item eventually delivered
            // rto              → returned to origin, stock credited back
            // cancelled        → order cancelled entirely
            $table->enum('status', ['pending', 'reattempt', 'delivered', 'rto', 'cancelled'])
                ->default('pending');

            $table->unsignedInteger('attempt_count')->default(1);
            $table->date('next_attempt_date')->nullable();

            $table->string('marked_by')->nullable();   // admin name/email snapshot
            $table->timestamp('resolved_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ndrs');
    }
};