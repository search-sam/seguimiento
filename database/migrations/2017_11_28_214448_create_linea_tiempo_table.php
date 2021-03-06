<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLineaTiempoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('linea_tiempo', function (Blueprint $table) {
            $table->increments('id_linea_tiempo');
            $table->integer('tipo_evento_id')->unsigned();
            $table->integer('usuario_id')->unsigned();
            $table->timestamps();

            $table->foreign('usuario_id')->references('id_usuario')->on('usuario')->onDelete('cascade');
            $table->foreign('tipo_evento_id')->references('id_tipo_evento')->on('tipo_evento')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('linea_tiempo');
    }
}
