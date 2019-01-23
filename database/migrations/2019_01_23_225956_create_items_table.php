<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_category')->unsigned();
            $table->string('code', 50)->nullable();
            $table->string('name', 100)->unique();
            //Selling Price
            $table->decimal('sale_price', 11, 2);
            $table->integer('stock');
            $table->string('description', 256)->nullable();
            $table->boolean('condicion')->default(1);

            $table->timestamps();

            $table->foreign('id_category')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
