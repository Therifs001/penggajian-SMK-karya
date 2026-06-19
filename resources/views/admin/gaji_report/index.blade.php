@extends('layouts.admin')

@section('title', 'Laporan Gaji')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Laporan Gaji</h3>
            <div class="d-flex">
                <form method="GET" class="form-inline mr-2">
                    <input type="month" name="bulan" class="form-control mr-2" value="{{ request('bulan') }}">
                    <button class="btn btn-primary">Filter</button>
                </form>
                <a href="{{ route('admin.gaji-report.print', array_filter(['bulan' => request('bulan')])) }}" class="btn btn-outline-secondary" target="_blank">Cetak PDF</a>
            </div>
        </div>
        <div class="card-body table-responsive">
            @if($gajis->isEmpty())
                <p>Tidak ada data gaji.</p>
            @else
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Bulan</th>
                            <th>Guru</th>
                            <th>Kehadiran</th>
                            <th>Total Honor</th>
                            <th>Tunjangan (bulanan)</th>
                            <th>Potongan (bulanan)</th>
                            <th>Total Gaji</th>
                            <th>Rincian</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($gajis as $gaji)
                            <tr>
                                <td>{{ $gaji->bulan }}</td>
                                <td>{{ $gaji->guru->name ?? '-' }}</td>
                                <td>{{ $gaji->kehadiran }}</td>
                                <td>Rp {{ number_format($gaji->total_honor,0,',','.') }}</td>
                                <td>Rp {{ number_format($gaji->total_tunjangan,0,',','.') }}</td>
                                <td>Rp {{ number_format($gaji->total_potongan,0,',','.') }}</td>
                                <td>Rp {{ number_format($gaji->total_gaji,0,',','.') }}</td>
                                <td>
                                    <button class="btn btn-sm btn-secondary btn-detail" data-id="{{ $gaji->id }}">Rincian</button>
                                </td>
                                <td>
                                    <form action="{{ route('admin.gaji-report.destroy', $gaji) }}" method="POST" onsubmit="return confirm('Hapus data gaji ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            <tr class="gaji-detail-row d-none" data-id="{{ $gaji->id }}">
                                <td colspan="9">
                                    <div><strong>Jam Mengajar:</strong> {{ $gaji->jam_mengajar ?? '-' }}</div>
                                    <div><strong>Honor per Jam:</strong> Rp {{ number_format($gaji->honor_per_jam ?? 0,0,',','.') }}</div>
                                    <div><strong>Kehadiran:</strong> {{ $gaji->kehadiran }}</div>
                                    <div><strong>Transport:</strong> Rp {{ number_format($gaji->detail['transport'] ?? 0,0,',','.') }}</div>
                                    <div><strong>BPJS:</strong> Rp {{ number_format($gaji->detail['bpjs'] ?? 0,0,',','.') }}</div>
                                    <div><strong>Potongan Lain:</strong> Rp {{ number_format($gaji->detail['potongan_lain'] ?? 0,0,',','.') }}</div>
                                    <div><strong>Rincian Honor:</strong> Rp {{ number_format($gaji->detail['honor'] ?? $gaji->total_honor,0,',','.') }}</div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3">{{ $gajis->links() }}</div>
            @endif
        </div>
    </div>
    <script>
        document.addEventListener('click', function(e){
            if(e.target && e.target.classList.contains('btn-detail')){
                var id = e.target.getAttribute('data-id');
                var row = document.querySelector('.gaji-detail-row[data-id="'+id+'"]');
                if(row){
                    row.classList.toggle('d-none');
                }
            }
        });
    </script>
@endsection
