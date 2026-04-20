@extends('layouts.app')

@section('content')
    <div class="space-y-4">
        <h2 class="text-2xl font-semibold">Tambah Komponen Gaji</h2>
        <form action="{{ route('admin.komponen-gaji.store') }}" method="POST" class="bg-white rounded shadow p-6 space-y-4">
            @csrf
            <div>
                <label class="block font-medium">Guru</label>
                <select name="user_id" class="w-full border rounded p-2" required>
                    @foreach($gurus as $guru)
                        <option value="{{ $guru->id }}">{{ $guru->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block font-medium">Honor per Jam</label>
                <input type="number" name="honor_per_jam" step="0.01" class="w-full border rounded p-2" required>
            </div>
            <div>
                <label class="block font-medium">Transport</label>
                <input type="number" name="transport" step="0.01" class="w-full border rounded p-2" required>
            </div>
            <div>
                <label class="block font-medium">BPJS</label>
                <input type="number" name="bpjs" step="0.01" class="w-full border rounded p-2" required>
            </div>
            <div>
                <label class="block font-medium">Potongan Lain</label>
                <input type="number" name="potongan_lain" step="0.01" class="w-full border rounded p-2">
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan Komponen</button>
        </form>
    </div>
@endsection
