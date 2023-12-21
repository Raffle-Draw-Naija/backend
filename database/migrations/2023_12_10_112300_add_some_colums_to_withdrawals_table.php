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
        Schema::table('withdrawals', function (Blueprint $table) {
            $table->string("full_name")->nullable();
            $table->string("trx_date")->nullable();
            $table->string("currency")->nullable();
            $table->string("debit_currency")->nullable();
            $table->double("fee")->nullable();
            $table->string("reference");
            $table->integer("requires_approval")->nullable();
            $table->integer("is_approved")->nullable();
            $table->string("bank_name")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('withdrawals', function (Blueprint $table) {
            //
        });
    }
};
