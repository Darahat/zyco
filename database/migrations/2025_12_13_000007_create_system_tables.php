<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('currency')) {
            Schema::create('currency', function (Blueprint $table) {
                $table->id();
                $table->string('currency_code', 10)->unique();
                $table->string('currency_name');
                $table->string('currency_symbol', 10)->nullable();
                $table->enum('status', ['Active', 'Inactive'])->default('Active');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('language')) {
            Schema::create('language', function (Blueprint $table) {
                $table->id();
                $table->string('language_code', 10)->unique();
                $table->string('language_name');
                $table->enum('status', ['Active', 'Inactive'])->default('Active');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('fees')) {
            Schema::create('fees', function (Blueprint $table) {
                $table->id();
                $table->string('fees_code', 50)->unique();
                $table->string('fees_name');
                $table->decimal('amount', 10, 2)->default(0);
                $table->enum('status', ['Active', 'Inactive'])->default('Active');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('timezones')) {
            Schema::create('timezones', function (Blueprint $table) {
                $table->id();
                $table->string('timezone_name');
                $table->string('timezone_offset', 10);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('timezones');
        Schema::dropIfExists('fees');
        Schema::dropIfExists('language');
        Schema::dropIfExists('currency');
    }
};