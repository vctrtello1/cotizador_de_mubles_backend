<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMaterialRequest extends FormRequest
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
            'codigo' => ['nullable', 'string'],
            'precio_unitario' => ['required', 'numeric', 'min:0'],
            'unidad_medida' => ['required', 'string'],
            'alto' => ['required', 'numeric', 'min:0'],
            'ancho' => ['required', 'numeric', 'min:0'],
            'largo' => ['required', 'numeric', 'min:0'],
        ];
    }
}
