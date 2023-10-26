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
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id_product')->primary();
            $table->string('title')->unique()->nullable(false);
            $table->integer('price')->nullable(false);
            $table->string('description')->nullable(true);
            $table->string('category')->nullable(false);
            $table->string('image')->nullable(false);
            $table->integer('rate')->nullable(false);
            $table->integer('count')->nullable(false);
            $table->foreign('category')->references('nm_category')->on('category');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
