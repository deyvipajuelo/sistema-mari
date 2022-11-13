<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpedienteAnuladosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expediente_anulados', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idexpediente')->unsigned();
            $table->string('estado',60);
            $table->text('motivo');
            $table->integer('idusuario')->unsigned();
            $table->boolean('verificado')->default(0);
            $table->boolean('condicion')->default(1);
            $table->timestamps();
            $table->foreign('idexpediente')->references('id')->on('expedientes');
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
        Schema::dropIfExists('expediente_anulados');
    }
}
