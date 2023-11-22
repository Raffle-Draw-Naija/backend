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
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->string("currency_code", 100);
            $table->tinyInteger("intrabank");
            $table->bigInteger("minor_amount");
            $table->bigInteger("minor_fee_amount");
            $table->bigInteger("minor_vat_amount")->default(0);
            $table->string("name_enquiry_reference")->nullable();
            $table->string("narration", 255);
            $table->string("Response_code", 10);
            $table->string("sink_account_name", 100);
            $table->string("sink_account_number", 11);
            $table->string("sink_account_provider_code", 10);
            $table->string("status", 20)->default("pending");
            $table->string("transaction_id", 15);
            $table->string("transaction_status", 15);
            $table->string("transaction_type", 10);
            $table->unsignedBigInteger("user_id");
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger("bank_accounts");
            $table->foreign('bank_accounts')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger("customer_id");
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
