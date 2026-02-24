<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAccesoriosPorComponenteRequest extends FormRequest
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

        if (!$this->has('cantidad')) {
            $this->merge(['cantidad' => 1]);
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
            'componente_id' => ['required', 'exists:componentes,id'],
            'accesorio' => ['required_without:accesorio_id', 'string', 'max:255'],
            'accesorio_id' => ['required_without:accesorio', 'integer', 'exists:accesorios,id'],
            'cantidad' => ['required', 'integer', 'min:1'],
        ];
    }
}
