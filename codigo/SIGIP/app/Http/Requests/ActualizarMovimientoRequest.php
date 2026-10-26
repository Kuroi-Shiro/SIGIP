<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ActualizarMovimientoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }



    public function rules(): array
    {
        return [
            'producto_id' => [
                'required',
                'integer',
                Rule::exists('productos', 'id')
                    ->where('activo', true),
            ],

            'tipo' => [
                'required',
                'in:entrada,salida',
            ],

            'cantidad' => [
                'required',
                'integer',
                'min:1',
            ],

            'observaciones' => [
                'nullable',
                'string',
            ],

            'fecha_movimiento' => [
                'required',
                'date',
            ],
        ];
    }

    

    public function messages(): array
    {
        return [
            'producto_id.required' => 'Debe seleccionar un producto.',
            'producto_id.integer' => 'El producto seleccionado no es válido.',
            'producto_id.exists' => 'El producto seleccionado no existe o se encuentra archivado.',

            'tipo.required' => 'El tipo de movimiento es obligatorio.',
            'tipo.in' => 'El tipo de movimiento debe ser entrada o salida.',

            'cantidad.required' => 'La cantidad es obligatoria.',
            'cantidad.integer' => 'La cantidad debe ser un número entero.',
            'cantidad.min' => 'La cantidad debe ser mayor a cero.',

            'observaciones.string' => 'Las observaciones deben ser texto.',

            'fecha_movimiento.required' => 'La fecha del movimiento es obligatoria.',
            'fecha_movimiento.date' => 'La fecha del movimiento no es válida.',
        ];
    }
}