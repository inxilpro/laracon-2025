<?php

use App\Http\Controllers\HasCommaListController;
use App\Http\Controllers\HasLettersController;
use App\Http\Controllers\HasNearController;
use App\Http\Controllers\HasSpeakersController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/demo/1');

Route::get('/demo/1', HasSpeakersController::class);
Route::get('/demo/2', HasNearController::class);
Route::get('/demo/3', HasLettersController::class);
