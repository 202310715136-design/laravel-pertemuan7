<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransaksiController;
use App\Http\Middleware\AuthenticateApiToken;
use App\Http\Middleware\AuthorizeRole;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/login', [AuthController::class, 'login'])
    ->withoutMiddleware([VerifyCsrfToken::class]);

Route::post('/logout', [AuthController::class, 'logout'])
    ->withoutMiddleware([VerifyCsrfToken::class])
    ->middleware([AuthenticateApiToken::class]);

Route::middleware([AuthenticateApiToken::class, AuthorizeRole::class.':customer'])
    ->withoutMiddleware([VerifyCsrfToken::class])
    ->group(function () {
        Route::post('/transaksi', [TransaksiController::class, 'store']);
        Route::match(['put', 'patch'], '/transaksi/{transaksi}', [TransaksiController::class, 'update']);
        Route::get('/transaksi/{transaksi}', [TransaksiController::class, 'show']);
    });

Route::middleware([AuthenticateApiToken::class, AuthorizeRole::class.':admin'])
    ->withoutMiddleware([VerifyCsrfToken::class])
    ->group(function () {
        Route::get('/transaksi', [TransaksiController::class, 'index']);
        Route::delete('/transaksi/{transaksi}', [TransaksiController::class, 'destroy']);
    });
