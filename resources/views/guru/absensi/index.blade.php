@extends('layouts.guru')

@section('title', 'Absensi')

@section('content')
    <style>
        .card .alert { margin-bottom:12px }
        .card .btn { margin-right:8px }
        .form-group { margin-bottom:0.85rem }
    </style>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Absensi</h3>
                </div>
                <div class="card-body">
                    @if(!$setting)
                        <div class="alert alert-warning">Pengaturan absensi belum diaktifkan oleh admin. Form absensi dinonaktifkan.</div>
                    @else
                        <div class="alert alert-info">
                            <strong>Pengaturan Absensi Aktif:</strong>
                            <div class="small">
                                Jam: {{ optional($setting->jam_mulai)->format('H:i') ?? '-' }} - {{ optional($setting->batas_absen)->format('H:i') ?? '-' }} · Radius: {{ $setting->radius_meter ?? '-' }} m
                            </div>
                        </div>
                    @endif
                    <form action="{{ route('guru.absensi.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control" required @if(!$setting) disabled @endif>
                                <option value="hadir">Hadir</option>
                                <option value="izin">Izin</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="subjects">Mata Pelajaran (opsional - pilih jika mengajar, bisa pilih lebih dari satu)</label>
                            <select name="subjects[]" id="subjects-select" class="form-control" multiple @if(!$setting) disabled @endif>
                                @foreach($subjects ?? [] as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }} @if($subject->jam) ({{ $subject->jam }} jam) @endif</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="alasan">Alasan (jika izin)</label>
                            <textarea name="alasan" id="alasan" rows="3" class="form-control" @if(!$setting) disabled @endif></textarea>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="latitude">Latitude</label>
                                <input type="text" name="latitude" id="latitude" class="form-control" required @if(!$setting) disabled @endif>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="longitude">Longitude</label>
                                <input type="text" name="longitude" id="longitude" class="form-control" required @if(!$setting) disabled @endif>
                            </div>
                        </div>

                        <button type="submit" id="submitAbsensi" class="btn btn-primary" @if(!$setting) disabled title="Form dinonaktifkan karena tidak ada pengaturan aktif" @endif>Kirim Absensi</button>
                        <button type="button" id="fillLocationBtn" class="btn btn-secondary ml-2" @if(!$setting) disabled @endif>Isi Lokasi Otomatis</button>
                        <small id="locationStatus" class="form-text text-muted mt-2"></small>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Riwayat Absensi</h3>
                </div>
                <div class="card-body">
                    @if($riwayat->isEmpty())
                        <p>Tidak ada absensi.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Jam Masuk</th>
                                        <th>Status</th>
                                        <th>Alasan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($riwayat as $absensi)
                                        <tr>
                                            <td>{{ optional($absensi->tanggal)->format('d/m/Y') }}</td>
                                            <td>{{ $absensi->jam_masuk ?? '-' }}</td>
                                            <td>{{ ucfirst($absensi->status) }}</td>
                                            <td>{{ $absensi->alasan ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">{{ $riwayat->links() }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // initialize Select2 for subjects multi-select
    if (window.jQuery && $.fn && $.fn.select2) {
        $('#subjects-select').select2({
            placeholder: 'Pilih mata pelajaran',
            width: '100%'
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const fillBtn = document.getElementById('fillLocationBtn');
    const latInput = document.getElementById('latitude');
    const lonInput = document.getElementById('longitude');
    const statusEl = document.getElementById('locationStatus');

    function setStatus(msg) {
        if (statusEl) statusEl.textContent = msg;
    }

    function onSuccess(position) {
        if (latInput) latInput.value = position.coords.latitude.toFixed(6);
        if (lonInput) lonInput.value = position.coords.longitude.toFixed(6);
        setStatus('Lokasi terisi otomatis.');
    }

    function onError(err) {
        setStatus('Gagal mendapatkan lokasi: ' + (err && err.message ? err.message : 'izin ditolak atau timeout'));
    }

    function getLocation() {
        if (!navigator.geolocation) {
            setStatus('Geolocation tidak didukung browser.');
            return;
        }
        setStatus('Mencari lokasi...');
        navigator.geolocation.getCurrentPosition(onSuccess, onError, { enableHighAccuracy: true, timeout: 10000 });
    }

    if (fillBtn) fillBtn.addEventListener('click', getLocation);

    // Coba isi otomatis saat halaman dimuat
    getLocation();

    // Client-side check against admin setting: distance and enable/disable submit
    const submitBtn = document.getElementById('submitAbsensi');
    const centerLat = {{ $setting->latitude ?? 'null' }};
    const centerLon = {{ $setting->longitude ?? 'null' }};
    const allowedRadius = {{ $setting->radius_meter ?? 'null' }}; // in meters

    function metersBetween(lat1, lon1, lat2, lon2) {
        const toRad = (v) => v * Math.PI / 180;
        const R = 6371000;
        const dLat = toRad(lat2 - lat1);
        const dLon = toRad(lon2 - lon1);
        const a = Math.sin(dLat/2) * Math.sin(dLat/2) + Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) * Math.sin(dLon/2) * Math.sin(dLon/2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        return R * c;
    }

    function validateLocationInputs() {
        if (!submitBtn) return;
        if (!centerLat || !centerLon || !allowedRadius) {
            // no setting to validate against
            // enable submit so user can manually enter location if needed
            submitBtn.disabled = false;
            setStatus('Pengaturan titik pusat tidak tersedia; silakan isi lokasi secara manual jika perlu.');
            return;
        }
        const latVal = parseFloat(latInput.value || '0');
        const lonVal = parseFloat(lonInput.value || '0');
        if (!latVal || !lonVal) {
            // allow manual submission but advise to fill location
            submitBtn.disabled = false;
            setStatus('Lokasi belum terisi. Anda dapat klik "Isi Lokasi Otomatis" atau isi koordinat secara manual.');
            return;
        }
        const dist = metersBetween(centerLat, centerLon, latVal, lonVal);
        if (dist > allowedRadius) {
            submitBtn.disabled = true;
            setStatus('Anda berada ' + Math.round(dist) + ' meter dari pusat; di luar radius (' + allowedRadius + ' m).');
        } else {
            submitBtn.disabled = false;
            setStatus('Lokasi valid (' + Math.round(dist) + ' m dari pusat).');
        }
    }

    // Re-validate when inputs change
    if (latInput) latInput.addEventListener('change', validateLocationInputs);
    if (lonInput) lonInput.addEventListener('change', validateLocationInputs);
    // initial validation
    validateLocationInputs();
});
</script>
@endpush
