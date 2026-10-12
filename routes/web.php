<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/* Route for Home */
Route::view('/', 'pages.home')->name('home');

/* Route for AboutUs */
Route::view('/AboutUs', 'pages.about')->name('about');

Route::view('/FAQ', 'pages.faq')->name('faq');

/* Route for ContactUs */
Route::get('/ContactUs', function () {
    return 'ContactUs';
});

/* Route for Services */
Route::get('/Services', function () {
    return 'Services';
});

/* Route for dashboard */
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

/* Route for profile */
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/* Route for login */
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
