<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCompasAbatibleRequest extends FormRequest
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
        $compasAbatible = $this->route('compasAbatible');
        
        return [
            'nombre' => [
                'sometimes',
                'string',
                Rule::unique('compases_abatibles', 'nombre')->ignore($compasAbatible),
            ],
            'precio' => 'sometimes|numeric|min:0',
        ];
    }
}
