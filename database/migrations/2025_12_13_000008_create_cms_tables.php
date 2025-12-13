<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('menus')) {
            Schema::create('menus', function (Blueprint $table) {
                $table->id();
                $table->string('menu_name');
                $table->string('menu_type')->nullable();
                $table->integer('menu_order')->default(0);
                $table->unsignedBigInteger('parent_menu')->nullable();
                $table->string('slug')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('postcategories')) {
            Schema::create('postcategories', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('posts')) {
            Schema::create('posts', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('content')->nullable();
                $table->string('category')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('pages')) {
            Schema::create('pages', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('content')->nullable();
                $table->string('slug')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('postcategories');
        Schema::dropIfExists('menus');
    }
};