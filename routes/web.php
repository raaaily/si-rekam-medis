<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\RoleMiddleware;

// ==================================================
// 🏠 Halaman awal → redirect ke login
// ==================================================
Route::get('/', function () {
    return redirect('/login');
});

// ==================================================
// 🔐 AUTH (Login / Logout)
// ==================================================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

// ==================================================
// 🧭 Dashboard (semua user yang login bisa akses)
// ==================================================
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware('auth')->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

// ==================================================
// 👑 ADMIN SAJA
// ==================================================
Route::middleware(['auth', RoleMiddleware::class . ':admin'])->group(function () {

    // CRUD User → hanya create & store (nanti bisa dikembangkan)
    Route::resource('users', UserController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
});

// ==================================================
// 🧑‍⚕️ ADMIN + DOKTER
// ==================================================
Route::middleware(['auth', RoleMiddleware::class . ':admin,doctor'])->group(function () {

    // CRUD Pasien
    Route::resource('patients', PatientController::class);

    // ==================================================
    // 🩺 ASSESSMENT (nested di dalam pasien)
    // ==================================================

    // Daftar semua assessment (opsional)
    Route::get('/assessments', [AssessmentController::class, 'index'])->name('assessments.index');

    // Buat assessment baru untuk pasien tertentu
    Route::get('/patients/{patient}/assessments/create', [AssessmentController::class, 'create'])->name('assessments.create');

    // Simpan assessment baru
    Route::post('/assessments', [AssessmentController::class, 'store'])->name('assessments.store');

    // Detail assessment
    Route::get('/assessments/{assessment}', [AssessmentController::class, 'show'])->name('assessments.show');

    // Edit assessment
    Route::get('/assessments/{assessment}/edit', [AssessmentController::class, 'edit'])->name('assessments.edit');
    Route::put('/assessments/{assessment}', [AssessmentController::class, 'update'])->name('assessments.update');

    // Hapus assessment
    Route::delete('/assessments/{assessment}', [AssessmentController::class, 'destroy'])->name('assessments.destroy');

    // Riwayat assessment per pasien
    Route::get('/patients/{patient}/assessments/history', [AssessmentController::class, 'history'])->name('assessments.history');
});
