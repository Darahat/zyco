<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('users_group')) {
            Schema::create('users_group', function (Blueprint $table) {
                $table->id();
                $table->string('group_name');
                $table->unsignedBigInteger('owner_id')->nullable();
                $table->tinyInteger('status')->default(1); // 1=active, 0=inactive
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('users_group_members')) {
            Schema::create('users_group_members', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('group_id');
                $table->unsignedBigInteger('member_id');
                $table->tinyInteger('status')->default(1);
                $table->timestamps();
                $table->unique(['group_id', 'member_id']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('users_group_members');
        Schema::dropIfExists('users_group');
    }
};
