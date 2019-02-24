<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

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
            $table->increments('id');
            $table->string('name', 30)->unique();
            $table->string('description', 100)->nullable();
            $table->boolean('condition')->default(1);
        });
        DB::table('roles')->insert(array('id'=>'1','name'=>'Administrador', 'description'=>'Administradores de Área'));
        DB::table('roles')->insert(array('id'=>'2','name'=>'Vendedor', 'description'=>'Vendedor área de venta'));
        DB::table('roles')->insert(array('id'=>'3','name'=>'Almacenero', 'description'=>'Almacenero área de compra'));
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
