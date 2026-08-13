<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // order, stock, payment, customer, cancel, return, system
            $table->string('title');
            $table->text('message')->nullable();
            $table->string('reference')->nullable(); // #ORD-1089, SKU-4421
            $table->string('icon')->nullable();
            $table->string('color')->nullable();
            $table->string('url')->nullable();
            $table->string('link_text')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->index(['type']);
            $table->index(['read_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_notifications');
    }
};