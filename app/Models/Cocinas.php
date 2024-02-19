<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cocinas extends Model
{
    protected $table = 'Tipo_Cocina';

    public function restaurantes()
    {
        return $this->belongsToMany(Restaurante::class, 'Restaurante_Tipo_Cocina', 'TipoCocinaID', 'RestauranteID');
    }
}
