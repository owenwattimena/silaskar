<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCameOutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_came_out', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->integer('stock_quantity');
            $table->integer('total');
            $table->string('description_of_request', 500)->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('division_id');
            $table->string('status', 20)->default('Proses');
            $table->string('description', 500)->nullable();
            $table->timestamps();
            
            
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('division_id')->references('id')->on('divisions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_came_out');
    }
}