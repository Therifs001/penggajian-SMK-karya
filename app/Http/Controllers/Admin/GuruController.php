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
        $subjects = \App\Models\Subject::all();

        return view('admin.guru.index', compact('gurus', 'subjects'));
    }

    public function create()
    {
        $subjects = \App\Models\Subject::all();
        return view('admin.guru.create', compact('subjects'));
    }

    public function store(StoreGuruRequest $request)
    {
        $data = $request->validated();
        $data['role'] = 'guru';
        $data['password'] = Hash::make($data['password'] ?? 'password');

        $subjectsInput = $request->input('subjects', []);

        $guru = User::create($data);

        // subjectsInput can contain numeric IDs or new string names (from Select2 tags)
        $ids = [];
        foreach ($subjectsInput as $item) {
            if (is_numeric($item)) {
                $s = \App\Models\Subject::find($item);
                if ($s) $ids[] = $s->id;
            } else {
                $name = trim($item);
                if ($name === '') continue;
                $s = \App\Models\Subject::firstOrCreate(['name' => $name], ['jam' => 0]);
                $ids[] = $s->id;
            }
        }
        if (! empty($ids)) {
            $guru->subjects()->sync($ids);
        }

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil disimpan.');
    }

    public function edit(User $guru)
    {
        if ($guru->role !== 'guru') {
            abort(404);
        }

        $subjects = \App\Models\Subject::all();
        return view('admin.guru.edit', compact('guru', 'subjects'));
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

        $subjectsInput = $request->input('subjects', []);

        $guru->update($data);

        $ids = [];
        foreach ($subjectsInput as $item) {
            if (is_numeric($item)) {
                $s = \App\Models\Subject::find($item);
                if ($s) $ids[] = $s->id;
            } else {
                $name = trim($item);
                if ($name === '') continue;
                $s = \App\Models\Subject::firstOrCreate(['name' => $name], ['jam' => 0]);
                $ids[] = $s->id;
            }
        }
        if (! empty($ids)) {
            $guru->subjects()->sync($ids);
        } else {
            $guru->subjects()->detach();
        }

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
