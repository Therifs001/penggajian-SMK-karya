<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Http\Request;

class AbsensiReportController extends Controller
{
    public function index(Request $request)
    {
        $tz = config('app.timezone') ?: 'UTC';
        $date = $request->query('date', \Carbon\Carbon::now($tz)->toDateString());

        $records = Absensi::with('guru')
            ->whereDate('tanggal', $date)
            ->orderBy('jam_masuk')
            ->get();

        return view('admin.absensi_report.index', compact('date', 'records'));
    }
}
