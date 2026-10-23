<?php

namespace Database\Factories;

use App\Models\Proveedor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Proveedor>
 */
class ProveedorFactory extends Factory
{

    protected $model = Proveedor::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'nombre' => fake()->company(),
            'telefono' => fake()->numerify('###-###-####'),
            'email' => fake()->unique()->safeEmail(),
            'direccion' => fake()->address(),
            'activo' => fake()->boolean(90),
        ];
    }
}
