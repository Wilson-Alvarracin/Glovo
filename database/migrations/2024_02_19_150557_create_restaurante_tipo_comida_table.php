<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestauranteTipoCocinaTable extends Migration
{
    public function up()
    {
        Schema::create('Restaurante_Tipo_Cocina', function (Blueprint $table) {
            $table->unsignedBigInteger('RestauranteID');
            $table->foreign('RestauranteID')->references('ID')->on('Restaurantes');
            $table->unsignedBigInteger('TipoCocinaID');
            $table->foreign('TipoCocinaID')->references('ID')->on('Tipo_Cocina');
            $table->primary(['RestauranteID', 'TipoCocinaID']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('Restaurante_Tipo_Cocina');
    }
}
