<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('smtp_settings', function (Blueprint $table) {

            $table->id();

            $table->string('smtp_host')->nullable();
            $table->integer('smtp_port')->nullable();

            $table->string('smtp_username')->nullable();
            $table->text('smtp_password')->nullable();

            $table->enum(
                'smtp_encryption',
                ['tls', 'ssl', 'none']
            )->default('tls');

            $table->string('from_name')->nullable();
            $table->string('from_email')->nullable();

            $table->string('reply_to_name')->nullable();
            $table->string('reply_to_email')->nullable();

            $table->boolean('order_confirmation')->default(true);
            $table->boolean('order_shipped')->default(true);
            $table->boolean('order_delivered')->default(true);
            $table->boolean('password_reset')->default(true);
            $table->boolean('new_order_alert')->default(true);
            $table->boolean('low_stock_alert')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('smtp_settings');
    }
};