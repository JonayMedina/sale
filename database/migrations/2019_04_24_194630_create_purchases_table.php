<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('provider_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->enum('voucher',['bill', 'note', 'credit'])->default('bill');
            $table->string('voucher_serie', 7)->nullable();
            $table->string('voucher_num', 10);
            $table->date('date');
            $table->decimal('total', 20, 2);
            $table->decimal('tax_mount', 20,2);
            $table->integer('tax', 4);
            
            $table->integer('exempt', 20, 2)->nullable();
            $table->bigInteger('ret_id')->unsigned();
            $table->foreing('ret_id')->references('id')->on('retentions');
            $table->decimal('total_ret', 20,2);
            $table->string('status', 20);
            $table->string('description');
            $table->string('type', 10);
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
        Schema::dropIfExists('purchases');
    }
}
