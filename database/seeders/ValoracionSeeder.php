<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ValoracionesSeeder extends Seeder
{
    public function run()
    {
        DB::table('Valoraciones')->insert([
            'RestauranteID' => 1, // ID del restaurante al que se realiza la valoración
            'UsuarioID' => 1, // ID del usuario que realiza la valoración
            'Calificacion' => 4,
            'Comentario' => 'Comida muy mala y encima fria',
        ]);

        // Puedes agregar más valoraciones aquí si lo deseas
    }
}
