@extends('layouts.admin')

@section('title', 'Tambah Mata Pelajaran')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tambah Mata Pelajaran</h3>
        </div>
        <form action="{{ route('admin.subjects.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Jam per Pertemuan (contoh: 1.5 untuk 1 jam 30 menit)</label>
                    <input type="number" step="0.25" name="jam" class="form-control" placeholder="Kosongkan jika tidak ada">
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.subjects.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@endsection
