<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('class_subject')) {
            Schema::create('class_subject', function (Blueprint $table) {
                $table->id();
                $table->string('class_name')->nullable();
                $table->unsignedBigInteger('GROUP_ID')->nullable();
                $table->string('subject_name')->nullable();
                $table->timestamps();
            });
        }
    }
    public function down(): void
    {
        Schema::dropIfExists('class_subject');
    }
};
