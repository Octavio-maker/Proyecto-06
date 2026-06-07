<?php

namespace Database\Factories;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    // database/factories/ProductoFactory.php
    public function definition(): array{
    return [
        'nombre' => $this->faker->word,
        'descripcion' => $this->faker->sentence,
        'precio' => $this->faker->randomFloat(2, 10, 1000),
        'stock' => $this->faker->numberBetween(1, 100),
        'imagen' => 'default.jpg',
        'categoria_id' => \App\Models\Categoria::inRandomOrder()->first()->id,
    ];
}
}
