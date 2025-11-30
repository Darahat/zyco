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
        Schema::create('vehicle_classification', function (Blueprint $table) {
            $table->id();
            $table->string('classification_name');
            $table->text('description')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->timestamps();
        });

        Schema::create('vehicle_type', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_classification_id')->constrained('vehicle_classification')->onDelete('cascade');
            $table->string('vehicle_type_name');
            $table->text('description')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->timestamps();
        });

        Schema::create('vehicle_make', function (Blueprint $table) {
            $table->id();
            $table->string('make_vehicle_name');
            $table->text('description')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->timestamps();
        });

        Schema::create('vehicle_model', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_make_id')->constrained('vehicle_make')->onDelete('cascade');
            $table->string('model_name');
            $table->text('description')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_model');
        Schema::dropIfExists('vehicle_make');
        Schema::dropIfExists('vehicle_type');
        Schema::dropIfExists('vehicle_classification');
    }
};
