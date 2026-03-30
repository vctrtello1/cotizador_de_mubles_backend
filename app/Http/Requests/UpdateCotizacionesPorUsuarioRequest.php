<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCotizacionesPorUsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id'       => 'sometimes|required|integer|exists:users,id',
            'cotizacion_id' => 'sometimes|required|integer|exists:cotizaciones,id',
        ];
    }
}
