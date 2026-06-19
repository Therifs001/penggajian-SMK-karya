<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreGajiRequest;
use App\Models\Gaji;
use App\Models\User;
use App\Services\GajiCalculator;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class GajiController extends Controller
{
    public function index(Request $request)
    {
        return redirect()->route('admin.gaji-report.index');
    }

    public function create()
    {
        return redirect()->route('admin.gaji-report.index');
    }

    public function store(StoreGajiRequest $request, GajiCalculator $calculator)
    {
        $guru = User::findOrFail($request->user_id);

        $manualKehadiran = $request->filled('kehadiran') ? (int) $request->kehadiran : null;

        $subjectId = $request->filled('subject_id') ? (int) $request->subject_id : null;

        try {
            $calculator->store($guru, (float) $request->jam_mengajar, $manualKehadiran, null, $subjectId);
            return redirect()->route('admin.gaji-report.index')->with('success', 'Perhitungan gaji berhasil disimpan.');
        } catch (\Throwable $e) {
            return redirect()->route('admin.gaji-report.index')->with('error', 'Gagal menghitung gaji: ' . $e->getMessage());
        }
    }

    public function show(Gaji $gaji)
    {
        return redirect()->route('admin.gaji-report.index');
    }

    public function slipPdf(Gaji $gaji)
    {
        $pdf = Pdf::loadView('gaji.pdf-slip', compact('gaji'));

        return $pdf->download("slip-gaji-{$gaji->guru->name}-{$gaji->id}.pdf");
    }
}
