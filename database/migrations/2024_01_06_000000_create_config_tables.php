<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('login_config', function (Blueprint $table) {
            $table->id();
            $table->enum('login_type', ['User', 'Admin'])->default('User');
            $table->string('logo_path')->nullable();
            $table->string('background_image')->nullable();
            $table->text('welcome_text')->nullable();
            $table->enum('need_otp', ['Enabled', 'Disabled'])->default('Disabled');
            $table->enum('need_password', ['Enabled', 'Disabled'])->default('Enabled');
            $table->enum('need_email', ['Enabled', 'Disabled'])->default('Enabled');
            $table->enum('need_mobile', ['Enabled', 'Disabled'])->default('Enabled');
            $table->timestamps();
        });

        Schema::create('site_config', function (Blueprint $table) {
            $table->id();
            $table->string('brand_name')->nullable();
            $table->string('address')->nullable();
            $table->string('invoice_email')->nullable();
            $table->string('logo_path')->nullable();
            $table->timestamps();
        });

        Schema::create('form_config', function (Blueprint $table) {
            $table->id();
            $table->integer('form_id');
            $table->text('field_name')->nullable();
            $table->timestamps();
        });

        Schema::create('template_type', function (Blueprint $table) {
            $table->id();
            $table->string('type_name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('template_email', function (Blueprint $table) {
            $table->id();
            $table->foreignId('type_id')->constrained('template_type')->onDelete('cascade');
            $table->string('subject');
            $table->longText('body');
            $table->timestamps();
        });

        Schema::create('language', function (Blueprint $table) {
            $table->id();
            $table->string('language_name');
            $table->string('language_code')->unique();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->timestamps();
        });

        Schema::create('currency', function (Blueprint $table) {
            $table->id();
            $table->string('currency_name');
            $table->string('currency_code')->unique();
            $table->string('currency_symbol')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currency');
        Schema::dropIfExists('language');
        Schema::dropIfExists('template_email');
        Schema::dropIfExists('template_type');
        Schema::dropIfExists('form_config');
        Schema::dropIfExists('site_config');
        Schema::dropIfExists('login_config');
    }
};
