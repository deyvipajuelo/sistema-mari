<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleLegajosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_legajos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idlegajo')->unsigned();
            $table->text('descripcion')->nullable();
            $table->string('observacion',200)->nullable();
            $table->integer('anio');
            $table->integer('folio');
            $table->string('estado',90);
            $table->boolean('condicion')->default(1);
            $table->timestamps();
            $table->foreign('idlegajo')->references('id')->on('legajos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalle_legajos');
    }
}
