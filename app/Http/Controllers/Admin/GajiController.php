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
        $query = Gaji::with('guru');

        if ($request->filled('guru_id')) {
            $query->where('user_id', $request->guru_id);
        }

        if ($request->filled('periode')) {
            $query->where('periode', $request->periode);
        }

        $gajis = $query->latest()->paginate(15);
        $gurus = User::where('role', 'guru')->orderBy('name')->get();

        return view('admin.gaji.index', compact('gajis', 'gurus'));
    }

    public function create()
    {
        $gurus = User::where('role', 'guru')->orderBy('name')->get();

        return view('admin.gaji.create', compact('gurus'));
    }

    public function store(StoreGajiRequest $request, GajiCalculator $calculator)
    {
        $guru = User::findOrFail($request->user_id);

        $gaji = $calculator->store($guru, $request->periode, (float) $request->jam_mengajar);

        return redirect()->route('admin.gaji.show', $gaji)->with('success', 'Perhitungan gaji berhasil disimpan.');
    }

    public function show(Gaji $gaji)
    {
        return view('admin.gaji.show', compact('gaji'));
    }

    public function slipPdf(Gaji $gaji)
    {
        $pdf = Pdf::loadView('gaji.pdf-slip', compact('gaji'));

        return $pdf->download("slip-gaji-{$gaji->guru->name}-{$gaji->periode}.pdf");
    }
}
