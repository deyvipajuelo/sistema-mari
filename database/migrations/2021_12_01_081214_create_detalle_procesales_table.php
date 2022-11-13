<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleProcesalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_procesales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idexpediente')->unsigned();
            $table->integer('idpprocesal')->unsigned();
            $table->integer('idcpersona')->unsigned();
            $table->string('apellido',60);
            $table->string('nombre',60);
            $table->boolean('condicion')->default(1);
            $table->timestamps();
            $table->foreign('idexpediente')->references('id')->on('expedientes');
            $table->foreign('idpprocesal')->references('id')->on('parte_procesales');
            $table->foreign('idcpersona')->references('id')->on('clase_personas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalle_procesales');
    }
}
