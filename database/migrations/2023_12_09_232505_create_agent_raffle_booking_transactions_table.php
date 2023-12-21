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
        Schema::create('agent_raffle_booking_transactions', function (Blueprint $table) {
            $table->id();
            $table->string("narration")->nullable();
            $table->double("balance_bd")->nullable(); // Balance Before deduction
            $table->double("balance_ad")->nullable(); // Balance after deduction
            $table->double("amount");
            $table->unsignedBigInteger("user_id");
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger("agent_id");
            $table->foreign('agent_id')->references('id')->on('agents')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agent_raffle_booking_transactions');
    }
};
