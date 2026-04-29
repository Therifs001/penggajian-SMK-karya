@extends('layouts.admin')

@section('title', 'Edit Guru')

@section('content')
    <div class='card'>
        <div class='card-header'>
            <h3 class='card-title'>Edit Guru</h3>
        </div>
        <form action="{{ route('admin.guru.update', $guru) }}" method='POST'>
            @csrf
            @method('PUT')
            <div class='card-body'>
                <div class='form-group'>
                    <label>Nama</label>
                    <input type='text' name='name' value="{{ $guru->name }}" class='form-control' required>
                </div>
                <div class='form-group'>
                    <label>NIP</label>
                    <input type='text' name='nip' value="{{ $guru->nip }}" class='form-control' required>
                </div>
                <div class='form-group'>
                    <label>Mata Pelajaran</label>
                    <input type='text' name='matapelajaran' value="{{ $guru->matapelajaran }}" class='form-control' required>
                </div>
                <div class='form-group'>
                    <label>Status</label>
                    <select name='status' class='form-control' required>
                        <option value='aktif' {{ $guru->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value='nonaktif' {{ $guru->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
                <div class='form-group'>
                    <label>Email</label>
                    <input type='email' name='email' value="{{ $guru->email }}" class='form-control' required>
                </div>
            </div>
            <div class='card-footer'>
                <button type='submit' class='btn btn-primary'>Update</button>
                <a href="{{ route('admin.guru.index') }}" class='btn btn-secondary'>Batal</a>
            </div>
        </form>
    </div>
@endsection