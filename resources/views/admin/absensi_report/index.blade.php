@extends('layouts.admin')

@section('title', 'Laporan Absensi')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Laporan Absensi - {{ $date }}</h3>
            <form method="GET" class="form-inline">
                <div class="input-group">
                    <input type="date" name="date" class="form-control" value="{{ $date }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Tampilkan</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIP</th>
                        <th>Tanggal</th>
                        <th>Jam Masuk</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Status</th>
                        <th>Approved</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($records as $i => $rec)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ optional($rec->guru)->name }}</td>
                            <td>{{ optional($rec->guru)->nip }}</td>
                            <td>{{ $rec->tanggal?->toDateString() }}</td>
                            <td>{{ $rec->jam_masuk }}</td>
                            <td>{{ $rec->latitude }}</td>
                            <td>{{ $rec->longitude }}</td>
                            <td>{{ $rec->status }}</td>
                            <td>{{ $rec->approved ? 'Ya' : 'Tidak' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center">Tidak ada data untuk tanggal ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
