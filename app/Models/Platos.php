<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Platos extends Model
{
    // protected $table = 'Productos';

    public function restaurante()
    {
        return $this->belongsTo(Restaurante::class, 'RestauranteID', 'ID');
    }
}