<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleCarrerasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_carreras', function (Blueprint $table) {
            $table->string('seq_carrera');
            $table->integer('nro_carrera');
            $table->string('doc_piloto');
            $table->integer('pos_salida');
            $table->integer('pos_final');
            $table->integer('vueltas');

            $table->primary('seq_carrera');
            $table->foreign('nro_carrera')->references('nro_carrera')->on('carreras');
            $table->foreign('doc_piloto')->references('doc_piloto')->on('pilotos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalle_carreras');
    }
}
