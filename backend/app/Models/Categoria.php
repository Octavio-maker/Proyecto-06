<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // 1. Importación necesaria
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    use HasFactory; // 2. Declaración del trait

    protected $fillable = ['nombre', 'slug', 'descripcion'];

    public function productos(): HasMany
    {
        return $this->hasMany(Producto::class);
    }
}