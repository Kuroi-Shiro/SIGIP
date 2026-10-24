<?php

namespace Database\Factories;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Producto>
 */
class ProductoFactory extends Factory
{

    protected $model = Producto::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'categoria_id' => Categoria::inRandomOrder()->first()?->id ?? Categoria::factory(),
            'codigo' => strtoupper(fake()->unique()->bothify('PROD-#####')),
            'nombre' => ucfirst(fake()->unique()->words(3, true)),
            'descripcion' => fake()->optional()->paragraph(),
            'imagen' => fake()->optional()->imageUrl(640, 480, 'products', true),
            'precio' => fake()->randomFloat(2, 100, 25000),
            'stock_actual' => fake()->numberBetween(0, 100),
            'stock_minimo' => fake()->numberBetween(0, 20),
            'activo' => fake()->boolean(80),
        ];
    }
}
