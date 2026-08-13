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
        Schema::table('attributes', function ($table) {
            $table->boolean('show_in_navbar')->default(false)->after('status');
        });
    }

    public function down()
    {
        Schema::table('attributes', function ($table) {
            $table->dropColumn('show_in_navbar');
        });
    }

};
