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
        Schema::create('key_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('worker_id')->nullable();
            $table->foreign('worker_id')->references('id')->on('workers');
            $table->unsignedBigInteger('key_id')->nullable();
            $table->foreign('key_id')->references('id')->on('keys');
            $table->dateTime('time_in');
            $table->dateTime('time_out')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('key_logs');
    }
};
