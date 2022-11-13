<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvinciaJudicialesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provincia_judiciales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('iddjudicial')->unsigned();
            $table->string('nombre',100);
            $table->boolean('condicion')->default(1);
            $table->timestamps();
            $table->foreign('iddjudicial')->references('id')->on('distrito_judiciales');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('provincia_judiciales');
    }
}
