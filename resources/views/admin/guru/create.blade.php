@extends('layouts.admin')

@section('title', 'Tambah Guru')

@section('content')
    <div class='card'>
        <div class='card-header'>
            <h3 class='card-title'>Tambah Guru</h3>
        </div>
        <form action="{{ route('admin.guru.store') }}" method='POST'>
            @csrf
            <div class='card-body'>
                <div class='form-group'>
                    <label>Nama</label>
                    <input type='text' name='name' value="{{ old('name') }}" class='form-control' required>
                </div>
                <div class='form-group'>
                    <label>NIP</label>
                    <input type='text' name='nip' value="{{ old('nip') }}" class='form-control' required>
                </div>
                <div class='form-group'>
                    <label>Mata Pelajaran</label>
                    <input type='text' name='matapelajaran' value="{{ old('matapelajaran') }}" class='form-control' required>
                </div>
                <div class='form-group'>
                    <label>Status</label>
                    <select name='status' class='form-control' required>
                        <option value='aktif'>Aktif</option>
                        <option value='nonaktif'>Nonaktif</option>
                    </select>
                </div>
                <div class='form-group'>
                    <label>Email</label>
                    <input type='email' name='email' value="{{ old('email') }}" class='form-control' required>
                </div>
                <div class='form-group'>
                    <label>Password</label>
                    <input type='password' name='password' class='form-control' required>
                </div>
            </div>
            <div class='card-footer'>
                <button type='submit' class='btn btn-primary'>Simpan</button>
                <a href="{{ route('admin.guru.index') }}" class='btn btn-secondary'>Batal</a>
            </div>
        </form>
    </div>
@endsection