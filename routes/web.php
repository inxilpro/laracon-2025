<?php

use App\Http\Controllers\HasCommaListController;
use App\Http\Controllers\HasNearController;
use App\Http\Controllers\HasSpeakersController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/demo/1');

Route::get('/demo/1', HasSpeakersController::class);
Route::get('/demo/2', HasCommaListController::class);
Route::get('/demo/3', HasNearController::class);
