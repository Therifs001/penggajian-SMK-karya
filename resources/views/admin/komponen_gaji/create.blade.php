@extends('layouts.admin')

@section('title', 'Tambah Komponen Gaji')

@section('content')
    <div class='card'>
        <div class='card-header'>
            <h3 class='card-title'>Tambah Komponen Gaji</h3>
        </div>
        <form action="{{ route('admin.komponen-gaji.store') }}" method='POST'>
            @csrf
            <div class='card-body'>
                <div class='form-group'>
                    <label>Guru</label>
                    <select name='user_id' class='form-control' required>
                        @foreach($gurus as $guru)
                            <option value="{{ $guru->id }}">{{ $guru->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class='form-group'>
                    <label>Honor per Jam</label>
                    <input type='number' name='honor_per_jam' step='0.01' class='form-control' required>
                </div>
                <div class='form-group'>
                    <label>Honor per Hadir (opsional)</label>
                    <input type='number' name='honor_per_hadir' step='0.01' class='form-control' placeholder='Kosongkan jika menggunakan Honor per Jam'>
                </div>
                <div class='form-group'>
                    <label>Transport</label>
                    <input type='number' name='transport' step='0.01' class='form-control' required>
                </div>
                <div class='form-group'>
                    <label>BPJS</label>
                    <input type='number' name='bpjs' step='0.01' class='form-control' required>
                </div>
                <div class='form-group'>
                    <label>Potongan Lain (opsional)</label>
                    <input type='number' name='potongan_lain' step='0.01' class='form-control' placeholder='Masukkan jumlah potongan lain jika ada'>
                </div>
            </div>
            <div class='card-footer'>
                <button type='submit' class='btn btn-primary'>Simpan</button>
                <a href="{{ route('admin.komponen-gaji.index') }}" class='btn btn-secondary'>Batal</a>
            </div>
        </form>
    </div>
@endsection