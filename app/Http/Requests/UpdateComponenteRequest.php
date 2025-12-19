<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateComponenteRequest extends FormRequest
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
            'codigo' => 'required|string|max:255|unique:componentes,codigo,' . $this->route('componente')->id,
            'accesorios' => 'nullable|string',
            'acabado_id' => 'required|exists:acabados,id',
            'mano_de_obra_id' => 'required|exists:mano_de_obras,id',            'materiales' => 'nullable|array',
            'materiales.*.id' => 'required|exists:materiales,id',
            'materiales.*.cantidad' => 'required|integer|min:1',
            'herrajes' => 'nullable|array',
            'herrajes.*.id' => 'required|exists:herrajes,id',
            'herrajes.*.cantidad' => 'required|integer|min:1',        ];
    }
}
