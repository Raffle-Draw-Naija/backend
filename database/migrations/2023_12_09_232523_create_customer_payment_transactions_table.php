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
        Schema::create('customer_funding_transactions', function (Blueprint $table) {
            $table->id();
            $table->string("narration")->nullable();
            $table->double("balance_ba")->nullable(); // Balance Before Addition
            $table->double("balance_aa")->nullable(); // Balance After Addition
            $table->double("amount");
            $table->unsignedBigInteger("user_id");
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger("customer_id");
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_funding_transactions');
    }
};
