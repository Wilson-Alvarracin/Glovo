<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RestauranteTipoCocinaSeeder extends Seeder
{
    public function run()
    {
        DB::table('Restaurante_Tipo_Cocina')->insert([
            'RestauranteID' => 1, // ID del restaurante
            'TipoCocinaID' => 1, // ID del tipo de cocina
        ]);

        // Puedes agregar más relaciones restaurante-tipo de cocina aquí si lo deseas
    }
}
