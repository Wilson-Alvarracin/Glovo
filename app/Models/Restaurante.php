<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurante extends Model
{
    // protected $table = 'Restaurantes';

    public function productos()
    {
        return $this->hasMany(Platos::class, 'RestauranteID', 'ID');
    }

    public function valoraciones()
    {
        return $this->hasMany(Valoracion::class, 'RestauranteID', 'ID');
    }

    public function tiposCocina()
    {
        return $this->belongsToMany(Cocinas::class, 'Restaurante_Tipo_Cocina', 'RestauranteID', 'TipoCocinaID');
    }
}