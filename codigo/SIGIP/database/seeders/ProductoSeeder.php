<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Producto;
use App\Models\Proveedor;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $proveedores = Proveedor::all();

        Producto::factory(50)->create()->each(function ($producto) use ($proveedores) {
            $proveedoresAlAzar = $proveedores->random(rand(1, 3))->pluck('id')->toArray();
            $producto->proveedores()->attach($proveedoresAlAzar);
        });
    }
}
