<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Usuarios extends Migration
{
    public function up()
    {
        Schema::create('Usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('Nombre', 50);
            $table->string('Apellido', 50);
            $table->string('CorreoElectronico', 100);
            $table->string('Contraseña', 255);
            $table->enum('TipoUsuario', ['Administrador', 'Estándar']);
            $table->string('DireccionEntrega', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('Usuarios');
    }
}
