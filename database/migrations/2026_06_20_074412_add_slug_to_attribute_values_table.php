<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    // add_slug_to_attribute_values_table
    public function up()
    {
        Schema::table('attribute_values', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('value');
            $table->unique(['attribute_id', 'slug']); // unique per attribute, not globally
        });
    }

    public function down()
    {
        Schema::table('attribute_values', function (Blueprint $table) {
            $table->dropUnique(['attribute_id', 'slug']);
            $table->dropColumn('slug');
        });
    }
};
