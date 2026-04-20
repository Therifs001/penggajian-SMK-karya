@extends('layouts.app')

@section('content')
    <div class="space-y-4">
        <h2 class="text-2xl font-semibold mb-4">Daftar Penggajian</h2>
        <div class="bg-white rounded shadow p-4">
            <a href="{{ route('admin.gaji.create') }}" class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded">Buat Perhitungan Gaji</a>
            @if($gajis->isEmpty())
                <p>Tidak ada data gaji.</p>
            @else
                <table class="min-w-full bg-white border rounded">
                    <thead>
                        <tr class="bg-slate-100 text-left">
                            <th class="px-4 py-2">Guru</th>
                            <th class="px-4 py-2">Periode</th>
                            <th class="px-4 py-2">Total Gaji</th>
                            <th class="px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($gajis as $gaji)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $gaji->guru->name }}</td>
                                <td class="px-4 py-2">{{ $gaji->periode }}</td>
                                <td class="px-4 py-2">Rp {{ number_format($gaji->total_gaji, 0, ',', '.') }}</td>
                                <td class="px-4 py-2 space-x-2">
                                    <a href="{{ route('admin.gaji.show', $gaji) }}" class="text-blue-600">Detail</a>
                                    <a href="{{ route('admin.gaji.slip-pdf', $gaji) }}" class="text-green-600">PDF</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">{{ $gajis->links() }}</div>
            @endif
        </div>
    </div>
@endsection
