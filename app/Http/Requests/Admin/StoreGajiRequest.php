<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreGajiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'periode' => 'required|string|date_format:Y-m',
            'jam_mengajar' => 'required|numeric|min:0',
        ];
    }
}
