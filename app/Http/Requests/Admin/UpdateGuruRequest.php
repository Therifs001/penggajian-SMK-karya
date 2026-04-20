<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateGuruRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $guruId = $this->route('guru')?->id;

        return [
            'name' => 'required|string|max:255',
            'nip' => ['required', 'string', 'max:255', Rule::unique('users', 'nip')->ignore($guruId)],
            'matapelajaran' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($guruId)],
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:500',
            'password' => 'nullable|string|min:8|confirmed',
        ];
    }
}
