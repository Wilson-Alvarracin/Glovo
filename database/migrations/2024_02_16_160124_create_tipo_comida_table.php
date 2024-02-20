<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoCocinaTable extends Migration
{
    public function up()
    {
        Schema::create('tbl_tipo_cocina', function (Blueprint $table) {
            $table->id();
            $table->string('Nombre', 100);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('Tipo_Cocina');
    }
}
