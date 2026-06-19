<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreKomponenGajiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'honor_per_jam' => 'required|numeric|min:0',
            'honor_per_hadir' => 'nullable|numeric|min:0',
            'transport' => 'required|numeric|min:0',
            'bpjs' => 'required|numeric|min:0',
            'potongan_lain' => 'nullable|numeric|min:0',
        ];
    }
}
