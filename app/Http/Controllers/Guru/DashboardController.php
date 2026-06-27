<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\AbsensiSetting;
use App\Models\Gaji;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $guru = Auth::user();

        $setting = AbsensiSetting::where('active', true)
            ->latest()
            ->first();

        // Semua riwayat gaji untuk dropdown
        $riwayatGaji = Gaji::where('user_id', $guru->id)
            ->orderByDesc('bulan')
            ->get();

        // Ambil bulan dari request, jika tidak ada gunakan bulan terbaru
        $bulan = $request->bulan;

        if (!$bulan && $riwayatGaji->isNotEmpty()) {
            $bulan = $riwayatGaji->first()->bulan;
        }

        // Ambil gaji sesuai bulan yang dipilih
        $gajiTerakhir = Gaji::where('user_id', $guru->id)
            ->where('bulan', $bulan)
            ->first();

        return view('guru.index', compact(
            'setting',
            'gajiTerakhir',
            'riwayatGaji',
            'bulan'
        ));
    }
}