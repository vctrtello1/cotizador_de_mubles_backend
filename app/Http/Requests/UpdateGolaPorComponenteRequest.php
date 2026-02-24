<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGolaPorComponenteRequest extends FormRequest
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
            'componente_id' => ['sometimes', 'exists:componentes,id'],
            'gola_id' => ['sometimes', 'exists:table_gola,id'],
            'cantidad' => ['sometimes', 'integer', 'min:1'],
        ];
    }
}
