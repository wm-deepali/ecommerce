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
        Schema::create('vendor_enquiries', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('company');
            $table->string('email');
            $table->string('phone');

            // 🔥 your single select
            $table->foreignId('vendor_type_id')->nullable()->constrained('vendor_types')->nullOnDelete();

            $table->text('description')->nullable();
            $table->string('capacity')->nullable();
            $table->string('city')->nullable();

            $table->string('catalogue')->nullable();

            $table->string('status')->default('new');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_enquiries');
    }
};
