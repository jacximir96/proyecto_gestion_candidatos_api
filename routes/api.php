<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GenerarTokenEstacion;
use App\Http\Controllers\LeadController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(GenerarTokenEstacion::class)->group(function() {
    Route::post('/auth', 'IniciarGenerarTokenEstacionServicioAPI');
});

Route::controller(LeadController::class)->group(function(){
    Route::get('/leads','IniciarObtenerTodosCandidatosEstacionServicioAPI')->middleware('jwt.verify');
    Route::get('/lead/{id}', 'IniciarObtenerCandidatoEstacionServicioAPI')->middleware('jwt.verify');
    Route::post('/lead', 'IniciarCrearCandidatoEstacionServicioAPI')->middleware('jwt.verify:manager');
});