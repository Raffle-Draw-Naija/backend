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
        Schema::table('agent_funding_transactions', function (Blueprint $table) {
            $table->string("company_ref");
            $table->string("flw_ref")->nullable();
            $table->string("trx_ref")->nullable();
            $table->string("status");
            $table->string("transaction_id")->nullable();
            $table->string("charge_response_code")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agent_funding_transactions', function (Blueprint $table) {
            //
        });
    }
};
