<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {



            if (!Schema::hasColumn('customers', 'dob')) {
                $table->date('dob')->nullable()->after('alternate_mobile');
            }

            if (!Schema::hasColumn('customers', 'gender')) {
                $table->enum('gender', [
                    'male',
                    'female',
                    'other',
                    'prefer_not'
                ])->nullable()->after('dob');
            }

            if (!Schema::hasColumn('customers', 'google_id')) {
                $table->string('google_id')->nullable()->after('gender');
            }

            if (!Schema::hasColumn('customers', 'avatar')) {
                $table->string('avatar')->nullable()->after('google_id');
            }

        });
    }

    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {

            $columns = [
                'dob',
                'gender',
                'google_id',
                'avatar',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('customers', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};