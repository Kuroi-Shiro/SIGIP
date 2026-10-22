<?php

namespace Database\Factories;

use App\Models\Entrega;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Entrega>
 */
class EntregaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'usuario_id' => Usuario::inRandomOrder()->first()->id ?? Usuario::factory(),
            'cliente' => $this->faker->name(),
            'telefono_cliente' => fake()->numerify('###-###-####'),
            'destino' => fake()->address(),
            'fecha_entrega' => fake()->dateTimeBetween('-1 month', '+2 weeks'),
            'observaciones' => fake()->optional()->sentence(),
        ];
    }
}
