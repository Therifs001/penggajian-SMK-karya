@extends('layouts.app')

@section('content')
    <div class="space-y-4">
        <h2 class="text-2xl font-semibold">Edit Komponen Gaji</h2>
        <form action="{{ route('admin.komponen-gaji.update', $komponen_gaji) }}" method="POST" class="bg-white rounded shadow p-6 space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block font-medium">Guru</label>
                <select name="user_id" class="w-full border rounded p-2" required>
                    @foreach($gurus as $guru)
                        <option value="{{ $guru->id }}" {{ $komponen_gaji->user_id === $guru->id ? 'selected' : '' }}>{{ $guru->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block font-medium">Honor per Jam</label>
                <input type="number" name="honor_per_jam" value="{{ old('honor_per_jam', $komponen_gaji->honor_per_jam) }}" step="0.01" class="w-full border rounded p-2" required>
            </div>
            <div>
                <label class="block font-medium">Transport</label>
                <input type="number" name="transport" value="{{ old('transport', $komponen_gaji->transport) }}" step="0.01" class="w-full border rounded p-2" required>
            </div>
            <div>
                <label class="block font-medium">BPJS</label>
                <input type="number" name="bpjs" value="{{ old('bpjs', $komponen_gaji->bpjs) }}" step="0.01" class="w-full border rounded p-2" required>
            </div>
            <div>
                <label class="block font-medium">Potongan Lain</label>
                <input type="number" name="potongan_lain" value="{{ old('potongan_lain', $komponen_gaji->potongan_lain) }}" step="0.01" class="w-full border rounded p-2">
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Perbarui Komponen</button>
        </form>
    </div>
@endsection
