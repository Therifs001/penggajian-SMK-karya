@extends('layouts.admin')

@section('title', 'Komponen Gaji')

@section('content')
    <div class='card'>
        <div class='card-header d-flex justify-content-between align-items-center'>
            <h3 class='card-title'>Komponen Gaji</h3>
            <a href="{{ route('admin.komponen-gaji.create') }}" class='btn btn-primary'>
                <i class='fas fa-plus mr-2'></i>Tambah Komponen
            </a>
        </div>
        <div class='card-body'>
            @if($komponens->isEmpty())
                <p class='text-muted'>Tidak ada komponen gaji.</p>
            @else
                <table class='table table-bordered table-striped'>
                    <thead>
                        <tr>
                            <th>Guru</th>
                            <th>Honor/Jam</th>
                            <th>Transport</th>
                            <th>BPJS</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($komponens as $komponen)
                            <tr>
                                <td>{{ $komponen->guru->name }}</td>
                                <td>Rp {{ number_format($komponen->honor_per_jam, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($komponen->transport, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($komponen->bpjs, 0, ',', '.') }}</td>
                                <td>
                                    <a href="{{ route('admin.komponen-gaji.edit', $komponen) }}" class='btn btn-sm btn-info'>
                                        <i class='fas fa-edit'></i> Edit
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class='mt-3'>
                    {{ $komponens->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection