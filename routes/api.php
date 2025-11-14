<?php

use App\Http\Controllers\API\EventAPIController;
use App\Http\Controllers\API\ParticipantAPIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rutas para administración de eventos
Route::resource('events'      , EventAPIController::class)->except('edit');
// Rutas para administración de participantes
Route::resource('participants', ParticipantAPIController::class)->except('edit');
// Ruta para agregar participantes a un evento
Route::post('events/{eventId}/participants', [EventAPIController::class, 'registerParticipant']);
// Ruta para ver las estadísticas de un evento
Route::get('events/{eventId}/statistics', [EventAPIController::class, 'statistics']);
