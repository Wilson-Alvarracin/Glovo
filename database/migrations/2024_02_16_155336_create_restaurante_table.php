<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantesTable extends Migration
{
    public function up()
    {
        Schema::create('tbl_restaurantes', function (Blueprint $table) {
            $table->id();
            $table->string('Nombre', 100);
            $table->string('Imagen', 255);
            $table->string('Direccion', 255);
            $table->time('HorarioApertura');
            $table->time('HorarioCierre');
            $table->decimal('CalificacionPromedio', 3, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('Restaurantes');
    }
}
