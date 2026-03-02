<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EtudiantApiController;

Route::get('etudiants', [EtudiantApiController::class, 'index']);
Route::get('etudiants/{id}', [EtudiantApiController::class, 'show']);