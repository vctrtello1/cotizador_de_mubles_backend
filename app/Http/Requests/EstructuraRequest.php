<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EstructuraRequest extends FormRequest
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
        $estructuraId = $this->route('estructura');
        
        return [
            'nombre' => [
                'required',
                'string',
                'max:255',
                Rule::unique('estructura', 'nombre')->ignore($estructuraId),
            ],
            'costo_unitario' => ['required', 'numeric', 'min:0'],
        ];
    }
}
