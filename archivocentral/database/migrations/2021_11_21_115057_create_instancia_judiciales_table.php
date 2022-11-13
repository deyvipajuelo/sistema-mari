<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstanciaJudicialesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instancia_judiciales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idojudicial')->unsigned();
            $table->integer('idljudicial')->unsigned();
            $table->string('nombre',100);
            $table->boolean('condicion')->default(1);
            $table->timestamps();
            $table->foreign('idojudicial')->references('id')->on('organo_judiciales');
            $table->foreign('idljudicial')->references('id')->on('local_judiciales');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('instancia_judiciales');
    }
}
