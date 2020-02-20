<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 50)->unique();
            $table->string('name', 100)->unique();
            
            $table->integer('category_id')->unsigned();
            $table->integer('stock');
            $table->integer('stock_min')->nullable();
            $table->integer('stock_max')->nullable();
            $table->decimal('price_sell', 10, 2);
            $table->string('description', 256)->nullable();
            $table->integer('price_buy')->nullable();
            $table->integer('tax_id');
            $table->boolean('condition')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
