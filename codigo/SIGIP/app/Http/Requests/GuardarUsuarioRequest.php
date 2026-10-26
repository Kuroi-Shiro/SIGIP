<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuardarUsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }



    protected function prepareForValidation(): void
    {
        $this->merge([
            'nombre' => trim((string) $this->nombre),
            'email' => strtolower(trim((string) $this->email)),
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

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:usuarios,email',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],

            'rol' => [
                'required',
                'in:Administrador,Empleado',
            ],
        ];
    }

    

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del usuario es obligatorio.',
            'nombre.string' => 'El nombre debe ser texto.',
            'nombre.max' => 'El nombre no puede exceder los 255 caracteres.',

            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico no tiene un formato válido.',
            'email.max' => 'El correo electrónico no puede exceder los 255 caracteres.',
            'email.unique' => 'El correo ya se encuentra registrado.',

            'password.required' => 'La contraseña es obligatoria.',
            'password.string' => 'La contraseña no es válida.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',

            'rol.required' => 'El rol es obligatorio.',
            'rol.in' => 'El rol debe ser Administrador o Empleado.',
        ];
    }
}