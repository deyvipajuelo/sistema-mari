<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpedientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expedientes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idingreso')->unsigned();
            $table->string('codigo',45);
            $table->string('responsable',60);
            $table->integer('idespecialidad')->unsigned();
            $table->string('numero_origen',20);
            $table->integer('anio_expediente');
            $table->integer('numero_expediente');
            $table->integer('idtexpediente')->unsigned();
            $table->integer('numero_folio');
            $table->integer('numero_cuaderno');
            $table->integer('idestado')->unsigned();
            $table->integer('idtarchivo')->unsigned();
            $table->Date('fecha_conclusion');
            $table->integer('idtconclusion')->unsigned();
            $table->Date('fecha_recepcion');
            $table->integer('idlocal')->unsigned();
            $table->string('anaquel',20);
            $table->string('paquete',20);
            $table->text('observacion')->nullable();
            $table->integer('idusuario')->unsigned();
            $table->boolean('condicion')->default(1);
            $table->timestamps();
            $table->foreign('idingreso')->references('id')->on('ingresos');
            $table->foreign('idespecialidad')->references('id')->on('especialidades');
            $table->foreign('idtexpediente')->references('id')->on('tipo_expedientes');
            $table->foreign('idestado')->references('id')->on('estados');
            $table->foreign('idtarchivo')->references('id')->on('tipo_archivos');
            $table->foreign('idtconclusion')->references('id')->on('tipo_conclusiones');
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
        Schema::dropIfExists('expedientes');
    }
}
