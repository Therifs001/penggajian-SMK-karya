<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gaji;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class GajiReportController extends Controller
{
    public function index(Request $request)
    {
        $tz = config('app.timezone') ?: 'UTC';
        $q = Gaji::with('guru')->orderBy('bulan', 'desc');
        $bulan = $request->query('bulan', \Carbon\Carbon::now($tz)->format('Y-m'));
        if ($request->filled('bulan')) {
            $q->where('bulan', $bulan);
        }

        $gajis = $q->paginate(50)->withQueryString();

        return view('admin.gaji_report.index', compact('gajis'));
    }

    public function destroy(Gaji $gaji)
    {
        $gaji->delete();

        return redirect()->route('admin.gaji-report.index')->with('success', 'Data gaji berhasil dihapus.');
    }

    public function print(Request $request)
    {
        $tz = config('app.timezone') ?: 'UTC';
        $q = Gaji::with('guru')->orderBy('bulan', 'desc');
        $bulan = $request->query('bulan', \Carbon\Carbon::now($tz)->format('Y-m'));
        if ($request->filled('bulan')) {
            $q->where('bulan', $bulan);
        }

        $gajis = $q->get();

        $pdf = Pdf::loadView('admin.gaji_report.pdf', compact('gajis', 'bulan'));

        $filename = "laporan-gaji-{$bulan}.pdf";

        return $pdf->download($filename);
    }
}
