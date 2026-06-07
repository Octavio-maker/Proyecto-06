<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Support\Str;

class CategoriaProductoSeeder extends Seeder
{
    public function run(): void
    {
        $nombresCategorias = ['Electrónica', 'Ropa', 'Hogar', 'Deportes'];

        foreach ($nombresCategorias as $nombre) {
            // Usamos updateOrCreate para evitar el error de duplicado en el slug
            $cat = Categoria::updateOrCreate(
                ['slug' => Str::slug($nombre)], // Condición de búsqueda
                ['nombre' => $nombre]           // Datos a asegurar
            );

            // Creamos 5 productos para esta categoría
            Producto::factory(5)->create(['categoria_id' => $cat->id]);
        }
    }
}