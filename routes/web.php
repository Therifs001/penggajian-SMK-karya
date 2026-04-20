<?php

use App\Http\Controllers\Admin\AbsensiSettingController;
use App\Http\Controllers\Admin\GajiController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\KomponenGajiController;
use App\Http\Controllers\Guru\AbsensiController as GuruAbsensiController;
use App\Http\Controllers\Guru\GajiController as GuruGajiController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::get('/test-login', function () {
    $user = \App\Models\User::where('email', 'admin@example.com')->first();
    if ($user) {
        \Illuminate\Support\Facades\Auth::login($user);
        return redirect('/admin');
    }
    return 'User not found';
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
        'email' => 'required|string',
        'password' => 'required|string',
    ]);

    $loginField = filter_var($credentials['email'], FILTER_VALIDATE_EMAIL) ? 'email' : 'nip';
    $attemptData = [$loginField => $credentials['email'], 'password' => $credentials['password']];

    if (!Auth::attempt($attemptData)) {
        return back()->withErrors(['email' => 'Email/NIP atau password salah.'])->withInput();
    }

    $request->session()->regenerate();

    return redirect()->intended(Auth::user()->role === 'admin' ? route('admin.index') : route('guru.index'));
});

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
})->name('logout');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return view('admin.index');
    })->name('index');
    Route::resource('guru', GuruController::class);
    Route::resource('komponen-gaji', KomponenGajiController::class);
    Route::resource('absensi-setting', AbsensiSettingController::class)->only(['index', 'store']);
    Route::resource('gaji', GajiController::class)->only(['index', 'create', 'store', 'show']);
    Route::get('gaji/{gaji}/slip-pdf', [GajiController::class, 'slipPdf'])->name('gaji.slip-pdf');
});

Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/', function () {
        return view('guru.index');
    })->name('index');
    Route::get('absensi', [GuruAbsensiController::class, 'index'])->name('absensi.index');
    Route::post('absensi', [GuruAbsensiController::class, 'store'])->name('absensi.store');
    Route::get('gaji', [GuruGajiController::class, 'index'])->name('gaji.index');
    Route::get('gaji/{gaji}', [GuruGajiController::class, 'show'])->name('gaji.show');
});