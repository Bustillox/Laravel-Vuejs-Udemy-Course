<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameCostumersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::rename('costumers','customers');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('costumers');
        Schema::dropIfExists('customers');
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100)->unique();
            $table->string('document_type', 20)->nullable();
            $table->string('document_number', 20)->nullable();
            $table->string('address', 70)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email', 50)->nullable();
            $table->timestamps();
        });
    }
}
