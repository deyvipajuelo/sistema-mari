<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUbicacionPaquetesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ubicacion_paquetes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idingreso')->unsigned();
            $table->integer('idlocal')->unsigned();
            $table->integer('anaquel');
            $table->integer('paquete');
            $table->integer('idusuario')->unsigned();
            $table->boolean('condicion')->default(1);
            $table->timestamps();
            $table->foreign('idingreso')->references('id')->on('ingresos');
            $table->foreign('idlocal')->references('id')->on('locales');
            $table->foreign('idusuario')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ubicacion_paquetes');
    }
}
