<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePuertaRequest extends FormRequest
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
        $puerta = $this->route('puerta');
        
        return [
            'nombre' => [
                'sometimes',
                'string',
                Rule::unique('puertas', 'nombre')->ignore($puerta),
            ],
            'precio_perfil_aluminio' => 'sometimes|numeric|min:0',
            'precio_escuadras' => 'sometimes|numeric|min:0',
            'precio_silicon' => 'sometimes|numeric|min:0',
            'precio_cristal_m2' => 'sometimes|numeric|min:0',
            'alto_maximo' => 'sometimes|numeric|min:0|max:10',
            'ancho_maximo' => 'sometimes|numeric|min:0|max:5',
        ];
    }
}
