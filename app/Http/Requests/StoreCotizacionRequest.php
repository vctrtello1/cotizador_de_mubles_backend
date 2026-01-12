<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCotizacionRequest extends FormRequest
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
            'cliente_id' => 'required|exists:clientes,id',
            'fecha' => 'required|date',
            'total' => 'required|numeric|min:0',
            'detalles' => 'nullable|array',
            'detalles.*.modulo_id' => 'nullable|integer|exists:modulos,id',
            'detalles.*.descripcion' => 'nullable|string',
            'detalles.*.cantidad' => 'nullable|integer|min:1',
            'detalles.*.precio_unitario' => 'nullable|numeric|min:0',
            'detalles.*.subtotal' => 'nullable|numeric|min:0',
            'modulos_cantidad' => 'nullable|array',
            'modulos_cantidad.*.modulo_id' => 'nullable|integer|exists:modulos,id',
            'modulos_cantidad.*.cantidad' => 'nullable|integer|min:1',
            'modulos_cantidad.*.index' => 'nullable|integer',
        ];
    }
}
