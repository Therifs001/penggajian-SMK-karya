@extends('layouts.app')

@section('content')
    <div class="space-y-4">
        <h2 class="text-2xl font-semibold">Edit Guru</h2>
        <form action="{{ route('admin.guru.update', $guru) }}" method="POST" class="bg-white rounded shadow p-6 space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block font-medium">Nama</label>
                <input type="text" name="name" value="{{ old('name', $guru->name) }}" class="w-full border rounded p-2" required>
            </div>
            <div>
                <label class="block font-medium">NIP</label>
                <input type="text" name="nip" value="{{ old('nip', $guru->nip) }}" class="w-full border rounded p-2" required>
            </div>
            <div>
                <label class="block font-medium">Mata Pelajaran</label>
                <input type="text" name="matapelajaran" value="{{ old('matapelajaran', $guru->matapelajaran) }}" class="w-full border rounded p-2" required>
            </div>
            <div>
                <label class="block font-medium">Status</label>
                <input type="text" name="status" value="{{ old('status', $guru->status) }}" class="w-full border rounded p-2" required>
            </div>
            <div>
                <label class="block font-medium">Email</label>
                <input type="email" name="email" value="{{ old('email', $guru->email) }}" class="w-full border rounded p-2" required>
            </div>
            <div>
                <label class="block font-medium">Password Baru (opsional)</label>
                <input type="password" name="password" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block font-medium">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="w-full border rounded p-2">
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Perbarui</button>
        </form>
    </div>
@endsection
