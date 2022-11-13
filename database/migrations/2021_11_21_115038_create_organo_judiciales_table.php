<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganoJudicialesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organo_judiciales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idpjudicial')->unsigned();
            $table->string('nombre',100);
            $table->boolean('condicion')->default(1);
            $table->timestamps();
            $table->foreign('idpjudicial')->references('id')->on('provincia_judiciales');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organo_judiciales');
    }
}
