<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EtudiantController;

Route::resource('etudiants', EtudiantController::class);

Route::put('/etudiants/{id}/restore', [EtudiantController::class, 'restore'])
    ->name('etudiants.restore');

Route::get('etudiants/stats', [EtudiantController::class, 'stats'])
    ->name('etudiants.stats');