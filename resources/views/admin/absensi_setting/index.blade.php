@extends('layouts.app')

@section('content')
    <div class="space-y-4">
        <h2 class="text-2xl font-semibold">Pengaturan Absensi</h2>
        <form action="{{ route('admin.absensi-setting.store') }}" method="POST" class="bg-white rounded shadow p-6 space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium">Jam Mulai</label>
                    <input type="time" name="jam_mulai" value="{{ old('jam_mulai', optional($setting)->jam_mulai) }}" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Jam Selesai</label>
                    <input type="time" name="jam_selesai" value="{{ old('jam_selesai', optional($setting)->jam_selesai) }}" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Batas Absen</label>
                    <input type="time" name="batas_absen" value="{{ old('batas_absen', optional($setting)->batas_absen) }}" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Radius Meter</label>
                    <input type="number" name="radius_meter" value="{{ old('radius_meter', optional($setting)->radius_meter ?? 500) }}" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Latitude</label>
                    <input type="text" name="latitude" value="{{ old('latitude', optional($setting)->latitude) }}" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Longitude</label>
                    <input type="text" name="longitude" value="{{ old('longitude', optional($setting)->longitude) }}" class="w-full border rounded p-2" required>
                </div>
            </div>
            <div>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="active" value="1" {{ optional($setting)->active ? 'checked' : '' }} class="mr-2">
                    Aktifkan absensi
                </label>
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan Pengaturan</button>
        </form>
    </div>
@endsection
