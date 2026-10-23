<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Movimiento extends Model
{
    use HasFactory;

    protected $fillable = [
        'producto_id',
        'usuario_id',
        'tipo',
        'cantidad',
        'estado',
        'observaciones',
        'fecha_movimiento',
    ];

    protected function casts(): array
    {
        return [
            'cantidad' => 'integer',
            'fecha_movimiento' => 'datetime',
        ];
    }

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class);
    }
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class);
    }
}