<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEscuderiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('escuderias', function (Blueprint $table) {
            $table->string('cod_escuderia');
            $table->text('nom_escuderia');
            $table->integer('img_escuderia')->unsigned();

            $table->primary('cod_escuderia');
            $table->foreign('img_escuderia')->references('id')->on('images');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('escuderias');
    }
}
