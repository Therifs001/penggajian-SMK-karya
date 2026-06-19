@extends('layouts.admin')

@section('title', 'Mata Pelajaran')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Mata Pelajaran</h3>
            <a href="{{ route('admin.subjects.create') }}" class="btn btn-primary">Tambah</a>
        </div>
        <div class="card-body">
            @if($subjects->isEmpty())
                <p>Tidak ada mata pelajaran.</p>
            @else
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($subjects as $subject)
                            <tr>
                                <td>{{ $subject->name }}</td>
                                <td>
                                    <a href="{{ route('admin.subjects.edit', $subject) }}" class="btn btn-sm btn-info">Edit</a>
                                    <form action="{{ route('admin.subjects.destroy', $subject) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3">{{ $subjects->links() }}</div>
            @endif
        </div>
    </div>
@endsection
