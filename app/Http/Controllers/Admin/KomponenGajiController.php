<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreKomponenGajiRequest;
use App\Models\KomponenGaji;
use App\Models\User;

class KomponenGajiController extends Controller
{
    public function index()
    {
        $komponens = KomponenGaji::with('guru')->latest()->paginate(15);

        return view('admin.komponen_gaji.index', compact('komponens'));
    }

    public function create()
    {
        $gurus = User::where('role', 'guru')->orderBy('name')->get();

        return view('admin.komponen_gaji.create', compact('gurus'));
    }

    public function store(StoreKomponenGajiRequest $request)
    {
        $data = $request->validated();
        $data['honor_per_hadir'] = $data['honor_per_hadir'] ?? 0;
        $data['honor_per_jam'] = $data['honor_per_jam'] ?? 0;
        $data['transport'] = $data['transport'] ?? 0;
        $data['bpjs'] = $data['bpjs'] ?? 0;
        $data['potongan_lain'] = $data['potongan_lain'] ?? 0;

        KomponenGaji::updateOrCreate(
            ['user_id' => $request->user_id],
            $data
        );

        return redirect()->route('admin.komponen-gaji.index')->with('success', 'Komponen gaji berhasil disimpan.');
    }

    public function edit(KomponenGaji $komponen_gaji)
    {
        $gurus = User::where('role', 'guru')->orderBy('name')->get();

        return view('admin.komponen_gaji.edit', compact('komponen_gaji', 'gurus'));
    }

    public function update(StoreKomponenGajiRequest $request, KomponenGaji $komponen_gaji)
    {
        $data = $request->validated();
        $data['honor_per_hadir'] = $data['honor_per_hadir'] ?? 0;
        $data['honor_per_jam'] = $data['honor_per_jam'] ?? 0;
        $data['transport'] = $data['transport'] ?? 0;
        $data['bpjs'] = $data['bpjs'] ?? 0;
        $data['potongan_lain'] = $data['potongan_lain'] ?? 0;

        $komponen_gaji->update($data);

        return redirect()->route('admin.komponen-gaji.index')->with('success', 'Komponen gaji berhasil diperbarui.');
    }

    public function destroy(KomponenGaji $komponen_gaji)
    {
        $komponen_gaji->delete();

        return redirect()->route('admin.komponen-gaji.index')->with('success', 'Komponen gaji berhasil dihapus.');
    }
}
