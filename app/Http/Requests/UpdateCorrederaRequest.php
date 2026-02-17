<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCorrederaRequest extends FormRequest
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
            'nombre' => 'sometimes|string|max:255|unique:correderas,nombre,' . $this->route('corredera')->id,
            'precio_base' => 'sometimes|numeric|min:0',
            'precio_con_acoplamiento' => 'sometimes|numeric|min:0',
        ];
    }
}
