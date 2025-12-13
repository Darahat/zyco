<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('hsc_subject_group')) {
            Schema::create('hsc_subject_group', function (Blueprint $table) {
                $table->id();
                $table->string('class_name')->nullable();
                $table->string('group_name')->nullable();
                $table->string('subject_name')->nullable();
                $table->timestamps();
            });
        }
    }
    public function down(): void
    {
        Schema::dropIfExists('hsc_subject_group');
    }
};
