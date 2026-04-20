@extends('layouts.app')

@section('content')
    <div class="space-y-4">
        <h2 class="text-2xl font-semibold">Absensi Guru</h2>
        <div class="bg-white rounded shadow p-6">
            <form action="{{ route('guru.absensi.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block font-medium">Status</label>
                    <select name="status" class="w-full border rounded p-2" required>
                        <option value="hadir">Hadir</option>
                        <option value="izin">Izin</option>
                    </select>
                </div>
                <div>
                    <label class="block font-medium">Alasan (jika izin)</label>
                    <textarea name="alasan" rows="3" class="w-full border rounded p-2"></textarea>
                </div>
                <div>
                    <label class="block font-medium">Latitude</label>
                    <input type="text" name="latitude" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Longitude</label>
                    <input type="text" name="longitude" class="w-full border rounded p-2" required>
                </div>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Kirim Absensi</button>
            </form>
        </div>

        <div class="bg-white rounded shadow p-6">
            <h3 class="text-xl font-semibold mb-4">Riwayat Absensi</h3>
            @if($riwayat->isEmpty())
                <p>Tidak ada absensi.</p>
            @else
                <table class="min-w-full border rounded">
                    <thead>
                        <tr class="bg-slate-100 text-left">
                            <th class="px-4 py-2">Tanggal</th>
                            <th class="px-4 py-2">Jam Masuk</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Alasan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($riwayat as $absensi)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $absensi->tanggal->format('d/m/Y') }}</td>
                                <td class="px-4 py-2">{{ $absensi->jam_masuk }}</td>
                                <td class="px-4 py-2">{{ ucfirst($absensi->status) }}</td>
                                <td class="px-4 py-2">{{ $absensi->alasan ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">{{ $riwayat->links() }}</div>
            @endif
        </div>
    </div>
@endsection
