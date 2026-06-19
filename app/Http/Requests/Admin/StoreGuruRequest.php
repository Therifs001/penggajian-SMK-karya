<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreGuruRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'nip' => 'required|string|max:255|unique:users,nip',
            'matapelajaran' => 'nullable|string|max:255',
            'matapelajaran_custom' => 'nullable|string|max:500',
            'status' => 'required|string|max:255',
                'subjects' => 'array',
                'subjects.*' => 'nullable',
            'email' => 'required|email|max:255|unique:users,email',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:500',
            'password' => 'nullable|string|min:8|confirmed',
        ];
    }
}
