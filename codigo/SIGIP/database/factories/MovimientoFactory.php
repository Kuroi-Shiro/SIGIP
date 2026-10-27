<?php

namespace Database\Factories;

use App\Models\Movimiento;
use App\Models\Producto;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Movimiento>
 */
class MovimientoFactory extends Factory
{

    protected $model = Movimiento::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'producto_id' => Producto::inRandomOrder()->first()?->id ?? Producto::factory(),
            'usuario_id' => Usuario::inRandomOrder()->first()?->id ?? Usuario::factory(),
            'tipo' => fake()->randomElement(['entrada', 'salida']),
            'cantidad' => fake()->numberBetween(1, 100),
            'estado' => fake()->randomElement(['activo', 'cancelado']),
            'observaciones' => fake()->optional()->sentence(),
            'fecha_movimiento' => fake()->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
