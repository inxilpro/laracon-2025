<?php

use App\Http\Controllers\HasSpeakersController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/demo/1');

Route::get('/demo/1', HasSpeakersController::class);
