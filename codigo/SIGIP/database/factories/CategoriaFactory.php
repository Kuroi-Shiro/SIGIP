<?php

namespace Database\Factories;

use App\Models\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Categoria>
 */
class CategoriaFactory extends Factory
{

    protected $model = Categoria::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'nombre' => ucfirst(fake()->unique()->word(2, true)),
            'descripcion' => fake()->optional()->sentence(),
            'activo' => fake()->boolean(80),
        ];
    }
}
