<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    // protected $table = 'Usuarios';

    public function valoraciones()
    {
        return $this->hasMany(Valoracion::class, 'UsuarioID', 'ID');
    }
}