<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Usuario;
use App\Models\Categoria;
use App\Models\Proveedor;
use App\Models\Entrega;
use App\Models\Producto;
use App\Models\Movimiento;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        //no se si se puede borrar o asi se deja
        /*User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);*/

        $this->call([
            UsuarioSeeder::class,
            CategoriaSeeder::class,
            ProveedorSeeder::class,
            ProductoSeeder::class,
            EntregaSeeder::class,
            MovimientoSeeder::class,
        ]);

    }
}
