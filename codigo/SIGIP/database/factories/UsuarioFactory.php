<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<Usuario>
 */
class UsuarioFactory extends Factory
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
            'nombre' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password1237'),
            'rol' => fake()->randomElement(['admin', 'user']),
            'activo' => fake()->boolean(90),
        ];
    }
}
