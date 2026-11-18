<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Usuario::create([
            'nombre' => 'Admin SIGIP',
            'email' => 'admin@sigip.com',
            'password' => Hash::make('password1237'),
            'rol' => 'Administrador',
            'activo' => true,
        ]);

        Usuario::create([
            'nombre' => 'Usuario Demo',
            'email' => 'usuario@sigip.com',
            'password' => Hash::make('password1237'),
            'rol' => 'Empleado',
            'activo' => true,
        ]);

        // usuarios de prueba
        Usuario::factory(10)->create();
    }
}