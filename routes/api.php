<?php

use App\Http\Controllers\MpesaController;
use Illuminate\Support\Facades\Route;

Route::post('/mpesa/callback', [MpesaController::class, 'callback'])->name('api.mpesa.callback');
Route::post('/mpesa/query/{payment}', [MpesaController::class, 'query'])->name('api.mpesa.query');
