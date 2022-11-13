<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idsede')->unsigned();
            $table->integer('idperfil')->unsigned();
            $table->integer('idpersonal')->unsigned();
            $table->integer('idinstancia')->unsigned();
            $table->string('apellido',100);
            $table->string('nombre',100);
            $table->integer('dni');
            $table->string('correo',90)->nullable();
            $table->string('sexo',90)->default('M');
            $table->date('fecha_ingreso')->nullable();
            $table->binary('firma')->nullable();
            $table->string('ruta',100)->nullable();
            $table->boolean('condicion')->default(1);
            $table->timestamps();

            $table->foreign('idsede')->references('id')->on('sedes');
            $table->foreign('idperfil')->references('id')->on('perfiles');
            $table->foreign('idpersonal')->references('id')->on('personales');
            $table->foreign('idinstancia')->references('id')->on('instancias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personas');
    }
}
