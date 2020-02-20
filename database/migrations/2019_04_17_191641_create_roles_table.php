<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 30)->unique();
            $table->string('description', 100)->nullable();
            $table->boolean('condition')->default(1);
        });
        DB::table('roles')->insert(array('id'=>'1','name'=>'Administrador','description'=>'administrador del sitio'));
        DB::table('roles')->insert(array('id'=>'2','name'=>'Vendedor','description'=>'vendedor del sitio'));
        DB::table('roles')->insert(array('id'=>'3','name'=>'Almacenista','description'=>'almacenista del sitio'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
