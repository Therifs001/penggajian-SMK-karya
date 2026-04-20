@extends('layouts.app')

@section('content')
    <div class="space-y-4">
        <h2 class="text-2xl font-semibold">Pengaturan Komponen Gaji</h2>
        <div>
            <a href="{{ route('admin.komponen-gaji.create') }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded">Tambah Komponen</a>
        </div>
        <div class="bg-white rounded shadow p-4">
            @if($komponens->isEmpty())
                <p>Tidak ada komponen gaji.</p>
            @else
                <table class="min-w-full border rounded">
                    <thead>
                        <tr class="bg-slate-100 text-left">
                            <th class="px-4 py-2">Guru</th>
                            <th class="px-4 py-2">Honor/Jam</th>
                            <th class="px-4 py-2">Transport</th>
                            <th class="px-4 py-2">BPJS</th>
                            <th class="px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($komponens as $komponen)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $komponen->guru->name }}</td>
                                <td class="px-4 py-2">Rp {{ number_format($komponen->honor_per_jam, 0, ',', '.') }}</td>
                                <td class="px-4 py-2">Rp {{ number_format($komponen->transport, 0, ',', '.') }}</td>
                                <td class="px-4 py-2">Rp {{ number_format($komponen->bpjs, 0, ',', '.') }}</td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('admin.komponen-gaji.edit', $komponen) }}" class="text-blue-600">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">{{ $komponens->links() }}</div>
            @endif
        </div>
    </div>
@endsection
