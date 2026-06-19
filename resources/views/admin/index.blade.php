@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ \App\Models\User::where('role', 'guru')->count() }}</h3>
                    <p>Jumlah Guru</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{ route('admin.guru.index') }}" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ \App\Models\Gaji::count() }}</h3>
                    <p>laporan</p>
                </div>
                <div class="icon">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
                <a href="{{ route('admin.gaji-report.index') }}" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ \App\Models\Absensi::whereDate('tanggal', today())->count() }}</h3>
                    <p>Absensi Hari Ini</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <a href="{{ route('admin.absensi-report.index') }}" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ \App\Models\KomponenGaji::count() }}</h3>
                    <p>Komponen Gaji</p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <a href="{{ route('admin.komponen-gaji.index') }}" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">Ringkasan Gaji</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <p class="text-muted">Statistik gaji dan absensi untuk membantu admin memantau performa bulanan.</p>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="info-box bg-light">
                                <span class="info-box-icon bg-info"><i class="fas fa-user-check"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Guru Aktif</span>
                                    <span class="info-box-number">{{ \App\Models\User::where('role', 'guru')->where('status', 'aktif')->count() }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box bg-light">
                                <span class="info-box-icon bg-success"><i class="fas fa-hand-holding-dollar"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Tunjangan</span>
                                    <span class="info-box-number">Rp {{ number_format(\App\Models\KomponenGaji::sum('transport') + \App\Models\KomponenGaji::sum('bpjs'), 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box bg-light">
                                <span class="info-box-icon bg-warning"><i class="fas fa-clock"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Absensi Hari Ini</span>
                                    <span class="info-box-number">{{ \App\Models\Absensi::whereDate('tanggal', today())->count() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Quick Action</h3>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.guru.index') }}" class="btn btn-primary btn-block mb-2"><i class="fas fa-users mr-2"></i> Kelola Guru</a>
                    <a href="{{ route('admin.komponen-gaji.index') }}" class="btn btn-success btn-block mb-2"><i class="fas fa-money-bill-wave mr-2"></i> Komponen Gaji</a>
                    <a href="{{ route('admin.absensi-setting.index') }}" class="btn btn-warning btn-block mb-2"><i class="fas fa-calendar-alt mr-2"></i> Atur Absensi</a>
                    <a href="{{ route('admin.gaji-report.index') }}" class="btn btn-danger btn-block"><i class="fas fa-file-invoice-dollar mr-2"></i> laporan</a>
                </div>
            </div>
            @php
                $activeSetting = \App\Models\AbsensiSetting::where('active', true)->latest()->first();
            @endphp
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Status Absensi</h3>
                </div>
                <div class="card-body">
                    @if($activeSetting)
                        <p><strong>Status:</strong> <span class="text-success">Aktif</span></p>
                        <p><strong>Jam Mulai:</strong> {{ optional($activeSetting->jam_mulai)->format('H:i') ?? '-' }}</p>
                        <p><strong>Batas Absen:</strong> {{ optional($activeSetting->batas_absen)->format('H:i') ?? '-' }}</p>
                        <p><strong>Radius:</strong> {{ $activeSetting->radius_meter ?? '-' }} meter</p>
                        <p><strong>Lokasi:</strong> {{ $activeSetting->latitude ?? '-' }}, {{ $activeSetting->longitude ?? '-' }}</p>
                        <form action="{{ route('admin.absensi-setting.deactivate') }}" method="POST" class="mt-3">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-block">Non-aktifkan Pengaturan Absensi</button>
                        </form>
                    @else
                        <p><strong>Status:</strong> <span class="text-muted">Non-aktif</span></p>
                        <p>Tidak ada pengaturan absensi aktif. <a href="{{ route('admin.absensi-setting.index') }}">Atur sekarang</a>.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
