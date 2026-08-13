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
        Schema::create('supplier_enquiries', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('company');
            $table->string('email');
            $table->string('phone');

            $table->foreignId('category_id')->constrained()->cascadeOnDelete();

            $table->string('capacity')->nullable();
            $table->string('moq')->nullable();

            $table->text('description')->nullable();

            $table->string('city')->nullable();
            $table->string('gst')->nullable();

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
        Schema::dropIfExists('supplier_enquiries');
    }
};
