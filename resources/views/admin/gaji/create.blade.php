@extends('layouts.admin')

@section('title', 'Buat Gaji')

@section('content')
    <div class='card'>
        <div class='card-header'>
            <h3 class='card-title'>Buat Perhitungan Gaji</h3>
        </div>
        <form action="{{ route('admin.gaji.store') }}" method='POST'>
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
                    <label>Periode</label>
                    <input type='month' name='periode' class='form-control' required>
                </div>
                <div class='form-group'>
                    <label>Jumlah Kehadiran</label>
                    <input type='number' name='kehadiran' class='form-control' required>
                </div>
            </div>
            <div class='card-footer'>
                <button type='submit' class='btn btn-primary'>Hitung Gaji</button>
                <a href="{{ route('admin.gaji.index') }}" class='btn btn-secondary'>Batal</a>
            </div>
        </form>
    </div>
@endsection