<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngresosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingresos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idijudicial')->unsigned();
            $table->integer('idlocal')->unsigned();
            $table->integer('idusuario')->unsigned();
            $table->integer('numero_ingreso');
            $table->dateTime('fecha_ingreso');
            $table->integer('cantidad_expediente');
            $table->integer('expediente_digitado');
            $table->string('verificado',10)->default('NO');
            $table->string('anulado',10)->default('NO');
            $table->text('observacion')->nullable();
            $table->boolean('condicion')->default(1);
            $table->timestamps();
            $table->foreign('idijudicial')->references('id')->on('instancia_judiciales');
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
        Schema::dropIfExists('ingresos');
    }
}
