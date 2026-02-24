<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAccesoriosPorComponenteRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        if (is_array($this->accesorio)) {
            if (array_key_exists('id', $this->accesorio)) {
                $this->merge(['accesorio_id' => $this->accesorio['id']]);
            }

            if (array_key_exists('nombre', $this->accesorio)) {
                $this->merge(['accesorio' => $this->accesorio['nombre']]);
            }
        }
    }

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
            'accesorio' => ['sometimes', 'string', 'max:255'],
            'accesorio_id' => ['sometimes', 'integer', 'exists:accesorios,id'],
            'cantidad' => ['sometimes', 'integer', 'min:1'],
        ];
    }
}
