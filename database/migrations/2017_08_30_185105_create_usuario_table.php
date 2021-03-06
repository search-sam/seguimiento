<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->increments('id_usuario');
            $table->string('nombre_usuario');
            $table->string('apellido_usuario');
            $table->string('email_usuario')->unique();
            $table->string('contrasena');
            $table->boolean('estado_usuario');
            $table->string('fecha_registro');
            $table->string('foto_usuario');
            $table->integer('tipo_usuario_id')->unsigned();
            $table->timestamps();

            $table->foreign('tipo_usuario_id')->references('id_tipo_usuario')->on('tipo_usuario')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuario');
    }
}
