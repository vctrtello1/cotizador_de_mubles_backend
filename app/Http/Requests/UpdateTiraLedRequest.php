<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTiraLedRequest extends FormRequest
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
            'codigo' => ['sometimes', 'string', 'unique:tira_leds,codigo,' . $this->route('tira_led')],
            'descripcion' => ['nullable', 'string'],
            'precio_unitario' => ['sometimes', 'numeric', 'min:0.01'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es requerido.',
            'codigo.unique' => 'El código ya existe.',
            'precio_unitario.min' => 'El precio debe ser mayor a 0.',
        ];
    }
}
