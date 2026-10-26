<?php

namespace App\Http\Requests;

use App\Models\Producto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class GuardarEntregaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }



    protected function prepareForValidation(): void
    {
        $this->merge([
            'cliente' => trim((string) $this->cliente),
            'telefono_cliente' => trim((string) $this->telefono_cliente),
            'destino' => trim((string) $this->destino),
            'observaciones' => $this->observaciones !== null
                ? trim((string) $this->observaciones)
                : null,
        ]);
    }



    public function rules(): array
    {
        return [
            'usuario_id' => [
                'required',
                'integer',
                Rule::exists('usuarios', 'id')
                    ->where('activo', true),
            ],

            'cliente' => [
                'required',
                'string',
                'max:255',
            ],

            'telefono_cliente' => [
                'required',
                'string',
                'max:20',
            ],

            'destino' => [
                'required',
                'string',
                'max:255',
            ],

            'estado' => [
                'required',
                'in:pendiente,completado,cancelado',
            ],

            'fecha_entrega' => [
                'required',
                'date',
            ],

            'observaciones' => [
                'nullable',
                'string',
            ],

            'productos' => [
                'required',
                'array',
                'min:1',
            ],

            'productos.*.producto_id' => [
                'required',
                'integer',
                'distinct',
                Rule::exists('productos', 'id')
                    ->where('activo', true),
            ],

            'productos.*.cantidad' => [
                'required',
                'integer',
                'min:1',
            ],
        ];
    }



    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if ($validator->errors()->count() > 0) {
                return;
            }

            foreach ($this->input('productos', []) as $indice => $item) {
                $producto = Producto::find($item['producto_id']);

                if (
                    $producto &&
                    $item['cantidad'] > $producto->stock_actual
                ) {
                    $validator->errors()->add(
                        "productos.$indice.cantidad",
                        "Existencia insuficiente del producto {$producto->nombre}."
                    );
                }
            }
        });
    }

    

    public function messages(): array
    {
        return [
            'usuario_id.required' => 'El usuario es obligatorio.',
            'usuario_id.exists' => 'El usuario no existe o se encuentra archivado.',

            'cliente.required' => 'El nombre del cliente es obligatorio.',
            'cliente.string' => 'El nombre del cliente debe ser texto.',
            'cliente.max' => 'El nombre del cliente no puede exceder los 255 caracteres.',

            'telefono_cliente.required' => 'El teléfono del cliente es obligatorio.',
            'telefono_cliente.string' => 'El teléfono debe ser texto.',
            'telefono_cliente.max' => 'El teléfono no puede exceder los 20 caracteres.',

            'destino.required' => 'El destino de la entrega es obligatorio.',
            'destino.string' => 'El destino debe ser texto.',
            'destino.max' => 'El destino no puede exceder los 255 caracteres.',

            'estado.required' => 'El estado de la entrega es obligatorio.',
            'estado.in' => 'El estado debe ser pendiente, completado o cancelado.',

            'fecha_entrega.required' => 'La fecha de entrega es obligatoria.',
            'fecha_entrega.date' => 'La fecha de entrega no es válida.',

            'observaciones.string' => 'Las observaciones deben ser texto.',

            'productos.required' => 'Debe seleccionar al menos un producto.',
            'productos.array' => 'Los productos seleccionados no son válidos.',
            'productos.min' => 'Debe seleccionar al menos un producto.',

            'productos.*.producto_id.required' => 'Debe seleccionar un producto.',
            'productos.*.producto_id.integer' => 'El producto seleccionado no es válido.',
            'productos.*.producto_id.distinct' => 'No puede seleccionar el mismo producto más de una vez.',
            'productos.*.producto_id.exists' => 'El producto seleccionado no existe o se encuentra archivado.',

            'productos.*.cantidad.required' => 'La cantidad es obligatoria.',
            'productos.*.cantidad.integer' => 'La cantidad debe ser un número entero.',
            'productos.*.cantidad.min' => 'La cantidad debe ser mayor a cero.',
        ];
    }
}