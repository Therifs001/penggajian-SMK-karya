<?php

namespace App\Http\Requests\Guru;

use Illuminate\Foundation\Http\FormRequest;

class StoreAbsensiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => 'required|in:hadir,izin',
            'alasan' => 'required_if:status,izin|nullable|string|max:500',
            'subjects' => 'array',
            'subjects.*' => 'nullable|exists:subjects,id',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ];
    }
}
