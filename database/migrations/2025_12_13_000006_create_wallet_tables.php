<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('user_wallet')) {
            Schema::create('user_wallet', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->decimal('opening_balance', 10, 2)->default(0);
                $table->string('currency_code', 10)->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('user_wallet_transection')) {
            Schema::create('user_wallet_transection', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->enum('transection_type', ['credit', 'debit']);
                $table->decimal('amount', 10, 2);
                $table->string('description')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('user_wallet_transection');
        Schema::dropIfExists('user_wallet');
    }
};