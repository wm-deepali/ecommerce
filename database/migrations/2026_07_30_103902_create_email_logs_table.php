<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_logs', function (Blueprint $table) {
            $table->id();

            $table->string('event_key');
            $table->string('to_email');
            $table->string('to_name')->nullable();
            $table->string('subject')->nullable();

            $table->enum('status', ['sent', 'failed', 'blocked'])->default('sent');

            $table->string('reference')->nullable(); // e.g. order_number, auto-extracted
            $table->text('error_message')->nullable();
            $table->json('meta')->nullable(); // raw $variables passed to send()

            $table->timestamps();

            $table->index('event_key');
            $table->index('status');
            $table->index('reference');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_logs');
    }
};