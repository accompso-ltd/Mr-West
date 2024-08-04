<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuotesController;
use App\Http\Middleware\EnsureTokenIsValid;

Route::get('/quotes', [QuotesController::class, 'show'])->middleware(EnsureTokenIsValid::class);