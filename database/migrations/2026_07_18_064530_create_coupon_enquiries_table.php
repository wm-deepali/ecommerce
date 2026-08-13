<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('coupon_enquiries', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('country_code')->default('+91');
            $table->string('phone');
            $table->boolean('whatsapp_optin')->default(true);
            $table->string('status')->default('new'); // new / contacted / converted
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupon_enquiries');
    }
};
