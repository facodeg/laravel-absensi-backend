<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IzinController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.auth.login');
});

Route::middleware(['auth'])->group(function () {
    // Route::get('/home', function () {
    //     return view('pages.dashboard', ['type_menu' => 'home']);
    // })->name('home');

    Route::get('/home', [DashboardController::class, 'index'])->name('home');

    Route::resource('users', UserController::class);

    //company
    Route::resource('companies', CompanyController::class);

    //attendance
    Route::resource('attendances', AttendanceController::class);

    //izin
    Route::resource('izins', IzinController::class);

    Route::resource('notes', NoteController::class);
    Route::resource('pegawais', PegawaiController::class);
});
