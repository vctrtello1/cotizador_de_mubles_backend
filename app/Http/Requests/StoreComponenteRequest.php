<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreComponenteRequest extends FormRequest
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
            //
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'codigo' => 'required|string|max:255|unique:componentes,codigo',
            'accesorios' => 'nullable|string',
            'materiales' => 'nullable|array',
            'materiales.*.id' => 'required|exists:materiales,id',
            'materiales.*.cantidad' => 'required|integer|min:1',
            'herrajes' => 'nullable|array',
            'herrajes.*.id' => 'required|exists:herrajes,id',
            'herrajes.*.cantidad' => 'required|integer|min:1',        ];
    }
}
