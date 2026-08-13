<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_settings', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('critical_threshold')->default(0);
            $table->unsignedInteger('low_stock_threshold')->default(20);
            $table->unsignedInteger('watch_list_threshold')->default(30);

            $table->boolean('notify_email')->default(true);
            $table->boolean('notify_dashboard')->default(true);
            $table->boolean('auto_disable_out_of_stock')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_settings');
    }
};