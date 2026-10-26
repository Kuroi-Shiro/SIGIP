<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuardarProveedorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }



    protected function prepareForValidation(): void
    {
        $this->merge([
            'nombre' => trim((string) $this->nombre),
            'telefono' => trim((string) $this->telefono),
            'email' => trim((string) $this->email),
            'direccion' => trim((string) $this->direccion),
        ]);
    }



    public function rules(): array
    {
        return [
            'nombre' => [
                'required',
                'string',
                'max:255',
            ],

            'telefono' => [
                'required',
                'string',
                'max:20',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
            ],

            'direccion' => [
                'required',
                'string',
                'max:255',
            ],

            'producto_ids' => [
                'required',
                'array',
                'min:1',
            ],

            'producto_ids.*' => [
                'integer',
                'distinct',
                'exists:productos,id',
            ],
        ];
    }

    

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del proveedor es obligatorio.',
            'nombre.string' => 'El nombre del proveedor debe ser texto.',
            'nombre.max' => 'El nombre no puede exceder los 255 caracteres.',

            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.string' => 'El teléfono debe ser texto.',
            'telefono.max' => 'El teléfono no puede exceder los 20 caracteres.',

            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico no tiene un formato válido.',
            'email.max' => 'El correo electrónico no puede exceder los 255 caracteres.',

            'direccion.required' => 'La dirección es obligatoria.',
            'direccion.string' => 'La dirección debe ser texto.',
            'direccion.max' => 'La dirección no puede exceder los 255 caracteres.',

            'producto_ids.required' => 'Debe seleccionar al menos un producto.',
            'producto_ids.array' => 'Los productos seleccionados no son válidos.',
            'producto_ids.min' => 'Debe seleccionar al menos un producto.',

            'producto_ids.*.integer' => 'El producto seleccionado no es válido.',
            'producto_ids.*.distinct' => 'No puede seleccionar el mismo producto más de una vez.',
            'producto_ids.*.exists' => 'Uno de los productos seleccionados no existe.',
        ];
    }
}