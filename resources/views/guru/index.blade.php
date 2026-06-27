@extends('layouts.guru')

@section('title', 'Dashboard Guru')

@section('content')
    <style>
        /* Quick layout fixes for guru dashboard tiles */
        .guru-tiles {
            margin-bottom: 1.25rem;
            z-index: 0;
        }

        .guru-tiles .col-lg-4,
        .guru-tiles .col-12 {
            margin-bottom: 12px;
        }

        .guru-tiles .small-box {
            min-height: 110px;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .guru-tiles .small-box .inner {
            width: 100%;
            padding: 18px;
        }

        .guru-tiles .small-box .icon {
            position: absolute;
            top: 12px;
            right: 12px;
            font-size: 28px;
            opacity: 0.85
        }

        .card {
            margin-top: 0;
            position: relative;
            z-index: 1;
        }

        .row.mt-3 {
            margin-top: 1.75rem;
        }

        .card .card-body {
            padding: 1rem;
        }

        .info-box {
            display: flex;
            align-items: center;
        }

        .info-box .info-box-icon {
            width: 56px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px
        }

        @media (max-width: 768px) {
            .guru-tiles .small-box {
                min-height: 80px
            }
        }
    </style>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title mb-0">
                <i class="fas fa-user-circle mr-2"></i>
                Profil Guru
            </h3>
        </div>

        <div class="card-body">
            <div class="row align-items-center">

                <!-- Foto Profil -->
                <div class="col-md-3">

                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">

                            <form action="{{ route('guru.profile.photo') }}" method="POST" enctype="multipart/form-data">

                                @csrf

                                <div class="position-relative d-inline-block mb-3">

                                    @if(auth()->user()->photo)
                                        <img id="previewImage" src="{{ asset('storage/' . auth()->user()->photo) }}"
                                            class="rounded-circle shadow border" width="170" height="170"
                                            style="object-fit:cover;">
                                    @else
                                        <img id="previewImage"
                                            src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=0D8ABC&color=fff&size=170"
                                            class="rounded-circle shadow border" width="170" height="170">
                                    @endif


                                </div>

                                <h5 class="font-weight-bold mb-1">
                                    {{ auth()->user()->name }}
                                </h5>

                                <p class="text-muted mb-3">
                                    Guru
                                </p>
                                <label for="photo" class="btn btn-outline-primary btn-sm mt-2">
                                    <i class="fas fa-edit mr-1"></i>
                                    Edit Foto
                                </label>
                                <input type="file" id="photo" name="photo" class="d-none" accept="image/*"
                                    onchange="previewPhoto(event)">

                                <button class="btn btn-success btn-block">
                                    <i class="fas fa-save mr-1"></i>
                                    Simpan Foto
                                </button>

                            </form>

                        </div>
                    </div>

                </div>

                <!-- Informasi Guru -->
                <div class="col-md-9">

                    <table class="table table-bordered table-striped">
                        <tbody>

                            <tr>
                                <th width="180">
                                    <i class="fas fa-user text-primary"></i>
                                    Nama Guru
                                </th>
                                <td>{{ auth()->user()->name }}</td>
                            </tr>

                            <tr>
                                <th>
                                    <i class="fas fa-id-card text-success"></i>
                                    NIP
                                </th>
                                <td>{{ auth()->user()->nip }}</td>
                            </tr>

                            <tr>
                                <th>
                                    <i class="fas fa-book text-warning"></i>
                                    Mata Pelajaran
                                </th>
                                <td>
                                    @if(auth()->user()->subjects->isNotEmpty())
                                        {{ auth()->user()->subjects->pluck('name')->implode(', ') }}
                                    @else
                                        Belum ada mata pelajaran
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    <i class="fas fa-envelope text-danger"></i>
                                    Email
                                </th>
                                <td>{{ auth()->user()->email }}</td>
                            </tr>

                            <tr>
                                <th>
                                    <i class="fas fa-user-tag text-info"></i>
                                    Role
                                </th>
                                <td>{{ ucfirst(auth()->user()->role) }}</td>
                            </tr>

                        </tbody>
                    </table>

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
                            &nbsp;•&nbsp; {{ optional($setting->jam_mulai)->format('H:i') ?? '-' }} -
                            {{ optional($setting->batas_absen)->format('H:i') ?? '-' }}
                            &nbsp;•&nbsp; Radius: {{ $setting->radius_meter }} m
                        </div>
                    @endif
                    <p class="text-muted">Gunakan tombol di bawah untuk melakukan absen hadir atau izin.</p>
                    <a href="{{ route('guru.absensi.index') }}" class="btn btn-primary mr-2"><i
                            class="fas fa-calendar-check mr-1"></i> Absen Hadir</a>
                    <a href="{{ route('guru.absensi.index') }}" class="btn btn-warning"><i
                            class="fas fa-comment-alt mr-1"></i> Izin / Alasan</a>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow-sm border-0">

                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h3 class="card-title font-weight-bold mb-0">
                        <i class="fas fa-wallet text-success mr-2"></i>
                        Ringkasan Gaji
                    </h3>

                    <form method="GET" class="mb-0">
                        <select name="periode" class="form-control form-control-sm" onchange="this.form.submit()">

                            @foreach($riwayatGaji as $item)
                                <option value="{{ $item->bulan }}" {{ $bulan == $item->bulan ? 'selected' : 'selected' }}>
                                    {{ \Carbon\Carbon::parse($item->bulan . '-01')->translatedFormat('F Y') }}
                                </option>
                            @endforeach

                        </select>
                    </form>
                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-6 mb-3">
                            <div class="border rounded-lg p-3 shadow-sm h-100">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <small class="text-muted">Total Gaji</small>
                                        <h5 class="font-weight-bold text-success mt-1 mb-0">
                                            Rp {{ number_format($gajiTerakhir->total_gaji ?? 0, 0, ',', '.') }}
                                        </h5>
                                    </div>

                                    <span class="bg-success text-white rounded-circle p-3">
                                        <i class="fas fa-wallet"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 mb-3">
                            <div class="border rounded-lg p-3 shadow-sm h-100">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <small class="text-muted">Honor Mengajar</small>
                                        <h5 class="font-weight-bold text-primary mt-1 mb-0">
                                            Rp {{ number_format($gajiTerakhir->total_honor ?? 0, 0, ',', '.') }}
                                        </h5>
                                    </div>

                                    <span class="bg-primary text-white rounded-circle p-3">
                                        <i class="fas fa-chalkboard-teacher"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="border rounded-lg p-3 shadow-sm h-100">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <small class="text-muted">Transport</small>
                                        <h5 class="font-weight-bold text-info mt-1 mb-0">
                                            Rp {{ number_format($gajiTerakhir->total_tunjangan ?? 0, 0, ',', '.') }}
                                        </h5>
                                    </div>

                                    <span class="bg-info text-white rounded-circle p-3">
                                        <i class="fas fa-bus"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="border rounded-lg p-3 shadow-sm h-100">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <small class="text-muted">Potongan</small>
                                        <h5 class="font-weight-bold text-danger mt-1 mb-0">
                                            Rp {{ number_format($gajiTerakhir->total_potongan ?? 0, 0, ',', '.') }}
                                        </h5>
                                    </div>

                                    <span class="bg-danger text-white rounded-circle p-3">
                                        <i class="fas fa-minus-circle"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="card-footer bg-light text-right">
                    <small class="text-muted">
                        Periode:
                        <strong>
                            {{ \Carbon\Carbon::parse($bulan . '-01')->translatedFormat('F Y') }}
                        </strong>
                    </small>
                </div>
                @if($gajiTerakhir)
                    <a href="{{ route('guru.slip-gaji.pdf', $gajiTerakhir->id) }}" class="btn btn-danger btn-sm float-right"
                        target="_blank">
                        <i class="fas fa-file-pdf"></i>
                        Cetak Slip
                    </a>
                @endif
            </div>
        </div>
    </div>
    </div>
@endsection