<?php

// use App\Http\Controllers\Auth\VerifyEmailController;
// use Illuminate\Support\Facades\Route;
// use Livewire\Volt\Volt;

// Route::middleware('guest')->group(function () {
//     Volt::route('register', 'pages.auth.register')
//         ->name('register');

//     Volt::route('login', 'pages.auth.login')
//         ->name('login');

//     Volt::route('forgot-password', 'pages.auth.forgot-password')
//         ->name('password.request');

//     Volt::route('reset-password/{token}', 'pages.auth.reset-password')
//         ->name('password.reset');
// });

// Route::middleware('auth')->group(function () {
//     Volt::route('verify-email', 'pages.auth.verify-email')
//         ->name('verification.notice');

//     Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
//         ->middleware(['signed', 'throttle:6,1'])
//         ->name('verification.verify');

//     Volt::route('confirm-password', 'pages.auth.confirm-password')
//         ->name('password.confirm');
// });

// 'guards' => [
//     'web' => [ ... ],
//     'student' => [
//         'driver' => 'session',
//         'provider' => 'student_logins',
//     ],
//     'parent' => [
//         'driver' => 'session',
//         'provider' => 'parent_logins',
//     ],
// ],

// 'providers' => [
//     'users' => [
//         'driver' => 'eloquent',
//         'model' => App\Models\User::class,
//     ],
//     'student_logins' => [
//         'driver' => 'eloquent',
//         'model' => App\Models\StudentLogin::class,
//     ],
//     'parent_logins' => [
//         'driver' => 'eloquent',
//         'model' => App\Models\ParentLogin::class,
//     ],
// ],

use App\Http\Controllers\Auth\Student\StudentLoginController;
use App\Http\Controllers\Auth\Parent\ParentLoginController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Route;


// Route auth default untuk Guru BK (web)
Route::middleware('guest')->group(function () {
    Volt::route('register', 'pages.auth.register')->name('register');
    Volt::route('login', 'pages.auth.login')->name('login');
    Volt::route('forgot-password', 'pages.auth.forgot-password')->name('password.request');
    Volt::route('reset-password/{token}', 'pages.auth.reset-password')->name('password.reset');
});

// Route auth siswa
Route::prefix('siswa')->name('student.')->group(function () {
    Route::get('/login', [StudentLoginController::class, 'showLoginForm'])->middleware('guest:student')->name('login');
    Route::post('/login', [StudentLoginController::class, 'login'])->name('login.submit');
    Route::post('/logout', [StudentLoginController::class, 'logout'])->name('logout');

    Route::middleware('auth:student')->group(function () {
        Route::get('/dashboard', fn() => view('pages.student.dashboard'))->name('dashboard');
    });
});

// Route auth orang tua
Route::prefix('orangtua')->name('parent.')->group(function () {
    Route::get('/login', [ParentLoginController::class, 'showLoginForm'])->middleware('guest:parent')->name('login');
    Route::post('/login', [ParentLoginController::class, 'login'])->name('login.submit');
    Route::post('/logout', [ParentLoginController::class, 'logout'])->name('logout');

    Route::middleware('auth:parent')->group(function () {
        Route::get('/dashboard', fn() => view('pages.parent.dashboard'))->name('dashboard');
    });
});
