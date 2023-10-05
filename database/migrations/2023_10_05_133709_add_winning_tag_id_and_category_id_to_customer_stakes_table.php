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
        Schema::table('customers_stakes', function (Blueprint $table) {
            $table->unsignedBigInteger("winning_tags_id")->default(0);
            $table->foreign('winning_tags_id')->references('id')->on('winning_tags')->onDelete('cascade');
            $table->unsignedBigInteger("category_id")->default(0);
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_stakes', function (Blueprint $table) {
            //
        });
    }
};
