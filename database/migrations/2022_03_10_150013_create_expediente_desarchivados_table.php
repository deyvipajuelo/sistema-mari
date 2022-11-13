<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpedienteDesarchivadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expediente_desarchivados', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idexpediente')->unsigned();
            $table->text('motivo')->nullable();
            $table->integer('idestado')->unsigned();
            $table->integer('idusuario')->unsigned();
            $table->boolean('condicion')->default(1);
            $table->timestamps();
            $table->foreign('idexpediente')->references('id')->on('expedientes');
            $table->foreign('idestado')->references('id')->on('estados');
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
        Schema::dropIfExists('expediente_desarchivados');
    }
}
