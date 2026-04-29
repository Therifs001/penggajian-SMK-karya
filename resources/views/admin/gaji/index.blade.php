@extends('layouts.admin')

@section('title', 'Penggajian')

@section('content')
    <div class='card'>
        <div class='card-header d-flex justify-content-between align-items-center'>
            <h3 class='card-title'>Daftar Penggajian</h3>
            <a href="{{ route('admin.gaji.create') }}" class='btn btn-primary'>
                <i class='fas fa-calculator mr-2'></i>Buat Perhitungan Gaji
            </a>
        </div>
        <div class='card-body'>
            @if($gajis->isEmpty())
                <p class='text-muted'>Tidak ada data gaji.</p>
            @else
                <table class='table table-bordered table-striped'>
                    <thead>
                        <tr>
                            <th>Guru</th>
                            <th>Periode</th>
                            <th>Total Gaji</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($gajis as $gaji)
                            <tr>
                                <td>{{ $gaji->guru->name }}</td>
                                <td>{{ $gaji->periode }}</td>
                                <td>Rp {{ number_format($gaji->total_gaji, 0, ',', '.') }}</td>
                                <td>
                                    <a href="{{ route('admin.gaji.show', $gaji) }}" class='btn btn-sm btn-info'>
                                        <i class='fas fa-eye'></i> Lihat
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class='mt-3'>
                    {{ $gajis->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection