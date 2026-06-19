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
            'jam_mengajar' => 'required|numeric|min:0',
            'kehadiran' => 'nullable|integer|min:0',
            'subject_id' => 'nullable|exists:subjects,id',
        ];
    }
}
