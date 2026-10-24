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
        //
        Usuario::create([
            'nombre' => 'Admin SIGIP',
            'email' => 'admin@sigip.com',
            'password' => Hash::make('password1237'),
            'rol' => 'admin',
            'activo' => true,
        ]);

        //usuarios de prueba
        Usuario::factory(10)->create();

    }
}
