@extends('layouts.app')

@section('content')
    <div class="space-y-4">
        <h2 class="text-2xl font-semibold">Riwayat Gaji</h2>
        <div class="bg-white rounded shadow p-4">
            @if($history->isEmpty())
                <p>Belum ada histori gaji.</p>
            @else
                <table class="min-w-full border rounded">
                    <thead>
                        <tr class="bg-slate-100 text-left">
                            <th class="px-4 py-2">Periode</th>
                            <th class="px-4 py-2">Total Gaji</th>
                            <th class="px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($history as $gaji)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $gaji->periode }}</td>
                                <td class="px-4 py-2">Rp {{ number_format($gaji->total_gaji, 0, ',', '.') }}</td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('guru.gaji.show', $gaji) }}" class="text-blue-600">Detail</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">{{ $history->links() }}</div>
            @endif
        </div>
    </div>
@endsection
