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
        Schema::create('withdraws', function (Blueprint $table) {
            $table->id();
            $table->string('phone');
            $table->string('address');
            $table->string('amount');
            $table->string('method');
            $table->string('status')->default('pending');
            $table->string('note')->nullable();
            $table->foreign('phone')->references('phone')->on('tg_users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdraws');
    }
};
