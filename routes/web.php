<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ExportController;
use Illuminate\Support\Facades\Route;

// Public routes (accessible to everyone)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');

// Protected routes (require authentication)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    // API Dashboard - real-time student data from REST API
    Route::get('/api-dashboard', function () {
        return view('api-dashboard');
    })->name('api.dashboard');
    
    // Export routes
    Route::get('/students/export/csv', [ExportController::class, 'exportAllStudentsCSV'])->name('students.export.all');
    Route::get('/students/export/csv/filtered', [ExportController::class, 'exportStudentsCSV'])->name('students.export.filtered');
    
    // Students CRUD - only for logged-in users
    Route::resource('students', StudentController::class);
});

// Profile routes (from Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes (we'll create this later)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

require __DIR__.'/auth.php';