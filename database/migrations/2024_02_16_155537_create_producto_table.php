<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlatosTable extends Migration
{
    public function up()
    {
        Schema::create('tbl_platos', function (Blueprint $table) {
            $table->id();
            $table->string('Nombre', 100);
            $table->string('Imagen', 255);
            $table->text('Descripcion');
            $table->decimal('Precio', 8, 2);
            $table->unsignedBigInteger('RestauranteID');
            $table->foreign('RestauranteID')->references('ID')->on('Restaurantes');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('Productos');
    }
}
