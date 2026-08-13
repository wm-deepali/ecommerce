<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('contact_branches', function (Blueprint $table) {

            $table->id();

            // BASIC INFO
            $table->string('title'); // Head Office - Delhi
            $table->string('subtitle')->nullable(); // Corporate Headquarters

            // CONTACT DETAILS
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();

            // EXTRA
            $table->string('working_hours')->nullable();

            // ICON (optional - emoji/icon/image)
            $table->string('icon')->nullable();

            // STATUS
            $table->boolean('status')->default(1);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_branches');
    }
};