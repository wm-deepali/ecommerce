<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('api_logs', function (Blueprint $table) {
            $table->id();
            $table->string('method');                 // GET, POST, etc.
            $table->string('endpoint');
            $table->string('service');                 // Razorpay, reCAPTCHA, MSG91, Meta WhatsApp, Shiprocket...
            $table->unsignedSmallInteger('status_code')->nullable();
            $table->unsignedInteger('response_time_ms')->nullable();
            $table->json('request_payload')->nullable();
            $table->json('response_payload')->nullable();
            $table->text('error_message')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamps();

            $table->index(['service', 'status_code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('api_logs');
    }
};