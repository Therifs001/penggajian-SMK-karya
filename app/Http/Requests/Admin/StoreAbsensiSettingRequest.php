<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreAbsensiSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'batas_absen' => 'required|date_format:H:i|after_or_equal:jam_mulai',
            'tanggal' => 'nullable|date',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'radius_meter' => 'required|integer|min:50',
            'active' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'jam_mulai.required' => 'Field jam mulai wajib diisi.',
            'jam_mulai.date_format' => 'Format jam mulai harus berupa HH:MM.',

            'jam_selesai.required' => 'Field jam selesai wajib diisi.',
            'jam_selesai.date_format' => 'Format jam selesai harus berupa HH:MM.',
            'jam_selesai.after' => 'Jam selesai harus lebih besar dari jam mulai.',

            'batas_absen.required' => 'Field batas absen wajib diisi.',
            'batas_absen.date_format' => 'Format batas absen harus berupa HH:MM.',
            'batas_absen.after_or_equal' => 'Batas absen harus sama atau setelah jam mulai.',

            'latitude.required' => 'Field latitude wajib diisi.',
            'latitude.numeric' => 'Latitude harus berupa angka.',
            'latitude.between' => 'Latitude harus berada di antara -90 dan 90.',

            'longitude.required' => 'Field longitude wajib diisi.',
            'longitude.numeric' => 'Longitude harus berupa angka.',
            'longitude.between' => 'Longitude harus berada di antara -180 dan 180.',

            'radius_meter.required' => 'Field radius (meter) wajib diisi.',
            'radius_meter.integer' => 'Radius harus berupa angka bulat.',
            'radius_meter.min' => 'Radius minimum adalah :min meter.',
            'tanggal.date' => 'Format tanggal tidak valid.',
        ];
    }

    public function attributes(): array
    {
        return [
            'jam_mulai' => 'jam mulai',
            'jam_selesai' => 'jam selesai',
            'batas_absen' => 'batas absen',
            'latitude' => 'latitude',
            'longitude' => 'longitude',
            'radius_meter' => 'radius (meter)',
        ];
    }
}
