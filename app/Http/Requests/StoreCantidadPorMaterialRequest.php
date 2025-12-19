<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCantidadPorMaterialRequest extends FormRequest
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
            'componente_id' => ['required', 'exists:componentes,id'],
            'material_id' => ['required', 'exists:materiales,id'],
            'cantidad' => ['required', 'integer', 'min:1'],
        ];
    }
}
