<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFuentesDeAlimentacionRequest extends FormRequest
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
            'nombre' => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('fuentes_de_alimentacion', 'nombre')->ignore($this->route('fuentes_de_alimentacion')),
            ],
            'precio' => ['sometimes', 'numeric', 'min:0'],
            'unidades_por_metro' => ['sometimes', 'integer', 'min:1'],
            'porcentaje_utilizacion' => ['sometimes', 'numeric', 'min:0', 'max:100'],
        ];
    }
}
