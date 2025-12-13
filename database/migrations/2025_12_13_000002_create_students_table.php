<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('students')) {
            Schema::create('students', function (Blueprint $table) {
                $table->id();
                $table->string('S_REGNO')->unique();
                $table->string('name')->nullable();
                $table->integer('CLASS_ROLL')->default(0);
                $table->unsignedBigInteger('GROUP_ID')->nullable();
                $table->integer('is_exist')->default(1);
                $table->timestamps();
            });
        }
    }
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
