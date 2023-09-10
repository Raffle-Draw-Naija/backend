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
        Schema::create('win_numbers', function (Blueprint $table) {
            $table->id();
            $table->string('win_num');
            $table->string('month');
            $table->string('year');
            $table->unsignedBigInteger("winning_tag_id");
            $table->foreign('winning_tag_id')->references('id')->on('winning_tags')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('win_numbers');
    }
};
