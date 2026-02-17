<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCorrederaRequest extends FormRequest
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
            'nombre' => 'required|string|max:255|unique:correderas,nombre',
            'capacidad_carga' => 'required|integer|min:1',
            'tipo' => 'required|in:PARCIAL,TOTAL,TOTAL_TIP_ON',
            'incluye_varilla' => 'required|boolean',
            'precio_base' => 'required|numeric|min:0',
            'precio_con_acoplamiento' => 'required|numeric|min:0',
        ];
    }
}
