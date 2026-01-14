<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HorasDeManoDeObraPorComponenteRequest extends FormRequest
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
        $method = $this->method();

        if ($method === 'POST') {
            return [
                'componente_id' => 'required|integer|exists:componentes,id',
                'mano_de_obra_id' => 'required|integer|exists:mano_de_obras,id',
                'horas' => 'required|integer|min:1|max:24',
            ];
        }

        return [
            'componente_id' => 'sometimes|integer|exists:componentes,id',
            'mano_de_obra_id' => 'sometimes|integer|exists:mano_de_obras,id',
            'horas' => 'sometimes|integer|min:1|max:24',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'componente_id.required' => 'El componente es requerido.',
            'componente_id.exists' => 'El componente seleccionado no existe.',
            'mano_de_obra_id.required' => 'La mano de obra es requerida.',
            'mano_de_obra_id.exists' => 'La mano de obra seleccionada no existe.',
            'horas.required' => 'Las horas son requeridas.',
            'horas.min' => 'Las horas deben ser mayor que 0.',
            'horas.max' => 'Las horas no pueden exceder 24.',
        ];
    }
}
