<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApagadoresRequest extends FormRequest
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
            'nombre' => 'required|string|unique:apagadores,nombre',
            'precio' => 'required|numeric|min:0',
            'unidades_por_metro' => 'required|integer|min:1',
            'porcentaje_utilizacion' => 'required|numeric|min:0|max:100',
        ];
    }
}
