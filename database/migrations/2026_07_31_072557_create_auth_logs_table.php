<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('auth_logs', function (Blueprint $table) {
            $table->id();
            $table->string('user_type')->default('customer'); // admin, customer
            $table->string('email')->nullable();
            $table->string('event');                            // login, login_failed, logout
            $table->string('status');                           // success, failed
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->text('error_message')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->index(['user_type', 'event', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auth_logs');
    }
};