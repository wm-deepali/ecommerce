<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {

            $table->id();

            // Site Identity
            $table->string('site_name')->nullable();
            $table->string('tagline')->nullable();
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();

            // Contact
            $table->string('admin_email')->nullable();
            $table->string('support_email')->nullable();
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->text('business_address')->nullable();

            // Footer
            $table->text('footer_description')->nullable();
            $table->string('footer_copyright')->nullable();
            $table->string('google_map_url')->nullable();

            // Social Links
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('twitter')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('youtube')->nullable();
            $table->string('pinterest')->nullable();

            // Regional
            $table->string('currency')->default('INR');
            $table->string('currency_symbol')->default('₹');
            $table->string('timezone')->default('Asia/Kolkata');

            // Features
            $table->boolean('maintenance_mode')->default(false);
            $table->integer('admin_session_timeout')->default(60);
            $table->boolean('product_reviews')->default(true);
            $table->boolean('wishlist')->default(true);
            $table->boolean('stock_alerts')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};