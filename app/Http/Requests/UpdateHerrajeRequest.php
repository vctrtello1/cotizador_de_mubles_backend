<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHerrajeRequest extends FormRequest
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
        $herrajeId = $this->route('herraje') ? $this->route('herraje')->id : null;
        
        return [
            'nombre' => ['sometimes', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'codigo' => ['sometimes', 'string', 'unique:herrajes,codigo,' . $herrajeId],
            'costo_unitario' => ['sometimes', 'numeric', 'min:0'],
            'unidad_medida' => ['sometimes', 'string'],
            'medida' => ['sometimes', 'numeric', 'min:0'],
        ];
    }
}
