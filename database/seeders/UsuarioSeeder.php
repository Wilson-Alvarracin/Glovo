<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsuariosSeeder extends Seeder
{
    public function run()
    {
        DB::table('Usuarios')->insert([
            'Nombre' => 'NombreUsuario',
            'Apellido' => 'ApellidoUsuario',
            'CorreoElectronico' => 'usuario@example.com',
            'Contraseña' => bcrypt('contraseña'),
            'TipoUsuario' => 'Estándar',
            'DireccionEntrega' => 'Dirección de entrega del usuario',
        ]);

        // Puedes agregar más usuarios aquí si lo deseas
    }
}
