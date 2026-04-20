<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreGuruRequest;
use App\Http\Requests\Admin\UpdateGuruRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    public function index()
    {
        $gurus = User::where('role', 'guru')->latest()->paginate(15);

        return view('admin.guru.index', compact('gurus'));
    }

    public function create()
    {
        return view('admin.guru.create');
    }

    public function store(StoreGuruRequest $request)
    {
        $data = $request->validated();
        $data['role'] = 'guru';
        $data['password'] = Hash::make($data['password'] ?? 'password');

        User::create($data);

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil disimpan.');
    }

    public function edit(User $guru)
    {
        if ($guru->role !== 'guru') {
            abort(404);
        }

        return view('admin.guru.edit', compact('guru'));
    }

    public function update(UpdateGuruRequest $request, User $guru)
    {
        if ($guru->role !== 'guru') {
            abort(404);
        }

        $data = $request->validated();

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $guru->update($data);

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy(User $guru)
    {
        if ($guru->role !== 'guru') {
            abort(404);
        }

        $guru->delete();

        return redirect()->route('admin.guru.index')->with('success', 'Guru berhasil dihapus.');
    }
}
