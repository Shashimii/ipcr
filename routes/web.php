<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AssignedDutyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DutyController;
use App\Http\Controllers\OfficerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Login

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        // 'canRegister' => Route::has('register'),
        // 'laravelVersion' => Application::VERSION,
        // 'phpVersion' => PHP_VERSION,
    ]);
});

// Admin

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/register', [RegisteredUserController::class, 'create'])->name('admin.register');
    Route::post('/admin/register', [RegisteredUserController::class, 'store'])->name('admin.register.store');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/assigned-duties', AssignedDutyController::class);
    Route::resource('/officers', OfficerController::class);
    Route::resource('/duties', DutyController::class);

});

// User

Route::middleware(['auth', 'user'])->group(function () {
    Route::resource('/tasks', TaskController::class);
});

// Email Verfication?

// Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
