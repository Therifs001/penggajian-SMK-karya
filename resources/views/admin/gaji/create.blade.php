@extends('layouts.app')

@section('content')
    <div class="space-y-4">
        <h2 class="text-2xl font-semibold mb-4">Buat Perhitungan Gaji</h2>
        <form action="{{ route('admin.gaji.store') }}" method="POST" class="space-y-4 bg-white rounded shadow p-6">
            @csrf
            <div>
                <label class="block font-medium">Guru</label>
                <select name="user_id" class="w-full border rounded p-2">
                    @foreach($gurus as $guru)
                        <option value="{{ $guru->id }}">{{ $guru->name }} ({{ $guru->email }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block font-medium">Periode (YYYY-MM)</label>
                <input type="month" name="periode" class="w-full border rounded p-2" required>
            </div>
            <div>
                <label class="block font-medium">Jumlah Jam Mengajar</label>
                <input type="number" name="jam_mengajar" step="0.5" class="w-full border rounded p-2" required>
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Hitung Gaji</button>
        </form>
    </div>
@endsection
