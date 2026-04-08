<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTiraLedRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:255'],
            'codigo' => ['required', 'string', 'unique:tira_leds'],
            'descripcion' => ['nullable', 'string'],
            'precio_unitario' => ['required', 'numeric', 'min:0.01'],
            'unidades_por_metro' => ['nullable', 'integer', 'min:1'],
            'porcentaje_utilizacion' => ['nullable', 'numeric', 'min:0.001'],
            'cantidad_compra' => ['nullable', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es requerido.',
            'codigo.required' => 'El código es requerido.',
            'codigo.unique' => 'El código ya existe.',
            'precio_unitario.required' => 'El precio unitario es requerido.',
            'precio_unitario.min' => 'El precio debe ser mayor a 0.',
        ];
    }
}
