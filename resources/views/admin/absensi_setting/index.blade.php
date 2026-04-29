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
                            <input type='time' name='jam_mulai' value="{{ old('jam_mulai', optional($setting)->jam_mulai) }}" class='form-control' required>
                        </div>
                    </div>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <label>Jam Selesai</label>
                            <input type='time' name='jam_selesai' value="{{ old('jam_selesai', optional($setting)->jam_selesai) }}" class='form-control' required>
                        </div>
                    </div>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <label>Batas Absen</label>
                            <input type='time' name='batas_absen' value="{{ old('batas_absen', optional($setting)->batas_absen) }}" class='form-control' required>
                        </div>
                    </div>
                </div>
            </div>
            <div class='card-footer'>
                <button type='submit' class='btn btn-primary'>Simpan Pengaturan</button>
            </div>
        </form>
    </div>
@endsection