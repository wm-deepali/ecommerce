<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sub_title')->nullable();

            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            $table->string('image')->nullable();

            // 🔥 parent-child relation
            $table->unsignedBigInteger('parent_id')->nullable();

            $table->boolean('is_popular')->default(0);
            $table->boolean('is_featured')->default(0);
            $table->boolean('status')->default(1);
            $table->integer('sort_order')->default(0);
            $table->string('added_by')->default('Admin');

            $table->timestamps();
            $table->softDeletes();

            // foreign key (optional but recommended)
            $table->foreign('parent_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('categories');
    }
}