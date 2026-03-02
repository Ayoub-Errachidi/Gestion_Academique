<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\EnseignantController;


Route::resource('etudiants', EtudiantController::class);

Route::resource('enseignants', EnseignantController::class);

Route::put('/etudiants/{id}/restore', [EtudiantController::class, 'restore'])
    ->name('etudiants.restore');

Route::get('etudiants/stats', [EtudiantController::class, 'stats'])
    ->name('etudiants.stats');