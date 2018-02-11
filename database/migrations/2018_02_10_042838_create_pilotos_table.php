<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePilotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pilotos', function (Blueprint $table) {
            $table->string('doc_piloto');
            $table->text('nom_piloto');
            $table->string('cod_escuderia');
            $table->dateTime('fec_nacimiento');
            $table->integer('img_piloto')->unsigned();

            $table->primary('doc_piloto');
            $table->foreign('cod_escuderia')->references('cod_escuderia')->on('escuderias');
            $table->foreign('img_piloto')->references('id')->on('images');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pilotos');
    }
}
