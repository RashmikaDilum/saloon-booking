<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\Stylist\DashboardController as StylistDashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Guest Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/gallery', function () {
    return view('gallery', ['images' => \App\Models\Gallery::where('is_active', true)->latest()->get()]);
})->name('gallery');
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');

// Hidden Admin Login Route
Route::get('/Admin', function () {
    return redirect()->route('login');
});
Route::get('/admin', function () {
    return redirect()->route('login');
});

// Booking Wizard Routes
Route::get('/book', [BookingController::class, 'index'])->name('booking.index');
Route::post('/book/confirm', [BookingController::class, 'store'])->name('booking.store');
Route::get('/book/confirmation/{id}', [BookingController::class, 'confirmation'])->name('booking.confirmation');

// Unified Dashboard redirect based on role
Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->isStylist()) {
        return redirect()->route('stylist.dashboard');
    }
    return redirect()->route('client.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Auth protected routes
Route::middleware('auth')->group(function () {
    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Client Dashboard & Appointments
    Route::middleware('role:client,admin')->group(function () {
        Route::get('/client/dashboard', [ClientDashboardController::class, 'index'])->name('client.dashboard');
    });

    // Stylist Dashboard & Schedule
    Route::middleware('role:stylist,admin')->group(function () {
        Route::get('/stylist/dashboard', [StylistDashboardController::class, 'index'])->name('stylist.dashboard');
    });

    // Admin Panel
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        
        // Admin CRUD Resources
        Route::get('/admin/services', function () {
            return view('admin.services');
        })->name('admin.services');
        
        Route::get('/admin/availability', function () {
            return view('admin.availability');
        })->name('admin.availability');

        Route::get('/admin/gallery', \App\Livewire\AdminGalleryManager::class)->name('admin.gallery');
        Route::get('/admin/stylists', \App\Livewire\AdminStylistManager::class)->name('admin.stylists');
    });
});

require __DIR__.'/auth.php';
