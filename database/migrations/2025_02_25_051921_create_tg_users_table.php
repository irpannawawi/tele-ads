<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tg_users', function (Blueprint $table) {
            $table->id();
            $table->string('phone')->unique('phone')->index('phone');
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('username')->nullable();

            $table->integer('watched_ads_count')->default(0);
            $table->integer('earned_points')->default(0);
            $table->integer('total_withdraw')->default(0);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tg_users');
    }
};
