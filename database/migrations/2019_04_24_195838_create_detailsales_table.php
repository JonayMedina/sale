<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailsalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detailsales', function (Blueprint $table) {
            
            $table->bigIncrements('id');
            $table->integer('sale_id')->unsigned();
            $table->string('description', 256)->nullable();
            $table->integer('product_id')->unsigned();
            $table->integer('quantity');
            $table->decimal('price', 11, 2);
            $table->integer('tax');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detailsales');
    }
}
