<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'nip' => 'required|string|max:255',
        'matapelajaran' => 'required|string|max:255',
        'status' => 'required|string|max:255',
        'role' => 'required|in:admin,guru',
        'email' => 'required|email|max:255|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
    ]);

    User::create([
        'name' => $validated['name'],
        'nip' => $validated['nip'],
        'matapelajaran' => $validated['matapelajaran'],
        'status' => $validated['status'],
        'role' => $validated['role'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
    ]);

    return redirect()->route('login')->with('success', 'Registrasi berhasil. Silakan login.');
})->name('register.perform');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string',
    ]);

    if (!Auth::attempt($credentials)) {
        return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
    }

    $request->session()->regenerate();

    return redirect()->intended(Auth::user()->role === 'admin' ? route('admin.index') : route('guru.index'));
});

Route::get('/guru', function () {
    return view('guru.index');
})->name('guru.index');

Route::get('/admin', function () {
    return view('admin.index');
})->name('admin.index');