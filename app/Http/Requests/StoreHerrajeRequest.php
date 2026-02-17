<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHerrajeRequest extends FormRequest
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
            'descripcion' => ['nullable', 'string'],
            'codigo' => ['required', 'string', 'unique:herrajes,codigo'],
            'costo_unitario' => ['required', 'numeric', 'min:0'],
            'unidad_medida' => ['required', 'string'],
            'medida' => ['required', 'numeric', 'min:0'],
        ];
    }
}
