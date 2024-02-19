<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Valoracion extends Model
{
    protected $table = 'Valoraciones';

    public function restaurante()
    {
        return $this->belongsTo(Restaurante::class, 'RestauranteID', 'ID');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'UsuarioID', 'ID');
    }
}
