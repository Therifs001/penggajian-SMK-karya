<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Gaji;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class SlipGajiController extends Controller
{
    public function pdf(Gaji $gaji)
    {
        // Pastikan guru hanya bisa melihat slip miliknya
        if ($gaji->user_id != Auth::id()) {
            abort(403);
        }

        $pdf = Pdf::loadView('guru.slip_gaji.pdf', compact('gaji'))
            ->setPaper('A4', 'portrait');

        return $pdf->download(
            'Slip-Gaji-' . $gaji->bulan . '.pdf'
        );
    }
}