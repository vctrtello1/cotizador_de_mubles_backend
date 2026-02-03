<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AcabadoTableroRequest extends FormRequest
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
        $acabadoTableroId = $this->route('acabado_tablero');
        
        return [
            'nombre' => [
                'required',
                'string',
                'max:255',
                Rule::unique('acabado_tableros', 'nombre')->ignore($acabadoTableroId),
            ],
            'costo_unitario' => ['required', 'numeric', 'min:0'],
        ];
    }
}
