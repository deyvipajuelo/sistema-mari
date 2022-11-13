<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleMateriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_materias', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idexpediente')->unsigned();
            $table->integer('idmateria')->unsigned();
            $table->boolean('condicion')->default(1);
            $table->timestamps();
            $table->foreign('idexpediente')->references('id')->on('expedientes');
            $table->foreign('idmateria')->references('id')->on('materias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalle_materias');
    }
}
