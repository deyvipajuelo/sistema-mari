<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOficiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oficios', function (Blueprint $table) {
            $table->id();
            $table->text('id_expediente')->nullable();
            $table->text('numero_oficio')->nullable();
            $table->text('jefe')->nullable();
            $table->text('ref')->nullable();
            $table->text('queja')->nullable();
            $table->text('demandado')->nullable();
            $table->text('anaquel')->nullable();
            $table->text('paquete')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('oficios');
    }
}
