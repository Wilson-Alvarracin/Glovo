<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RestaurantesSeeder extends Seeder
{
    public function run()
    {
        DB::table('Restaurantes')->insert([
            'Nombre' => 'NombreRestaurante',
            'Imagen' => 'URLImagen',
            'Direccion' => 'DirecciónRestaurante',
            'HorarioApertura' => '08:00:00', // Ejemplo de horario de apertura
            'HorarioCierre' => '22:00:00', // Ejemplo de horario de cierre
            'CalificacionPromedio' => 4.5,
        ]);

        // Puedes agregar más restaurantes aquí si lo deseas
    }
}
