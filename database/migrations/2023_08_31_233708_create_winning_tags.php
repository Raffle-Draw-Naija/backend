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
        Schema::create('winning_tags', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("stake_price");
            $table->string("type"); 
            $table->unsignedBigInteger("category_id");
            $table->string("artisan_category")->default("No Category");
            $table->unsignedBigInteger("sub_cat_id");
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('sub_cat_id')->references('id')->on('sub_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('winning_tags');
    }
};
