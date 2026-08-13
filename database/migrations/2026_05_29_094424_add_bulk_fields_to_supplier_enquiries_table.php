<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('supplier_enquiries', function (Blueprint $table) {

            $table->string('quantity')->nullable();

            $table->date('delivery_date')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('supplier_enquiries', function (Blueprint $table) {
            $table->dropColumn('quantity');
            $table->dropColumn('delivery_date');
        });
    }
};
