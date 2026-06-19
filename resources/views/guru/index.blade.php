@extends('layouts.guru')

@section('title', 'Dashboard Guru')

@section('content')
    <style>
        /* Quick layout fixes for guru dashboard tiles */
        .guru-tiles { margin-bottom: 1.25rem; z-index: 0; }
        .guru-tiles .col-lg-4, .guru-tiles .col-12 { margin-bottom: 12px; }
        .guru-tiles .small-box { min-height: 110px; display:flex; align-items:center; position:relative; overflow:hidden; }
        .guru-tiles .small-box .inner { width:100%; padding: 18px; }
        .guru-tiles .small-box .icon { position:absolute; top:12px; right:12px; font-size:28px; opacity:0.85 }
        .card { margin-top: 0; position: relative; z-index: 1; }
        .row.mt-3 { margin-top: 1.75rem; }
        .card .card-body { padding: 1rem; }
        .info-box { display:flex; align-items:center; }
        .info-box .info-box-icon { width:56px; height:56px; display:flex; align-items:center; justify-content:center; margin-right:12px }
        @media (max-width: 768px) {
            .guru-tiles .small-box { min-height:80px }
        }
    </style>

    <div class="row guru-tiles mb-4">
        <div class="col-lg-4 col-12">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ auth()->user()->name }}</h3>
                    <p>Nama Guru</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-12">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ auth()->user()->nip }}</h3>
                    <p>NIP</p>
                </div>
                <div class="icon">
                    <i class="fas fa-id-card"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-12">
            <div class="small-box bg-warning">
                <div class="inner">
                    @php $user = auth()->user(); @endphp
                    <h3>
                        @if(method_exists($user, 'subjects') && $user->subjects->count())
                            {{ $user->subjects->pluck('name')->join(', ') }}
                        @else
                            {{ $user->matapelajaran ?? '-' }}
                        @endif
                    </h3>
                    <p>Mata Pelajaran</p>
                </div>
                <div class="icon">
                    <i class="fas fa-book"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-lg-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Absensi Hari Ini</h3>
                </div>
                <div class="card-body">
                    @php $setting = \App\Models\AbsensiSetting::where('active', true)->latest()->first(); @endphp
                    @if(!$setting)
                        <div class="alert alert-warning mb-3">Pengaturan absensi belum diaktifkan oleh admin.</div>
                    @else
                        <div class="alert alert-info mb-3 small">
                            <strong>Absensi aktif</strong>
                            &nbsp;•&nbsp; {{ optional($setting->jam_mulai)->format('H:i') ?? '-' }} - {{ optional($setting->batas_absen)->format('H:i') ?? '-' }}
                            &nbsp;•&nbsp; Radius: {{ $setting->radius_meter }} m
                        </div>
                    @endif
                    <p class="text-muted">Gunakan tombol di bawah untuk melakukan absen hadir atau izin.</p>
                    <a href="{{ route('guru.absensi.index') }}" class="btn btn-primary mr-2"><i class="fas fa-calendar-check mr-1"></i> Absen Hadir</a>
                    <a href="{{ route('guru.absensi.index') }}" class="btn btn-warning"><i class="fas fa-comment-alt mr-1"></i> Izin / Alasan</a>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Ringkasan Gaji</h3>
                </div>
                <div class="card-body">
                    <div class="info-box bg-light mb-3">
                        <span class="info-box-icon bg-success"><i class="fas fa-wallet"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Gaji Terakhir</span>
                            <span class="info-box-number">Rp 4.650.000</span>
                        </div>
                    </div>
                    <div class="info-box bg-light mb-3">
                        <span class="info-box-icon bg-info"><i class="fas fa-hand-holding-dollar"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Tunjangan</span>
                            <span class="info-box-number">Rp 550.000</span>
                        </div>
                    </div>
                    <div class="info-box bg-light">
                        <span class="info-box-icon bg-warning"><i class="fas fa-history"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Riwayat Slip</span>
                            <span class="info-box-number">3 Bulan Terakhir</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection