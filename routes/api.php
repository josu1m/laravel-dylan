<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\PruebaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/', [ChatController::class, 'index']);
Route::post('/chat', [ChatController::class, 'chat']);
Route::apiResource('pruebas', PruebaController::class);

