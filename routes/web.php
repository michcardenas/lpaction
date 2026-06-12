<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CursoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('/login', 'auth.login')->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

Route::get('/registro', [RegisterController::class, 'show'])->name('register');
Route::post('/registro', [RegisterController::class, 'store']);

// Curso (requiere sesión iniciada)
Route::middleware('auth')->group(function () {
    Route::get('/curso', [CursoController::class, 'index'])->name('curso');
    Route::get('/evaluacion', [CursoController::class, 'evaluacion'])->name('evaluacion');
    Route::post('/curso/{ingreso}/avanzar', [CursoController::class, 'avanzar'])->name('curso.avanzar');
    Route::post('/curso/{ingreso}/reiniciar', [CursoController::class, 'reiniciar'])->name('curso.reiniciar');
    Route::get('/curso/{ingreso}/{etapa?}', [CursoController::class, 'etapa'])->name('curso.etapa');
});
