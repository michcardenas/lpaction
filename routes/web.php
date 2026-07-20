<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\PerfilController;
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
    Route::view('/tutoria', 'tutoria')->name('tutoria');
    Route::view('/autores', 'autores')->name('autores');
    Route::get('/perfil', [PerfilController::class, 'show'])->name('perfil');
    Route::put('/perfil/password', [PerfilController::class, 'updatePassword'])->name('perfil.password');
    Route::get('/evaluacion', [CursoController::class, 'evaluacion'])->name('evaluacion');
    Route::post('/evaluacion/comenzar', [CursoController::class, 'evaluacionComenzar'])->name('evaluacion.comenzar');
    Route::get('/evaluacion/pregunta', [CursoController::class, 'evaluacionPregunta'])->name('evaluacion.pregunta');
    Route::post('/evaluacion/responder', [CursoController::class, 'evaluacionResponder'])->name('evaluacion.responder');
    Route::get('/evaluacion/resultado', [CursoController::class, 'evaluacionResultado'])->name('evaluacion.resultado');
    Route::get('/encuesta', [CursoController::class, 'encuesta'])->name('encuesta');
    Route::post('/encuesta', [CursoController::class, 'encuestaGuardar'])->name('encuesta.guardar');
    Route::post('/curso/{ingreso}/marcar', [CursoController::class, 'marcar'])->name('curso.marcar');
    Route::post('/curso/{ingreso}/avanzar', [CursoController::class, 'avanzar'])->name('curso.avanzar');
    Route::post('/curso/{ingreso}/reiniciar', [CursoController::class, 'reiniciar'])->name('curso.reiniciar');
    Route::get('/curso/{ingreso}/{etapa?}', [CursoController::class, 'etapa'])->name('curso.etapa');
});
