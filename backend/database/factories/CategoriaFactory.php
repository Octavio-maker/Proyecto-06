<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoriaFactory extends Factory
{
    public function definition(): array
    {
        $nombre = $this->faker->word();

        return [
            'nombre' => $nombre,
            'slug'   => Str::slug($nombre . '-' . $this->faker->randomNumber(4)),
        ];
    }
}