<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductosSeeder extends Seeder
{
    public function run()
    {
        DB::table('Productos')->insert([
            'Nombre' => 'Macarrones',
            'Imagen' => '../img/macarrones.jpg',
            'Descripcion' => 'Delicioso macarrones de Luca Lusuardi con bechamel',
            'Precio' => 10.99,
            'RestauranteID' => 1, // ID del restaurante al que pertenece este producto
        ]);

        // Puedes agregar más productos aquí si lo deseas
    }
} 
