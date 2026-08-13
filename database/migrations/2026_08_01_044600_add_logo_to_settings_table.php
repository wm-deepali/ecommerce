<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->renameColumn('logo', 'header_logo');
            $table->string('footer_logo')->nullable()->after('header_logo');
            $table->string('admin_login_logo')->nullable()->after('favicon');
            $table->string('admin_dashboard_logo')->nullable()->after('admin_login_logo');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['footer_logo', 'admin_login_logo', 'admin_dashboard_logo']);
            $table->renameColumn('header_logo', 'logo');
        });
    }
};