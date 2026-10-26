<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ActualizarProductoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }



    protected function prepareForValidation(): void
    {
        $this->merge([
            'codigo' => trim((string) $this->codigo),
            'nombre' => trim((string) $this->nombre),
            'descripcion' => trim((string) $this->descripcion),
        ]);
    }



    public function rules(): array
    {
        return [
            'categoria_id' => [
                'required',
                'integer',
                'exists:categorias,id',
            ],

            'codigo' => [
                'required',
                'string',
                'max:255',
                Rule::unique('productos', 'codigo')
                    ->ignore($this->route('producto')),
            ],

            'nombre' => [
                'required',
                'string',
                'max:255',
            ],

            'descripcion' => [
                'required',
                'string',
            ],

            'precio' => [
                'required',
                'numeric',
                'min:0',
            ],

            'stock_actual' => [
                'required',
                'integer',
                'min:0',
            ],

            'stock_minimo' => [
                'required',
                'integer',
                'min:0',
            ],

            'imagen' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:2048',
            ],
        ];
    }

    

    public function messages(): array
    {
        return [
            'categoria_id.required' => 'La categoría es obligatoria.',
            'categoria_id.integer' => 'La categoría seleccionada no es válida.',
            'categoria_id.exists' => 'La categoría seleccionada no existe.',

            'codigo.required' => 'El código del producto es obligatorio.',
            'codigo.string' => 'El código debe ser texto.',
            'codigo.max' => 'El código no puede exceder los 255 caracteres.',
            'codigo.unique' => 'El código ya se encuentra registrado.',

            'nombre.required' => 'El nombre del producto es obligatorio.',
            'nombre.string' => 'El nombre debe ser texto.',
            'nombre.max' => 'El nombre no puede exceder los 255 caracteres.',

            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.string' => 'La descripción debe ser texto.',

            'precio.required' => 'El precio es obligatorio.',
            'precio.numeric' => 'El precio debe ser un valor numérico.',
            'precio.min' => 'El precio no puede ser negativo.',

            'stock_actual.required' => 'El stock actual es obligatorio.',
            'stock_actual.integer' => 'El stock actual debe ser un número entero.',
            'stock_actual.min' => 'El stock actual no puede ser negativo.',

            'stock_minimo.required' => 'El stock mínimo es obligatorio.',
            'stock_minimo.integer' => 'El stock mínimo debe ser un número entero.',
            'stock_minimo.min' => 'El stock mínimo no puede ser negativo.',

            'imagen.image' => 'El archivo debe ser una imagen.',
            'imagen.mimes' => 'La imagen debe ser JPG, JPEG, PNG o WebP.',
            'imagen.max' => 'La imagen no puede superar los 2 MB.',
        ];
    }
}