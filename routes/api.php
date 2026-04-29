<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransaksiController;
use App\Http\Middleware\AuthenticateApiToken;
use App\Http\Middleware\AuthorizeRole;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware([AuthenticateApiToken::class]);

Route::middleware([AuthenticateApiToken::class, AuthorizeRole::class.':customer'])->group(function () {
    Route::post('/transaksi', [TransaksiController::class, 'store']);
    Route::match(['put', 'patch'], '/transaksi/{transaksi}', [TransaksiController::class, 'update']);
    Route::get('/transaksi/{transaksi}', [TransaksiController::class, 'show']);
});

Route::middleware([AuthenticateApiToken::class, AuthorizeRole::class.':admin'])->group(function () {
    Route::get('/transaksi', [TransaksiController::class, 'index']);
    Route::delete('/transaksi/{transaksi}', [TransaksiController::class, 'destroy']);
});
