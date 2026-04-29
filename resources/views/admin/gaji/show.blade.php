@extends('layouts.admin')

@section('title', 'Slip Gaji')

@section('content')
    <div class='card'>
        <div class='card-header d-flex justify-content-between align-items-center'>
            <h3 class='card-title'>Slip Gaji - {{ $gaji->guru->name }}</h3>
            <div>
                <a href="{{ route('admin.gaji.slip-pdf', $gaji) }}" class='btn btn-danger' target='_blank'>
                    <i class='fas fa-file-pdf mr-2'></i>Cetak PDF
                </a>
                <a href="{{ route('admin.gaji.index') }}" class='btn btn-secondary'>Kembali</a>
            </div>
        </div>
        <div class='card-body'>
            <div class='row'>
                <div class='col-md-6'>
                    <p><strong>Periode:</strong> {{ $gaji->periode }}</p>
                    <p><strong>Jumlah Kehadiran:</strong> {{ $gaji->kehadiran }}</p>
                </div>
                <div class='col-md-6'>
                    <p><strong>Total Gaji:</strong></p>
                    <h2 class='text-success'>Rp {{ number_format($gaji->total_gaji, 0, ',', '.') }}</h2>
                </div>
            </div>
        </div>
    </div>
@endsection