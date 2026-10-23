<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Entrega extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'cliente',
        'telefono_cliente',
        'destino',
        'estado',
        'fecha_entrega',
        'observaciones',
    ];

    protected function casts(): array
    {
        return [
            'fecha_entrega' => 'datetime',
        ];
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class);
    }
    public function productos(): BelongsToMany
    {
        return $this->belongsToMany(
            Producto::class,
            'entrega_producto'
        )
            ->withPivot('cantidad')
            ->withTimestamps();
    }
}