@extends('layouts.app')

@section('content')
    <div class="space-y-4">
        <h2 class="text-2xl font-semibold mb-4">Slip Gaji - {{ $gaji->guru->name }}</h2>
        <div class="bg-white shadow rounded p-6">
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <p><strong>Periode:</strong> {{ $gaji->periode }}</p>
                    <p><strong>Jumlah Kehadiran:</strong> {{ $gaji->kehadiran }}</p>
                    <p><strong>Jam Mengajar:</strong> {{ $gaji->jam_mengajar }}</p>
                </div>
                <div>
                    <p><strong>Honor / Jam:</strong> Rp {{ number_format($gaji->honor_per_jam, 0, ',', '.') }}</p>
                    <p><strong>Tunjangan:</strong> Rp {{ number_format($gaji->total_tunjangan, 0, ',', '.') }}</p>
                    <p><strong>Potongan:</strong> Rp {{ number_format($gaji->total_potongan, 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="border-t pt-4">
                <h3 class="text-lg font-semibold mb-2">Total Gaji</h3>
                <p class="text-2xl font-bold">Rp {{ number_format($gaji->total_gaji, 0, ',', '.') }}</p>
            </div>
            <div class="mt-6">
                <a href="{{ route('admin.gaji.slip-pdf', $gaji) }}" class="inline-block px-4 py-2 bg-green-600 text-white rounded">Download PDF</a>
            </div>
        </div>
    </div>
@endsection
