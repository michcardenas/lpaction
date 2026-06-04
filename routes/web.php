<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CursoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('/login', 'auth.login')->name('login');

Route::get('/registro', [RegisterController::class, 'show'])->name('register');
Route::post('/registro', [RegisterController::class, 'store']);

// Curso (requiere sesión iniciada)
Route::get('/curso', [CursoController::class, 'index'])->name('curso')->middleware('auth');
Route::get('/curso/{ingreso}', [CursoController::class, 'etapa'])->name('curso.etapa')->middleware('auth');
