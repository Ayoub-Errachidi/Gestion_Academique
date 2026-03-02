<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EtudiantController;

Route::resource('etudiants', EtudiantController::class);