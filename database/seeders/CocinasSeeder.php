<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoCocinaSeeder extends Seeder
{
    public function run()
    {
        DB::table('Tipo_Cocina')->insert([
            'Nombre' => 'Española',
        ]);

        // Puedes agregar más tipos de cocina aquí si lo deseas
    }
}
