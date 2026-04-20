<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAbsensiSettingRequest;
use App\Models\AbsensiSetting;

class AbsensiSettingController extends Controller
{
    public function index()
    {
        $setting = AbsensiSetting::latest()->first();

        return view('admin.absensi_setting.index', compact('setting'));
    }

    public function store(StoreAbsensiSettingRequest $request)
    {
        AbsensiSetting::updateOrCreate(
            ['id' => 1],
            $request->validated() + ['active' => $request->boolean('active')]
        );

        return redirect()->route('admin.absensi-setting.index')->with('success', 'Pengaturan absensi berhasil diperbarui.');
    }
}
