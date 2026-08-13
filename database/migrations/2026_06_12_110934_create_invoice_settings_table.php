<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoice_settings', function (Blueprint $table) {
            $table->id();

            // Company Info
            $table->string('company_name')->nullable();
            $table->string('company_logo')->nullable();
            $table->text('company_address')->nullable();
            $table->string('company_phone')->nullable();
            $table->string('company_email')->nullable();

            // GST
            $table->string('company_gstin')->nullable();
            $table->string('company_pan')->nullable();

            // Location
            $table->unsignedBigInteger('company_state')->nullable();
            $table->unsignedBigInteger('company_city')->nullable();
            $table->string('company_pincode', 10)->nullable();

            // Tax Settings
            $table->decimal('cgst', 5, 2)->default(9);
            $table->decimal('sgst', 5, 2)->default(9);
            $table->decimal('igst', 5, 2)->default(18);

            $table->enum('tax_type', [
                'inclusive',
                'exclusive'
            ])->default('inclusive');

            $table->enum('business_type', [
                'registered',
                'unregistered'
            ])->default('registered');

            $table->boolean('show_gst_breakup')->default(true);

            // Invoice Settings
            $table->string('invoice_prefix')->default('INV');
            $table->bigInteger('invoice_serial')->default(1);

            $table->enum('invoice_year_format', [
                'none',
                'slash',
                'year'
            ])->default('slash');

            $table->string('invoice_separator')->default('/');

            $table->string('invoice_date_format')
                ->default('d M Y');

            // Automation
            $table->boolean('auto_generate_invoice')
                ->default(true);

            $table->boolean('email_invoice_customer')
                ->default(true);

            // Footer
            $table->text('terms_conditions')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_settings');
    }
};