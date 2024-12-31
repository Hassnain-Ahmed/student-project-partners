<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PartnerRequestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/



// Guest Routes (Only accessible when not logged in)
Route::middleware('guest')->group(function () {

    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store'])->name("register.post");


    Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store'])->name("login.post");
});


Route::middleware(['auth'])->group(function () {

    Route::get('/profile-setup', [ProfileController::class, 'create'])->name('profile.setup');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    Route::prefix('requests')->name('requests.')->group(function () {

        Route::post('/send', [PartnerRequestController::class, 'store'])->name('send');

        Route::post('/{request}/accept', [PartnerRequestController::class, 'accept'])->name('accept');
        Route::post('/{request}/reject', [PartnerRequestController::class, 'reject'])->name('reject');
    });

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

Route::fallback(function () {
    return redirect()->route('login');
});
