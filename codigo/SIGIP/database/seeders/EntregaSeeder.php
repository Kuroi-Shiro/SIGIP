<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Entrega;
use App\Models\Producto;

class EntregaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $productos = Producto::all();

        Entrega::factory(20)->create()->each(function ($entrega) use ($productos) {
            $productosAlAzar = $productos->random(rand(1, 5));
            
            foreach ($productosAlAzar as $producto) {
                $entrega->productos()->attach($producto->id, ['cantidad' => rand(1, 10)]);
            }
        });
            
    }
}
