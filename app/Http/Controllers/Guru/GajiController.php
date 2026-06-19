<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Gaji;
use Illuminate\Support\Facades\Auth;

class GajiController extends Controller
{
    public function index()
    {
        $gurus = Auth::user();
        $history = Gaji::where('user_id', $gurus->id)
            ->latest()
            ->paginate(15);

        return view('guru.gaji.index', compact('history'));
    }

    public function show(Gaji $gaji)
    {
        if ($gaji->user_id !== Auth::id()) {
            abort(403);
        }

        return view('guru.gaji.show', compact('gaji'));
    }
}
