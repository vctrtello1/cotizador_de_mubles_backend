<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePuertaRequest extends FormRequest
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
            'nombre' => 'required|string|unique:puertas,nombre',
            'precio_perfil_aluminio' => 'required|numeric|min:0',
            'precio_escuadras' => 'required|numeric|min:0',
            'precio_silicon' => 'required|numeric|min:0',
            'precio_cristal_m2' => 'required|numeric|min:0',
            'alto_maximo' => 'sometimes|numeric|min:0|max:10',
            'ancho_maximo' => 'sometimes|numeric|min:0|max:5',
        ];
    }
}
