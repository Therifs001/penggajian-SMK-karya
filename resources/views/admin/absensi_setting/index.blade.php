@extends('layouts.admin')

@section('title', 'Absensi')

@section('content')
    <div class='card'>
        <div class='card-header'>
            <h3 class='card-title'>Pengaturan Absensi</h3>
        </div>
        <form action="{{ route('admin.absensi-setting.store') }}" method='POST'>
            @csrf
            <div class='card-body'>
                <div class='row'>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <label>Jam Mulai</label>
                            <input type='time' name='jam_mulai'
                                value="{{ old('jam_mulai', optional($setting)->jam_mulai) }}" class='form-control' required>
                        </div>
                    </div>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <label>Tanggal Berlaku</label>
                            <input type='date' name='tanggal' value="{{ old('tanggal', optional($setting) && optional($setting)->tanggal ? optional($setting->tanggal)->format('Y-m-d') : null) }}" class='form-control'>
                        </div>
                    </div>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <label>Jam Selesai</label>
                            <input type='time' name='jam_selesai'
                                value="{{ old('jam_selesai', optional($setting)->jam_selesai) }}" class='form-control'
                                required>
                        </div>
                    </div>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <label>Batas Absen</label>
                            <input type='time' name='batas_absen'
                                value="{{ old('batas_absen', optional($setting)->batas_absen) }}" class='form-control'
                                required>
                        </div>
                    </div>
                </div>
                <hr>
                <div class='row'>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <label>Latitude</label>
                            <input type='text' name='latitude' id='admin_latitude' value="{{ old('latitude', optional($setting)->latitude) }}" class='form-control' required>
                        </div>
                    </div>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <label>Longitude</label>
                            <input type='text' name='longitude' id='admin_longitude' value="{{ old('longitude', optional($setting)->longitude) }}" class='form-control' required>
                        </div>
                    </div>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <label>Radius Meter</label>
                            <input type='number' name='radius_meter' id='radius_meter' value="{{ old('radius_meter', optional($setting)->radius_meter ?? 100) }}" class='form-control' required>
                        </div>
                    </div>
                </div>
            </div>
            <div class='card-footer'>
                <div class="form-check form-check-inline mr-3">
                    <input class="form-check-input" type="checkbox" id="active" name="active" value="1" {{ optional($setting)->active ? 'checked' : '' }}>
                    <label class="form-check-label" for="active">Aktifkan Absensi</label>
                </div>
                @if(optional($setting)->active)
                    <small class="text-success mr-3">Status: Aktif</small>
                @else
                    <small class="text-muted mr-3">Status: Non-aktif</small>
                @endif
                <button type='submit' class='btn btn-primary'>Simpan Pengaturan</button>
                <button type='button' id='fillAdminLocationBtn' class='btn btn-secondary ml-2'>Isi Lokasi Otomatis</button>
                <small id='adminLocationStatus' class='form-text text-muted d-inline-block ml-3'></small>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const fillBtn = document.getElementById('fillAdminLocationBtn');
    const latInput = document.getElementById('admin_latitude');
    const lonInput = document.getElementById('admin_longitude');
    const radiusInput = document.getElementById('radius_meter');
    const statusEl = document.getElementById('adminLocationStatus');

    function setStatus(msg) { if (statusEl) statusEl.textContent = msg; }

    function onSuccess(position) {
        if (latInput) latInput.value = position.coords.latitude.toFixed(6);
        if (lonInput) lonInput.value = position.coords.longitude.toFixed(6);
        if (radiusInput && !radiusInput.value) radiusInput.value = 100;
        setStatus('Lokasi terisi otomatis.');
    }

    function onError(err) { setStatus('Gagal mendapatkan lokasi: ' + (err && err.message ? err.message : 'izin ditolak atau timeout')); }

    function getLocation() {
        if (!navigator.geolocation) { setStatus('Geolocation tidak didukung browser.'); return; }
        setStatus('Mencari lokasi...');
        navigator.geolocation.getCurrentPosition(onSuccess, onError, { enableHighAccuracy: true, timeout: 10000 });
    }

    if (fillBtn) fillBtn.addEventListener('click', getLocation);
});
</script>
@endpush