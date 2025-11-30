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
        Schema::create('users_vehicle', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('license_plate')->unique();
            $table->foreignId('vehicle_type_id')->nullable()->constrained('vehicle_type');
            $table->foreignId('vehicle_make_id')->nullable()->constrained('vehicle_make');
            $table->foreignId('vehicle_model_id')->nullable()->constrained('vehicle_model');
            $table->string('trade_name')->nullable();
            $table->string('device')->nullable();
            $table->string('first_color')->nullable();
            $table->integer('number_cylinders')->nullable();
            $table->integer('number_doors')->nullable();
            $table->enum('is_active', ['Yes', 'No'])->default('Yes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_vehicle');
    }
};
