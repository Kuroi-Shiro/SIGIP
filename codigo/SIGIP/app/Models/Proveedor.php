<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Proveedor extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'telefono',
        'email',
        'direcion',
        'activo',
    ];


    protected function casts(): array
    {
        return [
            'activo' => 'boolean',
        ];
    }

    public function productos(): BelongsToMany
    {
        return $this->belongsToMany(
            Producto::class,
            'proveedor_producto'
        )->withTimestamps();

    }
}