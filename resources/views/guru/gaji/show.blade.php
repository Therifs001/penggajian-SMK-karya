@extends('layouts.app')

@section('content')
    <div class="space-y-4">
        <h2 class="text-2xl font-semibold">Detail Slip Gaji</h2>
        <div class="bg-white rounded shadow p-6">
            <p><strong>Periode:</strong> {{ $gaji->periode }}</p>
            <p><strong>Jam Mengajar:</strong> {{ $gaji->jam_mengajar }}</p>
            <p><strong>Total Kehadiran:</strong> {{ $gaji->kehadiran }}</p>
            <p><strong>Total Honor:</strong> Rp {{ number_format($gaji->total_honor, 0, ',', '.') }}</p>
            <p><strong>Total Tunjangan:</strong> Rp {{ number_format($gaji->total_tunjangan, 0, ',', '.') }}</p>
            <p><strong>Total Potongan:</strong> Rp {{ number_format($gaji->total_potongan, 0, ',', '.') }}</p>
            <div class="mt-4 p-4 bg-slate-50 rounded">
                <h3 class="font-semibold">Total Gaji</h3>
                <p class="text-2xl font-bold">Rp {{ number_format($gaji->total_gaji, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
@endsection
