<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

class StoreMaterialesPorComponenteRequest extends FormRequest
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
            'material_id' => [
                'required',
                'exists:materiales,id',
                Rule::unique('materiales_por_componente')->where(function ($query) {
                    return $query->where('componente_id', $this->componente_id);
                }),
            ],
            'cantidad' => ['required', 'integer', 'min:1'],
        ];
    }
}
