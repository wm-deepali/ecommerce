<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_templates', function (Blueprint $table) {
            $table->id();
            $table->string('event_key')->unique();
            $table->boolean('enabled')->default(false);
            $table->string('from_name')->nullable();
            $table->string('from_email')->nullable();
            $table->string('reply_to_name')->nullable();
            $table->string('reply_to_email')->nullable();
            $table->string('cc')->nullable();
            $table->string('subject')->nullable();
            $table->string('preview_text')->nullable();
            $table->longText('body')->nullable();
            $table->json('extra_settings')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_templates');
    }
};