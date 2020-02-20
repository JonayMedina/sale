<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailpurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detailpurchases', function (Blueprint $table) {
            
            $table->bigIncrements('id');
            $table->integer('purchase_id')->unsigned();
            
            $table->integer('product_id')->unsigned();
            
            $table->integer('quantity');
            $table->decimal('price', 20, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detailpurchases');
    }
}
