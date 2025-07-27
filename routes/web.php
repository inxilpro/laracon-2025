<?php

use App\Http\Controllers\AvatarController;
use App\Http\Controllers\HasFakerController;
use App\Http\Controllers\HasLettersController;
use App\Http\Controllers\HasNearController;
use App\Http\Controllers\HasPredictedEventsController;
use App\Http\Controllers\HasSpeakersController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/demo/1');

Route::get('/demo/1', HasSpeakersController::class);
Route::get('/demo/2', HasNearController::class);
Route::get('/demo/3', HasFakerController::class);
Route::get('/demo/4', HasLettersController::class);
Route::get('/demo/5', HasPredictedEventsController::class);

Route::get('avatar', AvatarController::class);
